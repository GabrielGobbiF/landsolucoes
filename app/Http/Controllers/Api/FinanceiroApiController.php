<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEtapaObra;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\EtapasFinanceiroResource;
use App\Http\Resources\ObraEtapasResource;
use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceiroApiController extends Controller
{
    protected $repository, $obra;

    public function __construct(Obra $obra)
    {
        $this->obra = $obra;
    }

    public function show($obra_id, $etapa_id)
    {
        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        if (!$etapa = $obra->etapas_financeiro()->where('id', $etapa_id)->first()) {
            return response()->json('Object Etapa not found', 404);
        }

        return new EtapasFinanceiroResource($etapa);
    }

    public function update(StoreUpdateEtapaObra $request, $obra_id, $etapa_id)
    {
        $columns = $request->all();

        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        if (!$etapa = $obra->etapas_financeiro()->where('id', $etapa_id)->first()) {
            return response()->json('Object Etapa not found', 404);
        }

        $columns['user_id'] = auth()->user()->id;

        $etapa->faturamento()->create($columns);

        return redirect()
            ->route('obras.finance', [$obra->id, 'etp' => $etapa->id])
            ->with('message', 'Criado com sucesso');
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
        $etapaNome = $etapa->nome;
        $obraNome = $obra->razao_social;

        $etapaFinanceiro = $obra->etapas_financeiro()->where('etapa_id', $etapa->id)->first();

        $etapa = $etapa->update(['check' => $check]);

        if ($etapaFinanceiro && $check == 'C') {
            /* todoFazer  */
            #slack("Obra: $obraNome \n Etapa: $etapaNome Liberado para faturamento veja " . route('obras.finance', $obra->id));
        }

        return $etapa;
    }
}
