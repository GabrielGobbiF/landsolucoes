<?php

namespace App\Http\Controllers\Painel\Obras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Obra;

class FinanceiroController extends Controller
{
    protected $repository;

    public function __construct(Obra $obra)
    {
        $this->repository = $obra;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $obraId)
    {
        if (!$obra = $this->repository->with('address')->with('client')->with('financeiro')->find($obraId)) {
            return redirect()
                ->route('obras')
                ->with('message', 'Registro não encontrado!');
        }

        $etapas = $obra->etapas_financeiro()->with('etapa')->with('faturamento')->get();

        return view('pages.painel.obras.obras.financeiro.index', [
            'obra' => $obra,
            'etapas' => $etapas
        ]);
    }
}
