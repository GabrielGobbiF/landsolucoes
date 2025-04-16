<?php

namespace App\Managers\ApiBrasil\Requests;

use App\Exceptions\ApiResponseException;
use App\Managers\ApiBrasil\Exceptions\BbApiException as ExceptionsBbApiException;
use App\Traits\ApiResponser;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use OTPHP\TOTP;

class ApiBrasilRequest
{
    use ApiResponser;

    //TODO alterar base url
    #private const BB_API_URL = config('services.bancobrasil.o_auth_url');

    private $accessToken, $appKey, $appUrl, $device;

    protected $httpClient;

    public function __construct($access_token = null)
    {
        $this->httpClient = new Client();

        $this->accessToken = $access_token;

        $this->appKey = config('services.apibrasil.key');

        $this->appUrl = config('services.apibrasil.url');

        $this->device = config('services.apibrasil.device');
    }

    /**
     * Make the API request.
     *
     * @param string $endpoint
     * @param array $params
     * @return array
     */
    public function execute(string $method, string $endpoint, array $params = [], array $attach = []): array
    {
        try {
           # $getEndPointBuild = $this->buildEndpoint($endpoint, $params, $method);

            $headers = $this->buildHeaders($endpoint, $method);

            $request = Http::withHeaders($headers);

            $request = $request->$method($this->appUrl . $endpoint, ($params));

            #dd(json_decode($request->getBody(), true, 512, JSON_THROW_ON_ERROR));
        } catch (RequestException $e) {
            dd($e->getMessage());
            throw ValidationException::withMessages(['error' => $e->getMessage()]);
        }

        return $this->handleErrors($request);
    }

    private function buildHeaders(string $endpoint, $method = 'GET'): array
    {
        $headers =  [
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$this->accessToken}",
            'DeviceToken' => $this->device,
        ];

        if ($method == 'POST' || $method == 'DELETE') {
            $headers['Content-Type'] = 'application/json';
        }

        return $headers;
    }

    private function buildWithOptions()
    {
        #$certPath = config_path('cert/certificatec.pem');

        // Senha do certificado
        #$certPassword = config('services.bancobrasil.cert_pass');

        // Carregar o conteúdo do certificado .pfx
        #$certContent = file_get_contents($certPath);

        // Converter o certificado .pfx para base64
        #$certBase64 = base64_encode($certContent);

        return [
            'verify' => true,
            #'cert' => [$certPath, $certPassword],
            #'ssl_key' => [$certPath, $certPassword],
        ];
    }

    private function buildEndPoint($endpoint, $params, $method): string
    {
        $query = [
            'gw-dev-app-key' => $this->appKey
        ];

        $build = $method == 'get' ? '?' . http_build_query($query += $params) : (http_build_query($query) != '' ? '?' . http_build_query($query) : null);

        return $this->appUrl . $endpoint . $build;
    }

    protected function handleErrors($response): array
    {
        Log::info($response->getBody());

        return match ($response->getStatusCode()) {
            200 => json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR),
            201 => json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR),
            401 => json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR),
                #404 => abort('404'),
                #401, 500 => $this->errorResponse($response),
            default => throw new ApiResponseException($response)
        };
    }
}
