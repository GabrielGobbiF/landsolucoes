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

        $name = isset($this->user) ? Str::title($this->user->name) : 'N';
        $name = substr(mb_strtoupper($name, 'UTF-8'), 0, 2);

        return [
            "id" => $this->id,
            "text" => $this->obs_texto,
            "text_limit" => mb_strimwidth($this->obs_texto, 0, 38),
            "user" => $name,
            "user_name" => isset($this->user) ? $this->user->name : '',
            "date" => $this->created_at ? dateTournamentForHumans($this->created_at) : '',
            "deletu" => isset($this->user) && auth()->user()->id == $this->user->id ? true : false
        ];
    }
}
