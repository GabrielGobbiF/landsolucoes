<?php

namespace App\Managers\ApiBrasil;

use App\Managers\ApiBrasil\Exceptions\BbAuthException;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiBrasilAuth
{
    private const SCOPE = [];

    private const GRANT_TYPE = 'client_credentials';

    private $httpClient, $clientId, $clientSecret, $oAuthUrl, $device;

    public function __construct()
    {
        $config = config('services.apibrasil');

        $this->httpClient = new Client();

        [$this->clientId, $this->clientSecret, $this->oAuthUrl] = [
            $config['login'],
            $config['pass'],
            $config['auth_url'],
        ];
    }

    /**
     * Generate the access token that will be used to make request to the Banco do Brasil API.
     *
     */
    private function generateAccessToken(): string
    {
        #try {
        #    $responseOauth = Http::post($this->oAuthUrl, [
        #        'email' => $this->clientId,
        #        'password' => $this->clientSecret,
        #        #'device' => 'curl',
        #    ]);
        #} catch (RequestException $e) {
        #    #$errorResponse = json_decode($e->getResponse()->getBody()->getContents());
        #    #$status = $e->getCode();
        #    #$message = $errorResponse->error;
        #    throw ValidationException::withMessages(['error' => $e->getMessage()]);
        #}
        #
        #$body = json_decode((string) $responseOauth->getBody());
        #
        #LogChannel($body);
        #
        #$token = $body->authorization->token;
        #$expires_in = $body->authorization->expires_in;
        #
        #if ($body->error) {
        #    throw ValidationException::withMessages(['message' => 'CPF ou Senha incorretos']);
        #}

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2dhdGV3YXkuYXBpYnJhc2lsLmlvL2FwaS92Mi9sb2dpbiIsImlhdCI6MTczMjkxNDE4OCwiZXhwIjoxNzY0NDUwMTg4LCJuYmYiOjE3MzI5MTQxODgsImp0aSI6Ik1JNmdqeUg4R1d5S0FLeUMiLCJzdWIiOiI4NDcxIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.0GR59sg09bjVpNNAU0L_PiGbqsOEjuNCOWnJuN-7I-c';
        $expires_in = '1764450188';

        return $this->storeTokenInCache($token, $expires_in);
    }

    private function storeTokenInCache($token, $expires_in_timestamp)
    {
        // Calcula a diferença em segundos entre o timestamp atual e o de expiração
        $current_timestamp = Carbon::now()->timestamp;
        $expiration_time_in_seconds = $expires_in_timestamp - $current_timestamp;

        // Certifica-se de que o tempo de expiração não seja negativo
        if ($expiration_time_in_seconds > 0) {
            return Cache::remember('ApiBrasilAccountAccessToken', $expiration_time_in_seconds, function () use ($token) {
                return $token;
            });
        }

        throw ValidationException::withMessages(['message' => 'CPF ou Senha incorretos']);
    }

    /**
     * Get the access token.
     *
     */
    public function getAccessToken()
    {
        if (!Cache::has('ApiBrasilAccountAccessToken')) {
            $this->generateAccessToken();
        }

        return Cache::get('ApiBrasilAccountAccessToken');
    }
}
