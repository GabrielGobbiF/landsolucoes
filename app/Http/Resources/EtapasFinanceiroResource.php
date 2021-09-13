<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Console\Helper\Helper;

class EtapasFinanceiroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            "id" => $this->id,
            "nome_etapa" => $this->nome_etapa,
        ];

        if ($request->input('history'))
            $data['history'] = $this->faturamento()->get();

        return $data;
    }

    public function buttons()
    {
        '<a type="button" class="btn btn-info" onclick="edit_etapa(591)"><i class="fas fa-edit"></i></a>
         <a class="btn btn-danger"> <i class="fas fa-trash"></i> </a>
        ';
    }
}
