<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EtapasResource;
use App\Http\Resources\TipoResource;
use App\Models\Concessionaria;
use App\Models\Etapa;
use App\Models\Service;
use App\Models\Tipo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EtapasApiController extends Controller
{
    protected $repository;

    public function __construct(Etapa $etapas)
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
        $id_concessionaria = $request->input('con_id');
        $service_id = $request->input('serv_id');

        $req = [
            'service_id' => $service_id,
            'concessionaria_id' => $id_concessionaria,
        ];

        $etapas = $this->repository->where(function ($query) use ($request) {
            if ($request->tipo) {
                $query->where('tipo_id', $request->tipo);
            }
            if ($request->search) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            }
        })->whereDoesntHave('concessionaria', function (Builder $query) use ($req) {
            if ($req['service_id'] != '' && $req['concessionaria_id'] != '') {
                $query->where('concessionaria_id', $req['concessionaria_id']);
                $query->where('service_id', $req['service_id']);
            }
        })->with('tipo')->with('variables')->orderBy('name')->get();

        return EtapasResource::collection($etapas);
    }

    public function etapasInConSev(Request $request, $id_concessionaria, $id_service)
    {
        $response = [];

        if (!$concessionaria = Concessionaria::where('id', $id_concessionaria)->first()) {
            return redirect()
                ->route('concessionarias.show', $id_concessionaria)
                ->with('error', 'Registro (Concessionaria) não encontrado!');
        }

        if (!$service = Service::where('id', $id_service)->first()) {
            return redirect()
                ->route('concessionarias.show', $id_concessionaria)
                ->with('error', 'Registro (Serviço) não encontrado!');
        }

        $etapas = $concessionaria->etapas($service->id)->with('tipo')->get();

        $etapas = $etapas->sortBy('tipo_id')->groupBy('tipo.name');

        foreach ($etapas as $tipo => $value) {
            $response[$tipo] = EtapasResource::collection($value->sortBy('pivot.order'));
        }

        return response()->json($response);
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
