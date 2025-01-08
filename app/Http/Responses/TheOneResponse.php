<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class TheOneResponse implements Responsable
{
    protected int $httpCode;

    protected array $data;

    protected string $errorMessage;

    public function __construct(int $httpCode, array $data = [], string $errorMessage = '')
    {
        $this->httpCode = $httpCode;
        $this->data = $data;
        $this->errorMessage = $errorMessage;
    }

    public static function toApiResponse($code, $data)
    {
        $message = $data['message'] ?? 'ok';

        $payload = match ($code) {
            $code >= 500 => ['message' => 'Server error'],
            $code >= 400 => ['message' => $message],
            $code >= 200 =>  $data,
            default => $data,
        };

        return response()->json(
            data: $payload,
            status: $code,
            options: JSON_UNESCAPED_UNICODE
        );
    }

    public function toResponse($request): \Illuminate\Http\JsonResponse
    {
        $payload = match (true) {
            $this->httpCode >= 500 => ['message' => 'Server error'], //if you don't show server errors to all
            $this->httpCode >= 400 => ['message' => $this->errorMessage],
            $this->httpCode >= 200 => $this->data,
        };

        return response()->json(
            data: $payload,
            status: $this->httpCode,
            options: JSON_UNESCAPED_UNICODE
        );
    }

    public static function ok(array $data)
    {
        $data['message'] = $data['message'] ?? 'OK';

        return new static(200, $data);
    }

    public static function created(array $data)
    {
        return new static(201, $data);
    }

    public static function notFound(string $errorMessage = "Item not found")
    {
        return new static(404, errorMessage: $errorMessage);
    }

    public static function unprocessable(string $errorMessage = "Resource Invalid")
    {
        return new static(422, errorMessage: $errorMessage);
    }
}
