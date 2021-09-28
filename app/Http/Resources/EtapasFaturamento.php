<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class EtapasFaturamento extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dataNow = date('d');
        $dataVencimento = Carbon::parse($this->data_vencimento)->format('d');

        return [
            "identifyFaturamento" => $this->id,
            "faturamento" => $this->coluna_faturamento,
            "nfN" => $this->nf_n,
            "emissao" => $this->data_emissao,
            "vencimento" => $this->data_vencimento != '' ? Carbon::parse($this->data_vencimento)->format('d/m/Y') : NULL,
            "emissao" => $this->data_emissao != '' ? Carbon::parse($this->data_emissao)->format('d/m/Y') : NULL,
            "valor" => maskPrice($this->valor),
            "recebido" => $this->recebido_status,
            "vencimentoBool" => Carbon::parse($this->data_vencimento)->format('d') <= date('d') ? true : false,
        ];
    }
}
