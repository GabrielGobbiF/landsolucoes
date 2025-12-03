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
            'client_name' => $this['client_name'] ?? '',
            'valor_negociado' => $this['valor_negociado'],
            'total_receber' => $this['total_receber'],
            'total_recebido' => $this['total_recebido'],
            'total_faturado' => $this['total_faturado'] ?? 0,
            'total_a_faturar' => $this['total_a_faturar'],
            'valor_locacao' => $this['valor_locacao'] ?? 0,
            'valor_compras_materiais' => $this['valor_compras_materiais'] ?? 0,
            'mao_obra' => $this['mao_obra'] ?? 0,
            'saldo' => $this['saldo'],
            'n_nota' => $this['n_nota'],
            'vencidas' => $this['vencidas'],
            'data_vencimento' => $this['data_vencimento'],
        ];
    }
}
