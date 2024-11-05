<?php

namespace App\Http\Controllers\Painel\RDSE;

use App\Models\Supervisor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    protected $repository;

    public function __construct(Supervisor $supervisores)
    {
        $this->repository = $supervisores;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $supervisores = Supervisor::all();

        return view('pages.painel.rdse.supervisores.index', [
            'supervisores' => $supervisores
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $columns = $request->only('name');

        $this->repository->create($columns);

        return redirect()
            ->route('supervisores.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supervisor  $identify
     *
     */
    public function show(int $identify)
    {
        if (!$equipe = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('supervisores.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.rdse.supervisores.show', [
            'equipe' => $equipe,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supervisor  $identify
     *
     */
    public function update(Request $request, int $identify)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $columns = $request->only('name');

        if (!$equipe = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('supervisores.index')
                ->with('message', 'Registro não encontrado!');
        }

        $equipe->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     */
    public function destroy($id)
    {
        if (!$equipe = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('supervisores.index')
                ->with('message', 'Registro (Supervisore) não encontrado!');
        }

        $equipe->delete();

        return redirect()
            ->route('supervisores.index')
            ->with('message', 'Deletado com sucesso');
    }
}
