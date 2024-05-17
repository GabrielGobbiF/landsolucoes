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
        if ($this->type != 'cliente') {
            $name = isset($this->user) ? Str::title($this->user->name) : 'N';
            $name = substr(mb_strtoupper($name, 'UTF-8'), 0, 2);
            $username = isset($this->user) ? $this->user->name : '';
            $delete =  isset($this->user) && auth()->check() && auth()->user()->id == $this->user->id ? true : false;
        }

        if ($this->type == 'cliente') {
            $name = isset($this->user) ? Str::title($this->user->username) : 'N';
            $name = substr(mb_strtoupper($name, 'UTF-8'), 0, 2);
            $username = isset($this->user) ? $this->user->username : '';
            $delete =  isset($this->user) && auth()->guard('clients')->check() && auth()->guard('clients')->user()->id == $this->user->id ? true : false;
        }

        return [
            "id" => $this->id,
            "text" => $this->obs_texto,
            "text_limit" => mb_strimwidth($this->obs_texto, 0, 38),
            "user" => $name,
            "user_name" => $username,
            "date" => $this->created_at ? return_format_date($this->created_at) : '',
            "deletu" => $delete
        ];
    }
}
