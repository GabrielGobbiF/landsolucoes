<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProdutosResource extends JsonResource
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
            "id" => $this->id,
            "nome" => $this->name,
            "valor" => 'R$ ' . maskPrice($this->preco),
            "unidade" => $this->unidade,
            "categoria" => $this->categoria,
            "sub_categoria" => $this->sub_categoria,
        ];
    }
}
