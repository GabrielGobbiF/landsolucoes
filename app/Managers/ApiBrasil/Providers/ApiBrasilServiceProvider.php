<?php

namespace App\Managers\ApiBrasil\Providers;

use App\Managers\ApiBrasil\ApiBrasil;
use App\Managers\ApiBrasil\ApiBrasilAuth;
use App\Managers\ApiBrasil\Requests\ApiBrasilRequest;
use Illuminate\Support\ServiceProvider;

class ApiBrasilServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ApiBrasilRequest::class, function () {
            $accessToken = $params['access_token'] ?? null;
            if (!$accessToken) {
                $accessToken = $this->app->make(ApiBrasilAuth::class)->getAccessToken();
            }
            return new ApiBrasilRequest($accessToken);
        });
    }
}
