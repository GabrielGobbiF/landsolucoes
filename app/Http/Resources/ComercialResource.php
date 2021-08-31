<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComercialResource extends JsonResource
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
            "razao_social" => $this->razao_social,
            "client.name" => $this->client->company_name ?? '',
            "concessionaria.name" => $this->concessionaria ? $this->concessionaria->name : '',
            "service.name" => $this->service->name,
            "statusButton" => $this->status
        ];
    }

}
