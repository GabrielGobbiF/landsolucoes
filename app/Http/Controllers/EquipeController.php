<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    protected $repository;

    public function __construct(Equipe $equipes)
    {
        $this->repository = $equipes;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $equipes = Equipe::all();

        return view('pages.painel.rdse.equipes.index', [
            'equipes' => $equipes
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
            ->route('equipes.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipe  $identify
     *
     */
    public function show(int $identify)
    {
        if (!$equipe = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('equipes.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.rdse.equipes.show', [
            'equipe' => $equipe,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Equipe  $identify
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
                ->route('equipes.index')
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
                ->route('equipes.index')
                ->with('message', 'Registro (Equipee) não encontrado!');
        }

        $equipe->delete();

        return redirect()
            ->route('equipes.index')
            ->with('message', 'Deletado com sucesso');
    }
}
