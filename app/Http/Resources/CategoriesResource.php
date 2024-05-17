<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $r = [
            "id" => $this->id,
            "name" => $this->name,
        ];

        if ($request->has('sub-categories'))
            $r['sub_categories'] = SubCategoriesResource::collection($this->subCategories);

        return $r;
    }
}
