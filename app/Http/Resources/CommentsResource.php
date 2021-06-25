<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $name = Str::title($this->user->name);
        $name = substr(mb_strtoupper($name, 'UTF-8'), 0, 2);

        return [
            "id" => $this->id,
            "text" => $this->obs_texto,
            "user" => $name,
            "user_name" => $this->user->name,
            "date" => dateTournamentForHumans($this->created_at)
        ];
    }
}
