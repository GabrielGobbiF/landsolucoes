<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CelularesResource extends JsonResource
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
            "responsavel" => $this->responsavel,
            "linha" => $this->linha,
            "usuario" => $this->usuario,
            "equipe" => $this->equipe,
        ];
    }

}
