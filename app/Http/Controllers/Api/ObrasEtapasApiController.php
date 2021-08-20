<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEtapaObra;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\ObraEtapasResource;
use App\Models\Obra;
use App\Models\ObraEtapa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObrasEtapasApiController extends Controller
{
    protected $repository, $obra;

    public function __construct(Obra $obra, ObraEtapa $etapa)
    {
        $this->repository = $etapa;
        $this->obra = $obra;
    }

    public function all(Request $request, $obra_id)
    {
        $filters = $request->only(['term', 'type']);

        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $etapas = $obra->etapas()
            ->where(function ($query) use ($filters) {
                if ($filters['type'] != '') {
                    $query->orWhere('tipo_id', $filters['type']);
                }
                if ($filters['term'] != '') {
                    $query->orWhere('nome', 'LIKE', '%' . $filters['term'] . '%');
                }
            })
            ->orderBy('tipo_id')->orderBy('ordem')->get();

        return ObraEtapasResource::collection($etapas);
    }

    public function get($obra_id, $etapa_id)
    {
        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $etapa = $obra->etapas()->where('id', $etapa_id)->first();

        return new ObraEtapasResource($etapa);
    }

    public function update(StoreUpdateEtapaObra $request, $obra_id, $etapa_id)
    {
        $columns = $request->all();

        //$coluna = $request->input('pk');
        //$valor = $request->input('value');

        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $etapa = $obra->etapas()->where('id', $etapa_id)->first();

        //$etapa->update([$coluna => $valor]);

        $etapa->update($columns);

        if (isset($columns['check_nota'])) {
            $obra->last_note = $columns['nota_numero'];
            $obra->update();
            $obra->save();
        }

        return $etapa_id;
    }

    public function getComments($etapa_id)
    {
        if (!$etapa = $this->repository->where('id', $etapa_id)->first()) {
            return response()->json('Object Etapa not found', 404);
        }

        $comments = $etapa->comments()->get();

        return CommentsResource::collection($comments->sortByDesc('id'));
    }

    public function commentStore(Request $request, $obra_id, $etapa_id)
    {
        $columns = $request->all();
        $columns['user_id'] = Auth::id();

        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $etapa = $obra->etapas()->where('id', $etapa_id)->first();

        if ($etapa) {
            $etapa->comments()->create($columns);

            return  $etapa;
        }
    }

    public function updateStatus(Request $request, $obra_id, $etapa_id)
    {
        $check = $request->input('check');

        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $etapa = $obra->etapas()->where('id', $etapa_id)->first();

        $etapa = $etapa->update(['check' => $check]);

        return $etapa;
    }
}
