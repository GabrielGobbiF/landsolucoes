<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientFormInvoicingResource extends JsonResource
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
            'cnpj' => $this->cnpj,
            'razao_social' => $this->razao_social,
            'nome_fantasia' => $this->nome_fantasia,
            'email_financeiro' => $this->email_financeiro,
            'email_engenheiro' => $this->email_engenheiro,
            'nome_obra' => $this->nome_obra,
            'endereco_obra' => $this->endereco_obra,
            'telefones' => $this->telefones,
        ];
    }
}
