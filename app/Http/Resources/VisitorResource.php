<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitorResource extends JsonResource
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
            'name' => $this->name,
            'company_name' => $this->company_name,
            'finality' => $this->finality,
            'document' => $this->document,
            'vehicle' => $this->VehicleComplete,
            'visitor_at' => $this->visitor_at,
            'status_label' => $this->status->getLabelHTML(),
            'optionsToChange' => $this->OptionsToChangeStatus,
        ];
    }
}
