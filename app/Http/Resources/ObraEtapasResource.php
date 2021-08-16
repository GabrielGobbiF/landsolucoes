<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ObraEtapasResource extends JsonResource
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
            "name" => $this->nome,
            "observacao" => $this->observacao,
            "n_nota" => $this->nota_numero ?? 0,
            "meta_etapa" => $this->meta_etapa != '' ? Carbon::parse($this->meta_etapa)->format('d/m/Y') : NULL,
            "data_abertura" => $this->data_abertura != '' ? Carbon::parse($this->data_abertura)->format('d/m/Y') : NULL,
            "prazo_atendimento" => $this->prazo_atendimento,
            "comments" => isset($this->comments) ? CommentsResource::collection($this->comments->sortByDesc('id')) : [],

        ];
    }

    public function buttons()
    {
        '<a type="button" class="btn btn-info" onclick="edit_etapa(591)"><i class="fas fa-edit"></i></a>
         <a class="btn btn-danger"> <i class="fas fa-trash"></i> </a>
        ';
    }
}
