<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Celular;
use Illuminate\Http\Request;

class CelularesController extends Controller
{
    public function __construct(Celular $celular)
    {
        $this->repository = $celular;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.painel.celulares.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('celulares.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Celular  $identify
     * @return \Illuminate\Http\Response
     */
    public function show(int $identify)
    {
        if (!$celular = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('celulares.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.celulares.show', [
            'celular' => $celular,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Celular  $identify
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $identify)
    {
        $columns = $request->all();

        if (!$celular = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('celulares')
                ->with('message', 'Registro não encontrado!');
        }

        $celular->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$celular = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('celulares.index')
                ->with('message', 'Registro não encontrado!');
        }

        $celular->delete();

        return redirect()
            ->back()
            ->with('message', 'Deletado com sucesso');
    }
}
