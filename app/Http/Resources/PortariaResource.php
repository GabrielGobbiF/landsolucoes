<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PortariaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $images = explode(', ', $this->files);

        return [
            "id" => $this->id,
            "porteiro" => 'portaria',
            "motorista" => isset($this->userName) ? $this->userName : $this->motorista,
            "veiculo" => isset($this->vehicleName) ? $this->vehicleName . ' - ' . $this->vehicleBoard : $this->motorista . ' - ' . $this->veiculo_placa,
            "data" => Carbon::parse($this->created_at)->format('d/m/Y H:i:s'),
            "observacoes" => $this->observations,
            "tipo" => $this->type,
            "tipo_veiculo" => 'Veiculo: ' . $this->veiculo_tipo,
            "files" => $images,
        ];
    }
}
