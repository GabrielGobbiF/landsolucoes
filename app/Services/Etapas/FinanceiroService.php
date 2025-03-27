<?php

namespace App\Services\Etapas;

use App\Models\ObraEtapasFinanceiro;
use App\Models\EtapasFaturamento;
use App\Models\Obra;
use App\Models\ObraEtapa;
use App\Models\ObraFinanceiro;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class FinanceiroService
{
    /**
     * Calcula informações financeiras completas para uma etapa financeira
     *
     * @param int $etapaFinanceiroId
     * @return array
     */
    public function calcularInfoFinanceira($etapaFinanceiroId)
    {
        $etapaFinanceira = ObraEtapasFinanceiro::findOrFail($etapaFinanceiroId);
        $faturamentos = EtapasFaturamento::where('obr_etp_financerio_id', $etapaFinanceira->id)->get();
        $obraEtapa = ObraEtapa::where('id_etapa', $etapaFinanceira->etapa_id)->first();

        $hoje = Carbon::now();

        // Valor total definido para a etapa
        $valorTotal = $etapaFinanceira->valor_receber;

        // Valores recebidos (status Y)
        $valorRecebido = $faturamentos->where('recebido_status', 'Y')->sum('valor');

        // Valores faturados (com NF emitida) mas ainda não recebidos
        $valorFaturadoNaoRecebido = $faturamentos->where('recebido_status', 'N')->sum('valor');

        // Total faturado (recebidos + a receber)
        $totalFaturado = $valorRecebido + $valorFaturadoNaoRecebido;

        // Quanto ainda falta faturar
        $aFaturar = $obraEtapa->check == 'C' ? max(0, $valorTotal - $totalFaturado) : 0;

        // Faturas vencidas (não recebidas e com data de vencimento no passado)
        $faturasVencidas = $faturamentos->filter(function ($fatura) use ($hoje) {
            return $fatura->recebido_status == 'N' && $fatura->data_vencimento < $hoje;
        });

        $valorVencido = $faturasVencidas->sum('valor_receber');
        $qtdVencidas = $faturasVencidas->count();

        // Faturas a vencer (não recebidas e com data de vencimento no futuro)
        $faturasAVencer = $faturamentos->filter(function ($fatura) use ($hoje) {
            return $fatura->recebido_status == 'N' && $fatura->data_vencimento >= $hoje;
        });

        // Próximo vencimento
        $proximoVencimento = null;
        if ($faturasAVencer->count() > 0) {
            $proximoVencimento = $faturasAVencer->sortBy('data_vencimento')->first()->data_vencimento;
        }

        return [
            'id' => $etapaFinanceira->id,
            'nome' => $etapaFinanceira->nome_etapa,
            'total_faturado' => ($totalFaturado),
            'a_faturar' => ($aFaturar),
            'a_receber' => ($valorFaturadoNaoRecebido),
            'recebido' => ($valorRecebido),
            'vencidas' => [
                'valor' => $valorVencido,
                'quantidade' => $qtdVencidas,
                'faturas' => $faturasVencidas
            ],
            'proximo_vencimento' => $proximoVencimento,
            'valor_total' => ($valorTotal),
            'percentual_recebido' => $valorTotal > 0 ? ($valorRecebido / $valorTotal * 100) : 0,
            'percentual_faturado' => $valorTotal > 0 ? ($totalFaturado / $valorTotal * 100) : 0,
            'status' => $etapaFinanceira->status,

            'status_etapa' => $etapaFinanceira->StatusEtapa['text'],
            'label_etapa' => $etapaFinanceira->StatusEtapa['label'],
        ];
    }

    public function calcularInfoFinanceiraPorObra($obraId)
    {
        $obra = app("model-cache")->runDisabled(function () use ($obraId) {
            return Obra::where('id', $obraId)->first();
        });

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

        return [
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

    public function saveObraFinanceiro($obraId)
    {
        $dadosFinanceiro = $this->calcularInfoFinanceiraPorObra($obraId);

        $obraFinanceiro = ObraFinanceiro::where('id_obra', $obraId)->first();

        #Log::info($dadosFinanceiro['total_a_faturar']);

        if ($obraFinanceiro) {
            $obraFinanceiro->faturado = ($dadosFinanceiro['total_faturado']);
            $obraFinanceiro->total_a_faturar = ($dadosFinanceiro['total_a_faturar']);
            $obraFinanceiro->recebido = ($dadosFinanceiro['total_recebido']);
            $obraFinanceiro->a_receber = ($dadosFinanceiro['total_receber']);
            $obraFinanceiro->vencidas = ($dadosFinanceiro['vencidas']);
            $obraFinanceiro->saldo = ($dadosFinanceiro['saldo']);
            $obraFinanceiro->save();
        }
    }
}
