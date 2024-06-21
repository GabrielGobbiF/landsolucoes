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

        return [
            'id' => $this->id,
            'text' => $this->text,
            'title' => $this->title,
            'user' => $userName,
            'user_title' => $userNameTitle,
            'created_at' => $this->created_at
        ];
    }
}
