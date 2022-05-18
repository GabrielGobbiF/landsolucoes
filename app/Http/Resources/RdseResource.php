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
            'valor_total' => 'R$ ' . maskPrice($this->getServicesTotal()),
        ];
    }

    private function getStatusLabel()
    {
        return "<div class='badge badge-soft-" . $this->StatusLabel . " font-size-12'>
                " . __trans('rdses.status_label.' . $this->status) . "
            </div>";
    }
}
