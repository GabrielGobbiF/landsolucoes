<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TableRepository
{
    protected $limit, $offset, $order, $search, $sort, $filters;

    public function __construct(protected Request $request)
    {
        $this->limit = $request->input('pageSize') ?? '20';
        $this->order = $request->input('order') ?? 'asc';
        $this->offset = $request->input('offset') ?? 0;
        $this->search = $request->input('search') ?? '';
        $this->sort = $request->input('sort') ?? 'id';
        $this->filters = $request->input('filters') ?? [];
    }

    public function visitor($model)
    {
        $all = $model
            ->filtered($this->request->all())
            ->orderBy($this->sort, $this->order)
            ->orderBy('status', 'asc');

        $query = $this->checkConditions($all);

        return $this->limit == 'all' ? $query->get() : $query->paginate($this->limit);
    }

    public function all($model)
    {
        $all = $model
            ->filtered($this->request->all())
            ->orderBy($this->sort, $this->order);

        $query = $this->checkConditions($all);

        return $this->limit == 'all' ? $query->get() : $query->paginate($this->limit);

        #return $model->where('id', $id)->first();;
    }

    private function checkConditions($query)
    {
        // Verifica se existem condições 'where' específicas no request
        if ($conditions = json_decode($this->request->get('conditions'))) {
            foreach ($conditions->conditions as $condition) {
                // Aqui você pode adicionar uma lógica para verificar se a condição é um 'where' ou um 'whereDate'
                // e aplicar a condição à query adequadamente.
                if (isset($condition->date)) {
                    // Aplica um whereDate se a condição especificar uma data
                    $query->whereDate($condition->field, $condition->operator, $condition->value);
                } else {
                    // Aplica um where normal
                    $query->where($condition->field, $condition->operator, $condition->value);
                }
            }
        }

        return $query;
    }
}
