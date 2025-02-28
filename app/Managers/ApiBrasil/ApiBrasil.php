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
use Illuminate\Support\Facades\Storage;

class ApiBrasil
{
    protected ApiBrasilRequest $request;

    public function __construct()
    {
        if (!config('services.apibrasil.active')) {
            return;
        }

        $this->request = app(ApiBrasilRequest::class);
    }

    public function send($number, $message = null)
    {
        $numberTo = clearNumberToSendWhats($number);

        return $this->request->execute('POST', "evolution/message/sendText", [
            "number" => $numberTo,
            #"title" => "Title Button",
            #"description" => "Description Button",
            #"footer" => "Footer Button",
            "textMessage" => [
                "text" => $message
            ],
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
    }
}
