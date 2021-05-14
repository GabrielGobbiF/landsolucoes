<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $getColorAndIcon = $this->getIconByExtDoc($this->ext);

        $color = $getColorAndIcon['color'];
        $icon = $getColorAndIcon['icon'];

        return [
            "name" => $this->name,
            "url" => $this->url,
            "slug" => $this->slug,
            "id" => $this->id,
            "color" => $color,
            "icon" => $icon,
        ];
    }

    public function getIconByExtDoc($extensao)
    {
        switch ($extensao) {
            case 'png':
                $icon = 'fas fa-image';
                $color = '#d43030';
                break;
            case 'jpg':
                $icon = 'fas fa-image';
                $color = '#d43030';
                break;
            case 'jpeg':
                $icon = 'fas fa-image';
                $color = '#d43030';
                break;
            case 'gif':
                $icon = 'fas fa-image';
                $color = '#d43030';
                break;
            case 'pdf':
                $icon = 'fas fa-file-pdf';
                $color = '#d43030';
                break;
            case 'xlsx':
                $icon = 'fas fa-file-excel';
                $color = '#30d435';
                break;
            default:
                $icon = 'fas fa-image';
                $color = '#d43030';
                break;
        }

        return [
            'icon' => $icon,
            'color' => $color
        ];
    }
}
