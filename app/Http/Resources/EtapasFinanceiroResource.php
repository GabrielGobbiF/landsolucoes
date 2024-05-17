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
        $history = null;

        $data = [
            "id" => $this->id,
            "nome_etapa" => $this->nome_etapa,
            "name_max" => ucfirst(mb_strtolower(mb_strimwidth($this->nome_etapa, 0, 38, "..."), 'utf-8')),
        ];

        $data['history'] = [];

        if ($request->input('history')) {
            $history = $this->getEtapasFaturamento();
            $data['history'] = EtapasFaturamento::collection($history['history']);
        }

        $data['faturado'] = $history['faturado'] ?? 0;
        $data['aReceber'] = $this->valor_receber -  $data['faturado'];

        return $data;
    }

    private function getEtapasFaturamento()
    {
        $faturamento = $this->faturamento()->get();
        $faturado = $faturamento->sum('valor') ?? 0;

        return [
            'history' => EtapasFaturamento::collection($faturamento),
            'faturado' => $faturado,
        ];
    }
}
