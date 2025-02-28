<?php

namespace App\Services;

use App\Repositories\TableRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class WhatsService
{
    public function __construct(protected TableRepository $tableRepository)
    {
    }

    public function send(Model $model)
    {
        if(config())
        return $this->tableRepository->all($model);
    }

}
