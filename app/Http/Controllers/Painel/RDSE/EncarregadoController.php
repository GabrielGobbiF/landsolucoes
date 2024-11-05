<?php

namespace App\Http\Controllers\Painel\RDSE;

use App\Models\Encarregado;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EncarregadoController extends Controller
{
    protected $repository;

    public function __construct(Encarregado $encarregados)
    {
        $this->repository = $encarregados;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $encarregados = Encarregado::all();

        return view('pages.painel.rdse.encarregados.index', [
            'encarregados' => $encarregados
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
            ->route('encarregados.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Encarregado  $identify
     *
     */
    public function show(int $identify)
    {
        if (!$encarregado = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('encarregados.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.rdse.encarregados.show', [
            'encarregado' => $encarregado,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Encarregado  $identify
     *
     */
    public function update(Request $request, int $identify)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $columns = $request->only('name');

        if (!$encarregado = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('encarregados.index')
                ->with('message', 'Registro não encontrado!');
        }

        $encarregado->update($columns);

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
        if (!$encarregado = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('encarregados.index')
                ->with('message', 'Registro (Encarregadoe) não encontrado!');
        }

        $encarregado->delete();

        return redirect()
            ->route('encarregados.index')
            ->with('message', 'Deletado com sucesso');
    }
}
