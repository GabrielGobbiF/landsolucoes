<?php

namespace App\Http\Resources;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $name = Str::title($this->name);
        $name = substr(mb_strtoupper($name, 'UTF-8'), 0, 2);
        return [
            "id" => $this->id,
            "name" => $this->name,
            "text" => $this->name,
            "singleName" => $name,

        ];
    }
}
