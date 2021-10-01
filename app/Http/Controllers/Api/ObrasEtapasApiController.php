<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEtapaObra;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\ObraEtapasResource;
use App\Models\Obra;
use App\Models\ObraEtapa;
use App\Models\User;
use App\Notifications\EtapaMencionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
                    $query->where('tipo_id', $filters['type']);
                }
                if ($filters['term'] != '') {
                    $query->where('nome', 'LIKE', '%' . $filters['term'] . '%');
                }
            })
            ->with('tipo')->orderBy('ordem')->orderBy('tipo_id')->get();

        //$etapas = $etapas->groupBy('tipo_id');
        //foreach ($etapas as $e) {
        //    $e = ObraEtapasResource::collection($etapas);
        //
        //    dd($e);
        //}

        return  ObraEtapasResource::collection($etapas);
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

        #dd($contains = Str::contains($columns['obs_texto'], ['data-id']));

        #dd(Str::of($columns['obs_texto'])->explode('data-id="'));

        #dd(substr_count($columns['obs_texto'], 'data-id="'));

        #$string = dd(removeParseContentBar($columns['obs_texto']));

        #region$texto = $columns['obs_texto'];
        #region$texto = explode('data-id="', $texto);
        #region$texto = dd($texto);

        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $etapa = $obra->etapas()->where('id', $etapa_id)->first();

        //$string = $columns['obs_texto'];
        //$patt = '/"[^"]*"/';
//
        //preg_match_all($patt, $string, $resultado);
        //foreach ($resultado as $user) {
        //    $user = intval($user);
        //    if ($user != 0) {
        //        $user = User::where('id', $user)->first();
        //        if ($user) {
        //            $user->notify(new EtapaMencionUser($etapa));
        //        }
        //    }
        //}

        if ($etapa) {
            if($columns['obs_texto'] != ''){
                $etapa->comments()->create($columns);
            }

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

    public function commentDestroy(int $obraId, int $etapaId, int $commentId)
    {

        if (!$obra = $this->obra->where('id', $obraId)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        if (!$etapa = $this->repository->where('id', $etapaId)->first()) {
            return response()->json('Object Etapa not found', 404);
        }

        if (!$comment = $etapa->comments()->where('id', $commentId)->first()) {
            return response()->json('Object Comentario not found', 404);
        }

        if (auth()->user()->id == $comment->user->id) {
            $comment->delete();
            return response()->json('Deletado com sucesso', 200);
        }

        return response()->json('Não foi possivel Deletar', 404);
    }

    public function deleteSelected(Request $request, $obraId)
    {
        $etapas = $request->input('id_etapa');

        if (!$obra = $this->obra->where('id', $obraId)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        if ($etapas && count($etapas) > 0) {
            foreach ($etapas as $etp) {
                $etapa = $obra->etapas()->where('id', $etp)->first();
                if ($etapa) {
                    $etapa->delete();
                }
            }
        }

        return response()->json('Deletado com sucesso', 200);
    }

    public function updateSelecteds(Request $request, $obraId)
    {
        $columns = $request->only(['meta_etapa', 'responsavel']);
        $etapas = $request->input('etapas');
        $etapas = explode(',', $etapas);

        if (!$obra = $this->obra->where('id', $obraId)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        if ($etapas && count($etapas) > 0) {
            foreach ($etapas as $etp) {
                $etapa = $obra->etapas()->where('id', $etp)->first();
                if ($etapa) {
                    $etapa->update($columns);
                }
            }
        }

        return redirect()
            ->back()
            ->with('Atualizado com sucesso');
    }
}
