<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EpiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function EpiResource($request)
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
        ];
    }
}
