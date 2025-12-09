<?php

namespace App\Http\Controllers\Painel\Relatorios;

use App\Http\Controllers\Controller;
use App\Http\Resources\RelatorioFinanceiroResource;
use App\Models\Obra;
use App\Models\ObraEtapasFinanceiro;
use App\Models\EtapasFaturamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioFinanceiroController extends Controller
{
    public function index()
    {
        return view('pages.relatorios.financeiro.index');
    }

    public function getData(Request $request)
    {
        $tipo = $request->input('tipo', 'a_receber');
        $agruparPorObra = $request->input('agrupar_por_obra', false);
        $search = $request->input('search');
        $obraId = $request->input('obra_id');
        $etapaId = $request->input('etapa_id');
        $perPage = $request->input('per_page', 15);

        if ($tipo === 'a_receber') {
            return $this->getAReceber($request, $agruparPorObra, $search, $obraId, $etapaId, $perPage);
        } elseif ($tipo === 'a_faturar') {
            return $this->getAFaturar($request, $agruparPorObra, $search, $obraId, $etapaId, $perPage);
        }

        return response()->json(['error' => 'Tipo de relatório inválido'], 400);
    }

    private function getAReceber($request, $agruparPorObra, $search, $obraId, $etapaId, $perPage)
    {
        if ($agruparPorObra !== 'false') {
            return $this->getAReceberAgrupadoPorObra($request, $search, $obraId, $perPage);
        }

        $query = EtapasFaturamento::with([
            'etapaFinanceiro.obra.client',
            'etapaFinanceiro'
        ])
            ->where('recebido_status', 'N')
            ->whereHas('etapaFinanceiro')
            ->whereHas('obra', function ($query) {
                $query->whereNull('deleted_at');
            });

        if ($search) {
            $query->whereHas('etapaFinanceiro.obra', function ($q) use ($search) {
                $q->where('razao_social', 'like', "%{$search}%")
                    ->orWhere('last_note', 'like', "%{$search}%");
            });
        }

        if ($obraId) {
            $query->whereHas('etapaFinanceiro', function ($q) use ($obraId) {
                $q->where('obra_id', $obraId);
            });
        }

        if ($etapaId) {
            $query->where('obr_etp_financerio_id', $etapaId);
        }

        $query->orderBy('data_vencimento', 'asc');

        $faturamentos = $query->paginate($perPage);

        $totais = $this->calcularTotaisAReceber($query);

        return response()->json([
            'data' => RelatorioFinanceiroResource::collection($faturamentos),
            'pagination' => [
                'total' => $faturamentos->total(),
                'per_page' => $faturamentos->perPage(),
                'current_page' => $faturamentos->currentPage(),
                'last_page' => $faturamentos->lastPage(),
                'from' => $faturamentos->firstItem(),
                'to' => $faturamentos->lastItem(),
            ],
            'totais' => $totais,
        ]);
    }

    private function getAReceberAgrupadoPorObra($request, $search, $obraId, $perPage)
    {
        $query = Obra::with(['client', 'etapas_financeiro.faturamento'])
            ->whereHas('etapas_financeiro.faturamento', function ($q) {
                $q->where('recebido_status', 'N');
            });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('razao_social', 'like', "%{$search}%")
                    ->orWhere('last_note', 'like', "%{$search}%");
            });
        }

        if ($obraId) {
            $query->where('id', $obraId);
        }

        $obras = $query->paginate($perPage);

        $data = collect($obras->items())->map(function ($obra) {
            $faturamentos = EtapasFaturamento::whereHas('etapaFinanceiro', function ($q) use ($obra) {
                $q->where('obra_id', $obra->id);
            })
                ->where('recebido_status', 'N')
                ->get();

            $totalAReceber = $faturamentos->sum('valor');
            $vencidas = $faturamentos->where('data_vencimento', '<=', now())->sum('valor');
            $proximoVencimento = $faturamentos->sortBy('data_vencimento')->first()?->data_vencimento;

            return [
                'obra_id' => $obra->id,
                'obra_nome' => limit($obra->razao_social, 40),
                'nfe' => $obra->last_note,
                'cliente' => $obra->client?->company_name,
                'total_a_receber' => $totalAReceber,
                'vencidas' => $vencidas,
                'proximo_vencimento' => $proximoVencimento,
                'qtd_etapas' => $faturamentos->pluck('obr_etp_financerio_id')->unique()->count(),
            ];
        });

        $totais = [
            'total_a_receber' => $data->sum('total_a_receber'),
            'total_vencidas' => $data->sum('vencidas'),
            'qtd_obras' => $data->count(),
        ];

        return response()->json([
            'data' => $data,
            'pagination' => [
                'total' => $obras->total(),
                'per_page' => $obras->perPage(),
                'current_page' => $obras->currentPage(),
                'last_page' => $obras->lastPage(),
                'from' => $obras->firstItem(),
                'to' => $obras->lastItem(),
            ],
            'totais' => $totais,
        ]);
    }

    private function getAFaturar($request, $agruparPorObra, $search, $obraId, $etapaId, $perPage)
    {
        if ($agruparPorObra !== 'false') {
            return $this->getAFaturarAgrupadoPorObra($request, $search, $obraId, $perPage);
        }

        $query = ObraEtapasFinanceiro::with(['obra.client'])
            ->where('valor_a_faturar', '>', 0);

        if ($search) {
            $query->whereHas('obra', function ($q) use ($search) {
                $q->where('razao_social', 'like', "%{$search}%")
                    ->orWhere('last_note', 'like', "%{$search}%");
            });
        }

        if ($obraId) {
            $query->where('obra_id', $obraId);
        }

        if ($etapaId) {
            $query->where('etapa_id', $etapaId);
        }

        $etapas = $query->paginate($perPage);

        $totais = [
            'total_a_faturar' => $query->sum('valor_a_faturar'),
            'qtd_etapas' => $query->count(),
        ];

        $data = collect($etapas->items())->map(function ($etapa) {
            return [
                'etapa_id' => $etapa->id,
                'obra_id' => $etapa->obra_id,
                'obra_nome' => $etapa->obra->razao_social,
                'nfe' => $etapa->obra->last_note,
                'cliente' => $etapa->obra->client?->company_name,
                'nome_etapa' => $etapa->nome_etapa,
                'valor_total' => $etapa->valor_receber,
                'valor_faturado' => $etapa->valor_faturado,
                'valor_a_faturar' => $etapa->valor_a_faturar,
                'status' => $etapa->status,
            ];
        });

        return response()->json([
            'data' => $data,
            'pagination' => [
                'total' => $etapas->total(),
                'per_page' => $etapas->perPage(),
                'current_page' => $etapas->currentPage(),
                'last_page' => $etapas->lastPage(),
                'from' => $etapas->firstItem(),
                'to' => $etapas->lastItem(),
            ],
            'totais' => $totais,
        ]);
    }

    private function getAFaturarAgrupadoPorObra($request, $search, $obraId, $perPage)
    {
        $query = Obra::with(['client', 'etapas_financeiro'])
            ->whereHas('etapas_financeiro', function ($q) {
                $q->where('valor_a_faturar', '>', 0);
            });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('razao_social', 'like', "%{$search}%")
                    ->orWhere('last_note', 'like', "%{$search}%");
            });
        }

        if ($obraId) {
            $query->where('id', $obraId);
        }

        $obras = $query->paginate($perPage);

        $data = collect($obras->items())->map(function ($obra) {
            $etapas = $obra->etapas_financeiro->where('valor_a_faturar', '>', 0);
            $totalAFaturar = $etapas->sum('valor_a_faturar');

            return [
                'obra_id' => $obra->id,
                'obra_nome' => $obra->razao_social,
                'nfe' => $obra->last_note,
                'cliente' => $obra->client?->company_name,
                'total_a_faturar' => $totalAFaturar,
                'qtd_etapas' => $etapas->count(),
            ];
        });

        $totais = [
            'total_a_faturar' => $data->sum('total_a_faturar'),
            'qtd_obras' => $data->count(),
        ];

        return response()->json([
            'data' => $data,
            'pagination' => [
                'total' => $obras->total(),
                'per_page' => $obras->perPage(),
                'current_page' => $obras->currentPage(),
                'last_page' => $obras->lastPage(),
                'from' => $obras->firstItem(),
                'to' => $obras->lastItem(),
            ],
            'totais' => $totais,
        ]);
    }

    private function calcularTotaisAReceber($query)
    {
        $clone = clone $query;
        $faturamentos = $clone->get();

        return [
            'total_a_receber' => $faturamentos->sum('valor'),
            'total_vencidas' => $faturamentos->where('data_vencimento', '<=', now())->sum('valor'),
            'qtd_faturas' => $faturamentos->count(),
        ];
    }

    public function getObras(Request $request)
    {
        $search = $request->input('search');

        $obras = Obra::select('id', 'razao_social', 'last_note')
            ->when($search, function ($q) use ($search) {
                $q->where('razao_social', 'like', "%{$search}%")
                    ->orWhere('last_note', 'like', "%{$search}%");
            })
            ->limit(50)
            ->get();

        return response()->json($obras);
    }

    public function getEtapas(Request $request)
    {
        $obraId = $request->input('obra_id');

        $etapas = ObraEtapasFinanceiro::select('id', 'nome_etapa', 'obra_id')
            ->when($obraId, function ($q) use ($obraId) {
                $q->where('obra_id', $obraId);
            })
            ->limit(50)
            ->get();

        return response()->json($etapas);
    }
}
