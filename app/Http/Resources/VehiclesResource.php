<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehiclesResource extends JsonResource
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
            "year" => $this->year,
            "board" => $this->board,
            "renavam" => $this->renavam,
            "chassi" => $this->chassi,
            "type" => $this->type ?? '',
            "statusButton" => $this->getButtons(),
            "tracker" => $this->tracker == 1
                ? '<span class="badge badge-soft-success font-size-12">Seguro</span>'
                : '<span class="badge badge-soft-danger font-size-12">Sem seguro</span>'
        ];
    }

    private function getButtons()
    {
        $routeDelete = route('vehicles.destroy', [$this->id, 'desactive' => true]);
        $routeView = route('vehicles.show', [$this->id]);

        return "
        <a href='$routeView'
                class='btn btn-xs btn-info mr-1'>
                <i class='fa fa-edit'></i>
            </a><a href='JavaScript:void(0)' data-toggle='tooltip' data-placement='top' data-text='Desativar'
                data-href='$routeDelete'
                class='btn btn-xs btn-danger btn-delete' onclick='btn_delete(this)'
                data-original-title='Desativar Carro'>
                <i class='fa fa-times'></i>
            </a>
            ";
    }
}
