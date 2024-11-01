<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RdseAtividadesResource extends JsonResource
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
            'atividade' => $this->atividade,
            'data' => $this->data,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
            'equipe' => $this->equipe->name,
            'execucao' => !empty($this->execucao) ? 'Executado' : 'Não Executado',

        ];
    }
}
