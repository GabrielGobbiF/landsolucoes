<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EtapasResource extends JsonResource
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
            "name" => $this->name,
            "quantidade" => $this->quantidade,
            "descricao" => $this->descricao,
            "preco" => number_format($this->preco, 2, ',', ','),
            "unidade" => $this->unidade,
            "name_max" => ucfirst(mb_strtolower(mb_strimwidth($this->name, 0, 48, "..."), 'utf-8')),
            "tipo" => $this->tipo->name,
            "order" => $this->pivot->order ?? 0,
            'variables' => isset($this->variables) ? VariableResource::collection($this->variables) : [],
        ];
    }

    public function buttons()
    {
        '<a type="button" class="btn btn-info" onclick="edit_etapa(591)"><i class="fas fa-edit"></i></a>
         <a class="btn btn-danger"> <i class="fas fa-trash"></i> </a>
        ';
    }
}
