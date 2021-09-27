<?php

namespace App\Http\Controllers\Painel\Obras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Obra;
use App\Models\ObraEtapasFinanceiro;
use Illuminate\Support\Facades\DB;

class FinanceiroController extends Controller
{
    protected $repository;

    public function __construct(Obra $obra)
    {
        $this->repository = $obra;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->all();

        $finances = [];

        $obras = $this->repository->where(function ($query) use ($filter) {
            if (isset($filter['obr_name']) && $filter['obr_name'] != '') {
                return $query->where('razao_social', 'LIKE', '%' . $filter['obr_name'] . '%');
            }
        })->where('status', 'aprovada')->with('financeiro')->get(['razao_social', 'id']);

        foreach ($obras as $obra) {
            if (!$obra->financeiro) {
                continue;
            }
            $totalFaturado = 0;
            $saldoAFaturar = 0;
            $totalRecebido = 0;
            $totalReceber = 0;
            $aReceber = 0;
            $vencidas = 0;
            $data_vencimento = '';
            $valorNegociadoObra = $obra->financeiro ? $obra->financeiro->valor_negociado : 0;

            $etapas = $obra->etapas_financeiro()->with('faturamento')->get();

            if ($etapas) {

                foreach ($etapas as $etapa) {
                    $status = $etapa->StatusEtapa;
                    if (!$status) {
                        $status['text'] = '';
                    }
                    $etapaValor = $status['text'] != 'EM' ? $etapa->valor_receber : 0;
                    $etapaFaturado = $etapa->faturado();
                    $etapaRecebido = $etapa->recebido();
                    $etapaAReceber = $etapa->aReceber();

                    if ($etapaAReceber) {
                        $aReceber = $etapaAReceber->sum;
                        $vencidas = $etapaAReceber->qnt;
                        $data_vencimento = $etapaAReceber->data_vencimento;
                    }

                    $totalFaturado += $etapaFaturado;
                    $saldoAFaturar += $etapaValor != '0' ? $etapaValor - $etapaFaturado : '0';
                    $totalRecebido += $etapaRecebido;
                    $totalReceber  += $aReceber;
                }
            }

            $finances[$obra->id]['valor_negociado'] = $valorNegociadoObra;
            $finances[$obra->id]['obraId'] = $obra->id;
            $finances[$obra->id]['nome_obra'] = $obra->razao_social;
            $finances[$obra->id]['total_faturado'] = $totalFaturado;
            $finances[$obra->id]['total_a_faturar'] = $saldoAFaturar;
            $finances[$obra->id]['total_recebido'] = $totalRecebido;
            $finances[$obra->id]['total_receber'] = $totalReceber;
            $finances[$obra->id]['saldo'] = $valorNegociadoObra - $totalFaturado;
            $finances[$obra->id]['vencidas'] = $vencidas;
            $finances[$obra->id]['data_vencimento'] = $data_vencimento;
        }

        $finances =  collect($finances);
        if (isset($filter['faturar'])) {
            $finances = $finances->where('total_a_faturar', '<>', 0);
        }

        if (isset($filter['receber'])) {
            $finances = $finances->where('total_receber', '<>', 0);
        }

        if (isset($filter['vencimento'])) {
            $finances = $finances->where('qntVencidas', '<>', 0);
        }

        return view('pages.painel.obras.finances.index', [
            'finances' => $finances,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $obraId)
    {
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

        $etapas = $obra->etapas_financeiro()->with('etapa')->with('faturamento')->get();

        return view('pages.painel.obras.obras.financeiro.index', [
            'obra' => $obra,
            'etapas' => $etapas
        ]);
    }
}
