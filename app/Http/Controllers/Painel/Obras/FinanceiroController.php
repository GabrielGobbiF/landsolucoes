<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Exports\ObraFinanceiroExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceObraResource;
use App\Models\Client;
use App\Models\Obra;
use App\Models\ObraEtapasFinanceiro;
use App\Models\ObraFinanceiro;
use App\Services\Etapas\FinanceiroService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FinanceiroController extends Controller
{
    protected $repository;

    public function __construct(Obra $obra, private FinanceiroService $financeiroService)
    {
        $this->middleware('role:finance');
        $this->repository = $obra;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $clients = Client::all();

        $filter = $request->all();

        $finances = [];

        $obras = Obra::where(function ($query) use ($filter) {
            if (isset($filter['obr_name']) && $filter['obr_name'] != '') {
                return $query->where('razao_social', 'LIKE', '%' . $filter['obr_name'] . '%');
            }
        })->where(function ($query) use ($filter) {
            if (!empty($filter['clients'])) {
                $query->where('client_id', $filter['clients']);
            }
        })

            ->where(function ($query) use ($filter) {
                //$query->where('status', 'aprovada');
                //$query->orWhere('status', 'concluida');
            })
            ->whereNull('remove_finance')
            ->with('financeiro', 'client')
            ->whereNull('obras.deleted_at')
            ->whereIn('obras.status', ['aprovada'])
            ->where('obras.status', '<>', 'concluida')


            ->when(
                !empty($filter['faturar']),
                function ($q) {
                    $q->whereHas('financeiro', function ($qf) {
                        $qf->where('total_a_faturar', '>', 0);
                    });
                }
            )

            ->when(
                !empty($filter['receber']),
                function ($q) {
                    $q->whereHas('financeiro', function ($qf) {
                        $qf->where('a_receber', '>', 0);
                    });
                }
            )

            ->when(
                !empty($filter['vencimento']),
                function ($q) {
                    $q->whereHas('financeiro', function ($qf) {
                        $qf->where('vencidas', '>', 0);
                    });
                }
            )

            ->get(['razao_social', 'id', 'last_note', 'status', 'client_id']);

        return view('pages.painel.obras.finances.index', [
            #'finances' => $finances,
            'clients' => $clients,
            'obras' => $obras
        ]);
    }

    public function getAll(Request $request)
    {
        $filter = $request->all();
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $query = $this->repository
            ->select(['id', 'razao_social', 'last_note', 'status', 'client_id'])
            ->whereNull('remove_finance')
            ->whereNull('obras.deleted_at')
            ->whereIn('obras.status', ['aprovada'])
            ->where('obras.status', '<>', 'concluida')
            ->with([
                'financeiro',
                'client:id,company_name',
                'etapas_financeiro.faturamento',
            ])
            ->when(
                !empty($filter['obr_name']),
                fn($q) =>
                $q->where('razao_social', 'LIKE', '%' . $filter['obr_name'] . '%')
            )
            ->when(
                !empty($filter['clients']),
                fn($q) =>
                $q->where('client_id', $filter['clients'])
            );

        $obras = $query->paginate($perPage, ['*'], 'page', $page);

        $finances = [];

        foreach ($obras as $obra) {
            if (!$obra->financeiro) continue;

            $valorNegociadoObra = $obra->financeiro->valor_negociado ?? 0;
            $etapas = $obra->etapas_financeiro()->with('faturamento')->get();

            $totalFaturado = 0;
            $saldoAFaturar = 0;
            $totalRecebido = 0;
            $totalReceber = 0;
            $vencidas = 0;
            $data_vencimento = '';

            foreach ($etapas as $etapa) {
                $status = $etapa->StatusEtapa;
                $etapaValor = $status['text'] != 'EM' ? $etapa->valor_receber : 0;

                $etapaFaturado = $etapa->faturado();
                $etapaRecebido = $etapa->recebido();
                $etapaAReceber = $etapa->aReceber();
                $etapaVencidas = $etapa->vencidas();

                $totalFaturado += $etapaFaturado;
                $saldoAFaturar += ($etapaValor != '0') ? $etapaValor - $etapaFaturado : 0;
                $totalRecebido += $etapaRecebido;
                $totalReceber  += $etapaAReceber?->sum ?? 0;

                if ($etapaVencidas && $etapaVencidas->qnt != '') {
                    $vencidas += $etapaVencidas->qnt;
                    $data_vencimento = $etapaVencidas->data_vencimento ?? '';
                }
            }

            if (
                ($valorNegociadoObra - $totalFaturado == 0 && $totalReceber == 0) ||
                ($totalReceber == 0 && $obra->status == 'concluida')
            ) {
                continue;
            }

            $finances[] = [
                'valor_negociado' => $valorNegociadoObra,
                'obraId' => $obra->id,
                'n_nota' => $obra->last_note,
                'nome_obra' => $obra->razao_social,
                'total_faturado' => $totalFaturado,
                'total_a_faturar' => $saldoAFaturar,
                'total_recebido' => $totalRecebido,
                'total_receber' => $totalReceber,
                'saldo' => $valorNegociadoObra - $totalFaturado,
                'vencidas' => $vencidas,
                'data_vencimento' => $data_vencimento,
                'client_name' => limit($obra->client->company_name),
            ];
        }

        $finances = collect($finances);

        // 🔍 filtros pós-processamento
        if (isset($filter['faturar'])) {
            $finances = $finances->where('total_a_faturar', '<>', 0);
        }

        if (isset($filter['receber'])) {
            $finances = $finances->where('total_receber', '<>', 0);
        }

        if (isset($filter['vencimento'])) {
            $finances = $finances->where('vencidas', '<>', 0);
        }

        // 🔄 paginação correta sobre o resultado final
        $total = $finances->count();
        $results = $finances->forPage($page, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            FinanceObraResource::collection($results),
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return $paginator;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function show(int $obraId)
    {
        $faturamento = [];

        if (!$obra = $this->repository->with('address')->with('client')->with('financeiro')->find($obraId)) {
            return redirect()
                ->route('obras.index')
                ->with('message', 'Registro não encontrado!');
        }

        if (!$obra->financeiro) {
            return redirect()
                ->route('comercial.show', $obraId)
                ->with('message', 'Atualize o financeiro primeiro!');
        }

        #$etapas_faturamento = $obra->etapas_financeiro()->with('faturamento')->get();

        $etapasFinanceiras = ObraEtapasFinanceiro::where('obra_id', $obraId)
            #->where('id', 3)
            ->with('faturamento')
            ->get();

        $dadosFinanceirosCollection = [];

        foreach ($etapasFinanceiras as $etapa) {
            $dadosFinanceirosCollection[$etapa->id] = $this->financeiroService
                ->calcularInfoFinanceira($etapa->id);
        }

        $dadosFinanceirosCollection = collect($dadosFinanceirosCollection);

        #foreach ($etapas_faturamento as $etapa_faturamento) {
        #$r = $etapa_faturamento->aReceber();
        #$d = $etapa_faturamento->vencidas();

        #$etapa = $etapa_faturamento->StatusEtapa;

        #$valor_etapa = $etapa_faturamento->valor_receber;

        #$etapaFaturado = $etapa_faturamento->faturado();
        #$etapaRecebido = $etapa_faturamento->recebido();
        #$qntVencidas = $d->qnt;
        #$dataVencimento = $r->data_vencimento;
        #$totalAReceber = $r->sum;

        #$faturamento[] = [
        #    'id' => $etapa_faturamento->id,
        #    'nome_etapa' => $etapa['nome'],
        #    'valor_etapa' => $valor_etapa,
        #    'total_faturado' => $etapaFaturado,
        #    'total_a_faturar' => $valor_etapa != '0' ? maskPrice($valor_etapa - $etapaFaturado) : '0',
        #    'qnt_vencidas' => $qntVencidas,
        #    'dataVencimento' => $dataVencimento,
        #    'total_receber' => $totalAReceber,
        #    'status' => $etapa['text'],
        #    'label' => $etapa['label'],
        #    'recebido' => $etapaRecebido,
        #];
        #}

        return view('pages.painel.obras.obras.financeiro.index', [
            'obra' => $obra,
            'faturamento' => $faturamento,
            'dadosFinanceirosCollection' => $dadosFinanceirosCollection,
        ]);
    }

    public function export(Request $request)
    {
        $filter = $request->all();

        return Excel::download(new ObraFinanceiroExport($filter), 'obras.xlsx');
    }
}
