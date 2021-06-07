<?php

namespace App\Http\Controllers\Painel\Obras\Etapas;

use App\Http\Controllers\Controller;
use App\Models\Variable;
use Illuminate\Http\Request;

class VariableController extends Controller
{
    protected $repository;

    public function __construct(Variable $variables)
    {
        $this->repository = $variables;

        //$this->middleware(['can:view-testes']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variable  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$variable = $this->repository->where('id', $id)->first()) {
            response()->json('Object not found');
        }

        return response()->json($variable->delete());

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }
}
