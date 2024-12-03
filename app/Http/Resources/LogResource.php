<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class LogResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $this->causer?->name;

        $translate = __trans($this->description);

        return [
            'id' => $this->id,
            'translate' => $translate,
            "user_name" => $user,
            'created_at' => $this->created_at,
            "date" => $this->created_at ? __date_format($this->created_at, 'd/m/Y H:i:s') : '',
        ];
    }
}
