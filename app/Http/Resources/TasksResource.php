<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TasksResource extends JsonResource
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
            "tar_titulo" => $this->tar_titulo,
            "tar_descricao" => $this->tar_descricao,
            "status" => $this->tar_status == 'concluido' ? true : false,
            "prioridade" => $this->prioridade,
            "lembrete" => $this->data != '' ? $this->data : false,
        ];
    }
}
