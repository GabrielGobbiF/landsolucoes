<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $name = $this->name;

        return [
            'id' => $this->id,
            'name' => "{$this->code_omie} {$name}",
            'search' => "{$this->name} {$this->code_ncm} {$this->code_omie}",
            'stock' => $this->stock,
            'unit' => $this->unit,
            'stock_going' => $this->getCountStockGoing(),
            'market_price' => $this->market_price,
            'code_ncm' => $this->code_ncm,
            'cod_item' => $this->cod_material,
        ];
    }
}
