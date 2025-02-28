<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Telescope\Telescope;

class ApiResponseException extends Exception
{
    protected $response;

    public function __construct(Response $response)
    {
        #parent::__construct('Erro na resposta da API', $response->getStatusCode());
        $this->response = $response;
    }

    public function render(Request $request)
    {
        $responseBody = $this->response->getBody()->getContents();

        $decodedBody = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);

        $errorMessage = $decodedBody['errors'] ?? 'Erro desconhecido';

        Log::channel('slack')->error('Erro na API IUGU', [
            'message' => $errorMessage,
            'response' => $decodedBody
        ]);

        #Telescope::recordException(new Exception($errorMessage));

        throw ValidationException::withMessages(['message' => $errorMessage]);
    }
}
