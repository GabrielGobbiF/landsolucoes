<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RelatorioFinanceiroResource extends JsonResource
{
    public function toArray($request)
    {
        $etapaFinanceiro = $this->etapaFinanceiro;
        $obra = $etapaFinanceiro?->obra;

        return [
            'id' => $this->id,
            'obra_id' => $obra?->id,
            'obra_nome' => limit($obra?->razao_social, 60),
            'nfe' => $obra?->last_note,
            'cliente' => $obra?->client?->company_name,
            'nome_etapa' => limit($etapaFinanceiro?->nome_etapa, 50),
            'valor' => $this->valor,
            'data_vencimento' => $this->data_vencimento,
            'recebido_status' => $this->recebido_status,
            'dias_vencido' => $this->data_vencimento ? now()->diffInDays($this->data_vencimento, false) : null,
            'status_vencimento' => $this->getStatusVencimento(),
        ];
    }

    private function getStatusVencimento()
    {
        if (!$this->data_vencimento) {
            return 'sem_data';
        }

        $dias = now()->diffInDays($this->data_vencimento, false);

        if ($dias < 0) {
            return 'vencido';
        } elseif ($dias <= 7) {
            return 'vence_em_breve';
        } else {
            return 'a_vencer';
        }
    }
}
