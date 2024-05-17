<?php

namespace App\Services;

use App\Repositories\TableRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TableService
{
    public function __construct(protected TableRepository $tableRepository)
    {
    }

    public function getTable(Model $model)
    {
        return $this->tableRepository->all($model);
    }

    public function getTableVisitor(Model $model)
    {
        return $this->tableRepository->visitor($model);
    }
}
