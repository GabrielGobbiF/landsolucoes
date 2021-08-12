<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            "rg" => $this->rg,
            "ctps" => $this->ctps,
            "email" => $this->email,
            "cargo" => $this->cargo,
            "endereco" => $this->endereco,
        ];
    }

}
