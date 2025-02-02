<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            "clients.company_name" => $this->company_name ?? '',
            "concessionaria_name" => $this->concessionaria_name ? $this->concessionaria_name : '',
            "service_name" => $this->service_name,
            "statusButton" => $this->status,
            "created_at" => date_format(Carbon::parse(str_replace('/', '-', $this->created_at)), 'd/m/Y')
        ];
    }
}
