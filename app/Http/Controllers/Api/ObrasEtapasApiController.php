<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEtapaObra;
use App\Http\Resources\CommentsResource;
use App\Http\Resources\ObraEtapasResource;
use App\Models\Etapa;
use App\Models\Obra;
use App\Models\ObraEtapa;
use App\Models\ObraEtapasFinanceiro;
use App\Models\User;
use App\Notifications\EtapaMencionUser;
use App\Services\EtapaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        $filters = $request->only(['term', 'type', 'nconcluidas']);

        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $etapasAll = [];

        $etapas = $obra->etapas()
            ->where(function ($query) use ($filters) {
                if ($filters['type'] != '') {
                    $query->where('tipo_id', $filters['type']);
                }
                if ($filters['term'] != '') {
                    $query->where('nome', 'LIKE', '%' . $filters['term'] . '%');
                }

                if (isset($filters['nconcluidas']) && $filters['nconcluidas']) {
                    $query->where('check', 'EM');
                }
            })
            #->with('financeiro')
            ->with('tipo', 'files')
            ->orderBy('tipo_id')
            ->orderBy('ordem')
            ->get();

        return ObraEtapasResource::collection($etapas);
    }

    public function get($obra_id, $etapa_id)
    {
        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        if (!$etapa = $obra->etapas()->with('activities')->where('id', $etapa_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

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

        if (!auth()->check()) {
            if (auth()->guard('clients')->check()) {
                $columns['user_id'] = auth()->guard('clients')->user()->id;
                $columns['type'] = 'cliente';
            }
        } else {
            $columns['user_id'] = Auth::id();
        }

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
            if ($columns['obs_texto'] != '') {
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

        $etapaFinanceiro = ObraEtapasFinanceiro::where('etapa_id', $etapa->id_etapa)
            ->where('obra_id', $obra->id)
            ->first();

        $etapa->update(['check' => $check]);

        if ($etapaFinanceiro && $check == 'C') {

            #if (app()->isProduction()) {
                app(EtapaService::class)->sendMessageCheckFaturamento($etapa, $etapaFinanceiro);
            #}
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

        if ($comment->type == 'usuario' && auth()->user()->id == $comment->user->id) {
            $comment->delete();
            return response()->json('Deletado com sucesso', 200);
        }

        if ($comment->type == 'cliente' && auth()->guard('clients')->user()->id == $comment->user->id) {
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

                $verifyEtapaFinance = ObraEtapasFinanceiro::where('etapa_id', $etapa->id_etapa)
                    ->where('obra_id', $obra->id)
                    ->exists();

                throw_if(
                    $verifyEtapaFinance,
                    ValidationException::withMessages(['message' => 'Não é possivel deletar essa etapa, pois ela é uma etapa de financeiro'])
                );

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

    public function addEtapas(Request $request, $obraId)
    {
        if (!$obra = $this->obra->where('id', $obraId)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $etapas = $request->input('etapas');

        $etapasModel = Etapa::whereIn('id', $etapas)->get();

        $etapasGroupModel = $etapasModel->groupBy('tipo_id');

        foreach ($etapasGroupModel as $tipo => $etapa) {

            foreach ($etapa as $etp) {
                $ordem = $this->reordenarObraEtapas($obra, $tipo, count($etapa));

                $etapaInModel = $etapasModel->where('id', $etp->id)->first();

                $obraEtapa = ObraEtapa::create([
                    'id_obra' => $obra->id,
                    'id_etapa' => $etapaInModel->id,
                    'tipo_id' => $etapaInModel->tipo_id,
                    'nome' => $etapaInModel->name,
                    'ordem' => is_int($ordem) ? $ordem : $ordem->order - 1,
                    'preco' => $etapaInModel->preco,
                    'unidade' => $etapaInModel->unidade,
                    'quantidade' => $etapaInModel->quantidade ?? 0,
                ]);
            }
        }
    }

    private function reordenarObraEtapas($obra, $tipoId, $quantidadeEtapas)
    {
        // Pegar todas as etapas do mesmo tipo e ordenar por 'ordem' em ordem crescente
        $etapas = $obra->etapas()
            ->where('tipo_id', $tipoId)
            ->orderBy('ordem', 'asc')
            ->get();

        // Incrementar a ordem das etapas existentes para abrir espaço para as novas etapas
        foreach ($etapas as $etapa) {
            $etapa->ordem += $quantidadeEtapas;
            $etapa->save();
        }

        return $etapas->first() ?? 0;
    }

    public function reordenarEtapas(Request $request, $obraId)
    {
        if (!$obra = $this->obra->where('id', $obraId)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $ordemEtapas = $request->input('ordem');

        // Organizar as etapas por tipo_id
        $etapasPorTipo = collect($ordemEtapas)->groupBy('tipo_id');

        // Atualizar a ordem de cada tipo separadamente
        foreach ($etapasPorTipo as $tipoId => $etapas) {
            foreach ($etapas as $etapa) {
                DB::table('obras_etapas')
                    ->where('id', $etapa['id'])
                    ->update(['ordem' => $etapa['ordem']]);
            }
        }

        return response()->json('', 200);
    }
}
