<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RdseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $p = '';
        $valorTotal = $this->getServicesTotal();

        $typeRdse = $this->type;
        $valorUps = $valorTotal / collect(config("admin.rdse.type", []))->where('name', $typeRdse)->first()['value'];

        if ($this->parcial_1 == true) {
            $p = 'P2';
        }

        if ($this->parcial_2 == true) {
            $p = 'P3';
        }

        if ($this->parcial_3 == true) {
            $p = 'P4';
        }

        return [
            'id' => $this->id,
            'description' => $this->description,
            'n_order' => $this->n_order ?? '',
            'equipe' => $this->equipe,
            'solicitante' => $this->solicitante,
            'at' => !empty($this->at) ? return_format_date($this->at) : '',
            'type' => $this->type,
            'status' => $this->status,
            'status_label' => $this->getStatusLabel(),
            'valor_total' => $p . ' R$ ' . maskPrice($valorTotal),
            'valor' => $valorTotal,
            'valor_ups' => maskPrice($valorUps),
            'ups' => $valorUps,
            'status_execution' => $this->status_execution,
        ];
    }

    private function getStatusLabel()
    {
        return "<div class='badge badge-soft-" . $this->StatusLabel . " font-size-12'>
                " . __trans('rdses.status_label.' . $this->status) . "
            </div>";
    }

    private function getLabelStatusExecution()
    {
        
    }

    private function getValorTotalAndUps()
    {
        if ($this->parcial_1 == true) {
            $p = 'P2';
        }

        if ($this->parcial_2 == true) {
            $p = 'P3';
        }

        if ($this->parcial_3 == true) {
            $p = 'P4';
        }


        $result = [];
    }
}
