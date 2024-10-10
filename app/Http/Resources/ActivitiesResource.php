<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ActivitiesResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userName = Str::title($this->user->username);
        $userNameTitle = substr(mb_strtoupper($userName, 'UTF-8'), 0, 2);
        $delete =  isset($this->user) && auth()->check() && auth()->user()->id == $this->user->id ? true : false;

        return [
            'id' => $this->id,
            'tipyssable_id' => $this->tipyssable_id,
            'text' => $this->text,
            'title' => $this->title,
            'user' => $userName,
            "user_name" => $userNameTitle,
            'user_title' => $userNameTitle,
            'created_at' => $this->created_at,
            "date" => $this->created_at ? return_format_date($this->created_at) : '',
            "deletu" => $delete
        ];
    }
}
