<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            "departmentId" => $this->id,
            "dep_responsavel" => $this->dep_responsavel,
            "dep_telefone_celular" => $this->dep_telefone_celular,
            "dep_telefone_fixo" => $this->dep_telefone_fixo,
            "dep_email" => $this->dep_email,
            "dep_funcao" => $this->dep_funcao,
        ];
    }

}
