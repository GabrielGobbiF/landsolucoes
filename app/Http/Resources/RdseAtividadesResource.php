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
        $route = route('rdse.atividades.show', $this->id);

        return [
            'id' => $this->id,
            'rdse_id' => $this->rdse_id,
            'atividade_descricao' => $this->atividade_descricao,
            //'atividades' => $this->atividades,
            'data' => $this->data,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
            'equipe' => $this->equipe->name,
            'execucao' => !empty($this->execucao) ? 'Executado' : 'Não Executado',
            'btn_edit' => "<a class='btn btn-sm btn-outline-secondary' href='$route'>Editar</a>",
            "data_format" => "{$this->data} {$this->data_inicio} - {$this->data_fim}",
            "atividades" => $this->atividades
        ];
    }
}
