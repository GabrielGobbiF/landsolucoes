<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriversResource extends JsonResource
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
            "cnh_number" => $this->cnh_number,
            "cnh_validity" => $this->cnh_validity,
            "cnh_category" => $this->cnh_category,
            "cpf" => $this->cpf,
            "re" => $this->re,
            #"statusButton" => $this->getButtons(),
            "status" => $this->is_active == 0
                ? '<span class="badge badge-soft-success font-size-12">Ativo</span>'
                : '<span class="badge badge-soft-danger font-size-12">Desativado</span>'
        ];
    }

    private function getButtons()
    {
        $id = $this->id;

        $routeResetPass = route('vehicles.drivers.password.reset', $id);
        $routeShow = route('vehicles.drivers.show', [$id]);

        $button = "<a href='JavaScript:void(0)' onclick='btn_delete(this)' data-toggle='tooltip' data-placement='top' data-text='Resetar Senha'
                                        data-href='$routeResetPass'
                                        class='btn btn-xs btn-warning btn-delete mr-1'
                                        data-original-title='Resetar'>
                                        <i class='fa fa-unlock-alt'></i>
                                    </a>
                                    <a href='$routeShow' data-toggle='tooltip' data-placement='top' data-text='Ativar'
                                        class='btn btn-xs btn-dark mr-1'
                                        data-original-title='Editar Usuário'>
                                        <i class='fa fa-edit'></i>
                                    </a>";

        if ($this->is_active == '0') {
            $route = route('vehicles.drivers.activeOrdesactive', [$id, 'desactive' => true]);

            $button .= "<a href='JavaScript:void(0)' onclick='btn_delete(this)' data-toggle='tooltip' data-placement='top' data-text='Desativar'
                                            data-href='$route'
                                            class='btn btn-xs btn-danger btn-delete'
                                            data-original-title='Desativar Usuário'>
                                            <i class='fa fa-times'></i>
                                        </a>";
        } else {
            $route = route('vehicles.drivers.activeOrdesactive', [$id, 'desactive' => false]);

            $button .= "<a href='JavaScript:void(0)' onclick='btn_delete(this)' data-toggle='tooltip' data-placement='top' data-text='Ativar'
                                        data-href='$route'
                                        class='btn btn-xs btn-success btn-delete'
                                        data-original-title='Ativar Usuário'>
                                        <i class='fa fa-plus'></i>
                                    </a>";
        }

        return $button;
    }
}
