<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FornecedoresResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $categorias = $this->atuacao ? $this->atuacao : $this->atuacao()->get();

        $output = $categorias ? $categorias->implode('name', ', ') : null;

        return [
            "id" => $this->id,
            "razao_social" => $this->razao_social,
            "cnpj" => $this->cnpj,
            "categorias" => $output
        ];
    }
}
