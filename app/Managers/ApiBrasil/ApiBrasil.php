<?php

namespace App\Managers\ApiBrasil;

use App\Managers\ApiBrasil\Bb;
use App\Managers\ApiBrasil\Requests\ApiBrasilRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApiBrasil
{
    protected ApiBrasilRequest $request;

    public function __construct()
    {
        $this->request = app(ApiBrasilRequest::class);
    }

    public function send($number, $message = null)
    {
        try {
            $numberTo = clearNumberToSendWhats($number);

            return $this->request->execute('POST', "evolution/message/sendText", [
                "number" => $numberTo,
                #"title" => "Title Button",
                #"description" => "Description Button",
                #"footer" => "Footer Button",
                "text" => $message,
                #"buttons" => [
                #    [
                #        "type" => "pix",
                #        "currency" => "BRL",
                #        "name" => "APIBrasil",
                #        "keyType" => "random", // phone, email, cpf, cnpj, random
                #        "key" => "0ea59ac5-f001-4f0e-9785-c772200f1b1e"
                #    ]
                #],
                "options" => [
                    "delay" => 1200,
                    "presence" => "composing"
                    #"quoted" => [
                    #    "key" => [
                    #        "id" => "MESSAGE_ID"
                    #    ],
                    #    "message" => [
                    #        "conversation" => "CONTENT_MESSAGE"
                    #    ]
                    #],
                    #"mentionsEveryOne" => false,
                    #"mentioned" => [
                    #    "{{remoteJid}}"
                    #]
                ]
            ]);
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }
}
