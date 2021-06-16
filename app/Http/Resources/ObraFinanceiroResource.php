<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ObraFinanceiroResource extends JsonResource
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
            'id' => $this->id,
            'valor_proposta' => $this->valor_proposta,
            'valor_negociado' => $this->valor_negociado,
            'valor_desconto' => $this->valor_desconto,
            'valor_custo' => $this->valor_custo,
            'metodo_pagamento' => $this->metodo_pagamento,
            'envio_at' => $this->envio_at,

            'valor_proposta_format' => 'R$ ' . number_format($this->valor_proposta, 2, ',', '.'),
            'valor_negociado_format' => 'R$ ' . number_format($this->valor_negociado, 2, ',', '.'),
            'valor_desconto_format' => 'R$ ' . number_format($this->valor_desconto, 2, ',', '.'),
            'valor_custo_format' => 'R$ ' . number_format($this->valor_custo, 2, ',', '.'),
        ];
    }
}
