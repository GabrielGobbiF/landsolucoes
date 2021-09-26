<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        $client->cnpj = isset($client->cnpj) && $client->cnpj != '' ? str_replace(['.', ',', '/', '-'], '', $client->cnpj) : NULL; //

        $client->username = titleCase(minusculo($client->username));

        $client->password = Hash::make("cena_" . limpar($client->username));

        $client->company_name = maiusculo($client->company_name);

        if (Storage::exists('senhas_clientes.txt')) {
            Storage::append('senhas_clientes.txt', 'nome:' . $client->company_name . 'senha: ' . $client->password);
        } else {
            Storage::put('senhas_clientes.txt', 'nome:' . $client->company_name . 'senha: ' . $client->password);
        }
    }

    /**
     * Handle the plan "updating" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function updating(Client $client)
    {
        $client->username =  titleCase(minusculo($client->username));

        $client->company_name = maiusculo($client->company_name);

        #$client->password =  Hash::make("cena_" . limpar($client->username));
    }
}
