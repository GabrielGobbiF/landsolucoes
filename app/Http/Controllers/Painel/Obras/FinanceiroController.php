<?php

namespace App\Http\Controllers\Painel\Obras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Obra;
use App\Models\ObraEtapasFinanceiro;
use App\Services\Etapas\FinanceiroService;
use Illuminate\Support\Facades\DB;

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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::all();

        $filter = $request->all();

        $finances = [];

        $obras = $this->repository->where(function ($query) use ($filter) {
            if (isset($filter['obr_name']) && $filter['obr_name'] != '') {
                return $query->where('razao_social', 'LIKE', '%' . $filter['obr_name'] . '%');
            }
        })->where(function ($query) use ($filter) {
            if (!empty($filter['clients'])) {
                $query->where('client_id', $filter['clients']);
            }
        })

            ->where(function ($query) use ($filter) {
                $query->where('status', 'aprovada');
                $query->orWhere('status', 'concluida');
            })
            ->whereNull('remove_finance')
            ->with('financeiro', 'client', 'etapas')
            ->whereNull('obras.deleted_at')
            ->whereIn('obras.status', ['aprovada'])
            ->where('obras.status', '<>', 'concluida')
            //->limit(200)
            ->get(['razao_social', 'id', 'last_note', 'status', 'client_id']);


        foreach ($obras as $obra) {
            if (!$obra->financeiro) {
                continue;
            }
            $totalFaturado = 0;
            $saldoAFaturar = 0;
            $totalRecebido = 0;
            $totalReceber = 0;
            $aReceber = 0;
            $data_vencimento = '';
            $valorNegociadoObra = $obra->financeiro ? $obra->financeiro->valor_negociado : 0;

            $etapas = $obra->etapas_financeiro()->with('faturamento')->get();

            if ($etapas) {
                $vencidas = 0;

                foreach ($etapas as $etapa) {
                    $status = $etapa->StatusEtapa;
                    if (!$status) {
                        $status['text'] = '';
                    }
                    $etapaValor = $status['text'] != 'EM' ? $etapa->valor_receber : 0;
                    $etapaFaturado = $etapa->faturado();
                    $etapaRecebido = $etapa->recebido();
                    $etapaAReceber = $etapa->aReceber();
                    $etapaVencidas = $etapa->vencidas();

                    if ($etapaAReceber) {
                        $aReceber = $etapaAReceber->sum;
                    }

                    if ($etapaVencidas && $etapaVencidas->qnt != '') {
                        $vencidas += $etapaVencidas->qnt;
                        $data_vencimento = $etapaVencidas->data_vencimento != '' ? $etapaVencidas->data_vencimento : null;
                    }

                    $totalFaturado += $etapaFaturado;
                    $saldoAFaturar += $etapaValor != '0' ? $etapaValor - $etapaFaturado : '0';
                    $totalRecebido += $etapaRecebido;
                    $totalReceber  += $aReceber;
                }
            }


            if (
                $valorNegociadoObra - $totalFaturado == 0
                && $totalReceber == 0
            ) {
                continue;
            }

            if ($totalReceber == 0 && $obra->status == 'concluida') {
                continue;
            }

            $finances[$obra->id]['valor_negociado'] = $valorNegociadoObra;
            $finances[$obra->id]['obraId'] = $obra->id;
            $finances[$obra->id]['n_nota'] = $obra->last_note;
            $finances[$obra->id]['nome_obra'] = $obra->razao_social;
            $finances[$obra->id]['total_faturado'] = $totalFaturado;
            $finances[$obra->id]['total_a_faturar'] = $saldoAFaturar;
            $finances[$obra->id]['total_recebido'] = $totalRecebido;
            $finances[$obra->id]['total_receber'] = $totalReceber;
            $finances[$obra->id]['saldo'] = $valorNegociadoObra - $totalFaturado;
            $finances[$obra->id]['vencidas'] = $vencidas;
            $finances[$obra->id]['data_vencimento'] = $data_vencimento;
            $finances[$obra->id]['client_name'] = limit($obra->client->company_name);
        }

        $finances =  collect($finances);

        if (isset($filter['faturar'])) {
            $finances = $finances->where('total_a_faturar', '<>', 0);
        }

        if (isset($filter['receber'])) {
            $finances = $finances->where('total_receber', '<>', 0);
        }

        if (isset($filter['vencimento'])) {
            $finances = $finances->where('vencidas', '<>', 0);
        }

        return view('pages.painel.obras.finances.index', [
            'finances' => $finances,
            'clients' => $clients,
        ]);
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
                ->route('obras')
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
}
