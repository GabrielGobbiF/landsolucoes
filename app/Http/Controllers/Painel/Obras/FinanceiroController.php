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

        $obras = $this->repository->where(function ($query) use ($filter) {
            if (isset($filter['obr_name']) && $filter['obr_name'] != '') {
                return $query->where('razao_social', 'LIKE', '%' . $filter['obr_name'] . '%');
            }
        })->with('financeiro')->get(['razao_social', 'id']);

        $etapaFaturado = 0;
        $etapaRecebido = 0;
        $saldoAFaturar = 0;
        $totalFaturado = 0;
        $totalRecebido = 0;
        $totalAReceber = 0;
        $etapaFaturado = 0;
        $etapaValor = 0;
        $totalReceber = 0;
        $qntVencidas = 0;
        $dataVencimento = '';
        $finances = [];
        $d = [];

        foreach ($obras as $obra) {

            if (!$obra->financeiro) {
                continue;
            }

            $valorNegociadoObra = $obra->financeiro ? $obra->financeiro->valor_negociado : 0;
            $etapas = $obra->etapas_financeiro()->get();

            if ($etapas) {
                $r = DB::select("select sum(valor) as sum, COUNT(id) as qnt, data_vencimento from etapas_faturamentos WHERE obra_id = ? AND data_vencimento <= DATE(NOW())", [$obra->id]);
                $r = $r ? $r[0] : false;
                foreach ($etapas as $etapa) {

                    $status = $etapa->StatusEtapa;
                    $etapaValor = $status['text'] != 'EM' ? $etapa->valor_receber : 0;
                    $etapaFaturado = $etapa->faturado();
                    $etapaRecebido = $etapa->recebido();


                    $totalFaturado += $etapaFaturado;
                    $saldoAFaturar += $etapaValor - $etapaFaturado;
                    $totalRecebido += $etapaRecebido;
                    $totalReceber  += $etapaValor;
                }

                if ($r) {
                    $d[$obra->id]['totalAReceber'] = $r->sum;
                    $d[$obra->id]['qntVencidas'] = $r->qnt;
                    $d[$obra->id]['dataVencimento'] = $r->data_vencimento;
                }
            }

            $finances[] = (object)[
                'name' => $obra->razao_social,
                'obraId' => $obra->id,
                'faturado' => $etapaFaturado,
                'recebido' => $totalRecebido,
                'receber' => $totalReceber,
                'aFaturar' => $saldoAFaturar,
                'negociado' => $valorNegociadoObra,
                'totalReceber' => $d[$obra->id]['totalAReceber'],
                'qntVencidas' => $d[$obra->id]['qntVencidas'],
                'dataVencimento' => $d[$obra->id]['dataVencimento'] != '' ? formatDateAndTime($dataVencimento) : '',
                'saldo' => $valorNegociadoObra - $totalFaturado - $totalRecebido,
            ];
        }

        $finances =  collect($finances);
        if (isset($filter['faturar'])) {
            $finances = $finances->where('aFaturar', '<>', 0);
        }

        if (isset($filter['receber'])) {
            $finances = $finances->where('receber', '<>', 0);
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
