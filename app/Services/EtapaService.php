<?php

namespace App\Services;

use App\Jobs\SendWhats;
use App\Models\User;

class EtapaService
{
    public function sendMessageCheckFaturamento($etapa, $etapaFinanceiro)
    {
        $service = new \App\Services\NotificationsExampleService();

        $user = User::where('id', app()->isProduction() ? '238' : '1')->first();

        $route = route('obras.finance', ['obraId' => $etapa->obra->id, 'etp' => $etapaFinanceiro->id]);

        $number = app()->isProduction() ? '11965197932' : '11971590068';

        $message = "Etapa no financeiro a faturar
link: $route
        ";

        SendWhats::dispatch($number, $message)->delay(now());

        $service->notifyUser($user, 'Financeiro', 'Nova Etapa no Financeiro a Faturar', 'danger', $route);
    }
}
