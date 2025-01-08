<?php

namespace App\Repositories;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    protected static string $model;

    public function __call(string $name, array $arguments)
    {
        return App::make(static::$model)->{$name}(...$arguments);
    }

    public function getAll($limit = 15)
    {
        return $this->paginate($limit);
    }

    public function delete($model)
    {
        return $model->delete();
    }
}
