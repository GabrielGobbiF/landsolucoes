<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EtapasResource;
use App\Http\Resources\TipoResource;
use App\Models\Etapas;
use App\Models\Tipo;
use Illuminate\Http\Request;

class EtapasApiController extends Controller
{
    protected $repository;

    public function __construct(Etapas $etapas)
    {
        $this->repository = $etapas;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $etapas = $this->repository->where(function ($query) use ($request) {
            if ($request->tipo) {
                $query->where('tipo_id', $request->tipo);
            }
            if ($request->search) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            }
        })->with('tipo')->orderBy('name')->get();

        return EtapasResource::collection($etapas);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_tipo(Request $request)
    {
        $columns = $request->all();

        $tipo = Tipo::create($columns);

        return new TipoResource($tipo);
    }
}
