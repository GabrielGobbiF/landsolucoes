<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObraEtapasResource;
use App\Models\Obra;
use App\Models\ObraEtapa;
use Illuminate\Http\Request;

class ObrasEtapasApiController extends Controller
{
    protected $repository, $obra;

    public function __construct(Obra $obra, ObraEtapa $etapa)
    {
        $this->repository = $etapa;
        $this->obra = $obra;
    }

    public function all($obra_id)
    {
    }

    public function get($obra_id, $etapa_id)
    {
        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $etapa = $obra->etapas()->where('id', $etapa_id)->first();

        return new ObraEtapasResource($etapa);
    }

    public function update(Request $request, $obra_id, $etapa_id)
    {

        $coluna = $request->input('pk');
        $valor = $request->input('value');

        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $etapa = $obra->etapas()->where('id', $etapa_id)->first();

        $etapa->update([$coluna => $valor]);

        return  $valor;
    }
}
