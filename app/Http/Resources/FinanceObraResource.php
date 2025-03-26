<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinanceObraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'obraId' => $this['obraId'],
            'nome_obra' => $this['nome_obra'],
            'client_name' => $this['client']['name'] ?? '',
            'valor_negociado' => $this['valor_negociado'],
            'total_receber' => $this['total_receber'],
            'total_recebido' => $this['total_recebido'],
            'total_a_faturar' => $this['total_a_faturar'],
            'saldo' => $this['saldo'],
            'n_nota' => $this['n_nota'],
            'vencidas' => $this['vencidas'],
            'data_vencimento' => $this['data_vencimento'],
        ];
    }
}
