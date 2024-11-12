<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Number;
use Cknow\Money\Money;

class Currency implements CastsAttributes
{
    /**
     * Money constructor.
     * @param $amount
     * @param $currency
     */
    public function __construct(protected $currency = 'BRL', protected $locale = 'pt-BR')
    {
    }

    public function get($model, string $key, $value, array $attributes)
    {
        return Number::currency($value / 100, $this->currency, $this->locale);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        #dd(parseMoneyToDec($value) / 100);

        return $value == 0 ? 0 : parseMoneyToDec($value) / 100;  #* 100;
    }
}
