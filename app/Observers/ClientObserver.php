<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class ClientObserver
{
    /**
     * Handle the Client "creating" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function creating(Client $client)
    {
        $client->uuid = uniqid(((date('s') / 12) * 24) + mt_rand(800, 9999));

        $client->cnpj = isset($client->cnpj) ? str_replace(['.', ',', '/', '-'], '', $client->cnpj) : null;

        $client->username = mb_strtolower($client->username, 'UTF-8');

        $client->password = Hash::make("cena2020_" . limpar($client->username));
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function updating(Client $client)
    {
        $client->username = mb_strtolower($client->username, 'UTF-8');

        $client->password =  Hash::make("cena2020_" . limpar($client->username));
    }
}
