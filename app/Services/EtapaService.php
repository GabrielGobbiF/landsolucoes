<?php

namespace App\Services;

use App\Jobs\SendWhats;

class EtapaService
{
    public function sendMessageCheckFaturamento($etapa, $etapaFinanceiro)
    {
        $route = route('obras.finance', ['obraId' => $etapa->obra->id, 'etp' => $etapaFinanceiro->id]);

        $number = '11965197932';

        $message = "Etapa no financeiro a faturar
link: $route
        ";

        SendWhats::dispatch($number, $message)->delay(now());
    }
}
