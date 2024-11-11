<?php

namespace App\Http\Controllers;

use App\Models\TiposObra;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TiposObraController extends Controller
{

    public function __construct(protected TiposObra $repository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $tiposObras = TiposObra::all();

        return view('pages.painel.obras.tipos_obra.index', [
            'tiposObras' => $tiposObras
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
            ->route('tipos_obra.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TiposObra  $identify
     *
     */
    public function show(int $identify)
    {
        if (!$tiposObra = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('tipos_obra.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.obras.tipos_obra.show', [
            'tiposObra' => $tiposObra,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TiposObra  $identify
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
                ->route('tipos_obra.index')
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
                ->route('tipos_obra.index')
                ->with('message', 'Registro (TiposObra) não encontrado!');
        }

        $equipe->delete();

        return redirect()
            ->route('tipos_obra.index')
            ->with('message', 'Deletado com sucesso');
    }
}
