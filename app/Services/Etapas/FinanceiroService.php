<?php

namespace App\Services\Etapas;

use App\Models\ObraEtapasFinanceiro;
use App\Models\EtapasFaturamento;
use App\Models\Obra;
use App\Models\ObraEtapa;
use App\Models\ObraFinanceiro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        $obraEtapa = ObraEtapa::where('id_etapa', $etapaFinanceira->etapa_id)->where('id_obra', $etapaFinanceira->obra_id)->first();

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
        $aFaturar = isset($obraEtapa) && $obraEtapa->check == 'C' ? max(0, $valorTotal - $totalFaturado) : 0;

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
            'nome_etapa' => $obraEtapa?->nome,
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

    /**
     * Calcula informações financeiras completas para uma obra
     *
     * @param int $obraId
     * @return array
     */
    public function calcularInfoFinanceiraPorObra($obraId)
    {
        // Busca a obra com relacionamentos necessários em uma única query
        $obra = app("model-cache")->runDisabled(function () use ($obraId) {
            return Obra::with([
                'financeiro',
                'client:id,company_name',
                'etapas_financeiro.faturamento',
                'etapas' => function($query) use ($obraId) {
                    $query->where('id_obra', $obraId)
                          ->select('id', 'id_obra', 'id_etapa', 'check');
                }
            ])->find($obraId);
        });

        if (!$obra) {
            throw new \Exception("Obra com ID {$obraId} não encontrada");
        }

        if (!$obra->financeiro) {
            Log::warning("Obra {$obraId} não possui registro financeiro");
            return $this->getDefaultFinancialData($obra);
        }

        $valorNegociadoObra = $obra->financeiro->valor_negociado ?? 0;
        $etapasFinanceiras = $obra->etapas_financeiro;

        // Criar map das etapas da obra por etapa_id para lookup rápido
        $etapasObraMap = collect($obra->etapas)->keyBy('id_etapa');

        // Inicializar totalizadores
        $totais = [
            'totalFaturado' => 0,
            'saldoAFaturar' => 0,
            'totalRecebido' => 0,
            'totalReceber' => 0,
            'vencidas' => 0,
            'data_vencimento' => null
        ];

        foreach ($etapasFinanceiras as $etapaFinanceira) {
            $this->processarEtapaFinanceira($etapaFinanceira, $etapasObraMap, $totais);
        }

        return [
            'valor_negociado' => $valorNegociadoObra,
            'obraId' => $obra->id,
            'n_nota' => $obra->last_note,
            'nome_obra' => $obra->razao_social,
            'total_faturado' => $totais['totalFaturado'],
            'total_a_faturar' => $totais['saldoAFaturar'],
            'total_recebido' => $totais['totalRecebido'],
            'total_receber' => $totais['totalReceber'],
            'saldo' => $valorNegociadoObra - $totais['totalFaturado'],
            'vencidas' => $totais['vencidas'],
            'data_vencimento' => $totais['data_vencimento'],
            'client_name' => limit($obra->client->company_name ?? ''),
        ];
    }

    /**
     * Processa uma etapa financeira e atualiza os totalizadores
     *
     * @param ObraEtapasFinanceiro $etapaFinanceira
     * @param \Illuminate\Support\Collection $etapasObraMap
     * @param array &$totais
     */
    private function processarEtapaFinanceira($etapaFinanceira, $etapasObraMap, &$totais)
    {
        // Verificar se a etapa existe na obra
        $etapaObra = $etapasObraMap->get($etapaFinanceira->etapa_id);
        
        if (!$etapaObra) {
            Log::warning("Etapa financeira {$etapaFinanceira->id} não encontrada na obra {$etapaFinanceira->obra_id}");
            return;
        }

        // Determinar valor da etapa baseado no status
        $etapaValor = ($etapaObra->check !== 'EM') ? $etapaFinanceira->valor_receber : 0;

        // Calcular valores da etapa
        $etapaFaturado = $etapaFinanceira->faturado();
        $etapaRecebido = $etapaFinanceira->recebido();
        $etapaAReceber = $etapaFinanceira->aReceber();
        $etapaVencidas = $etapaFinanceira->vencidas();

        // Atualizar totalizadores
        $totais['totalFaturado'] += $etapaFaturado;
        $totais['saldoAFaturar'] += ($etapaValor > 0) ? ($etapaValor - $etapaFaturado) : 0;
        $totais['totalRecebido'] += $etapaRecebido;
        $totais['totalReceber'] += $etapaAReceber->sum ?? 0;

        // Processar faturas vencidas
        if ($etapaVencidas && $etapaVencidas->qnt > 0) {
            $totais['vencidas'] += $etapaVencidas->qnt;
            
            // Guardar a data de vencimento mais recente
            if ($etapaVencidas->data_vencimento) {
                $totais['data_vencimento'] = $etapaVencidas->data_vencimento;
            }
        }
    }

    /**
     * Retorna dados financeiros padrão quando a obra não tem registro financeiro
     *
     * @param Obra $obra
     * @return array
     */
    private function getDefaultFinancialData($obra)
    {
        return [
            'valor_negociado' => 0,
            'obraId' => $obra->id,
            'n_nota' => $obra->last_note,
            'nome_obra' => $obra->razao_social,
            'total_faturado' => 0,
            'total_a_faturar' => 0,
            'total_recebido' => 0,
            'total_receber' => 0,
            'saldo' => 0,
            'vencidas' => 0,
            'data_vencimento' => null,
            'client_name' => limit($obra->client->company_name ?? ''),
        ];
    }

    public function saveObraFinanceiro($obraId)
    {
        try {
            $dadosFinanceiro = $this->calcularInfoFinanceiraPorObra($obraId);

            $obraFinanceiro = ObraFinanceiro::where('id_obra', $obraId)->first();

            if ($obraFinanceiro) {
                $obraFinanceiro->faturado = $dadosFinanceiro['total_faturado'];
                $obraFinanceiro->total_a_faturar = $dadosFinanceiro['total_a_faturar'];
                $obraFinanceiro->recebido = $dadosFinanceiro['total_recebido'];
                $obraFinanceiro->a_receber = $dadosFinanceiro['total_receber'];
                $obraFinanceiro->vencidas = $dadosFinanceiro['vencidas'];
                $obraFinanceiro->saldo = $dadosFinanceiro['saldo'];
                $obraFinanceiro->save();

                Log::info("Financeiro atualizado para obra {$obraId}: " . json_encode($dadosFinanceiro));
                return true;
            } else {
                Log::warning("ObraFinanceiro não encontrado para obra {$obraId}");
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar financeiro da obra {$obraId}: " . $e->getMessage());
            return false;
        }
    }
}
