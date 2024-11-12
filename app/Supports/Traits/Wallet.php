<?php

namespace App\Supports\Traits;

trait Wallet
{
    public function deposit($column, $amount)
    {
        $balance = $this->getRawOriginal($column);
        $this->balance =  $balance + $amount;
        return $this->save();
    }

    public function take($column, $amount)
    {
        $balance = $this->getRawOriginal($column);
        $this->balance =  $balance - $amount;

        dd([
            $this,
            $column,
            $this->balance,
            $balance,
            $amount,
            $balance - $amount
        ]);

        return $this->save();
    }
}
