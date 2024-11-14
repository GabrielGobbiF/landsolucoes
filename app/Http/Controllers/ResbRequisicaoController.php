<?php

namespace App\Http\Controllers;

use App\Models\ResbRequisicao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResbRequisicaoController extends Controller
{
    protected $repository;

    public function __construct(ResbRequisicao $resbRequisicaos)
    {
        $this->repository = $resbRequisicaos;
    }

    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $resbRequisicaos = ResbRequisicao::all();

        return view('admin.resbRequisicaos.index', [
            'resbRequisicaos' => $resbRequisicaos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(StoreUpdateResbRequisicao $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('resbRequisicaos.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResbRequisicao  $identify
     *
     */
    public function show(int $identify)
    {
        if (!$resbRequisicao = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('resbRequisicaos.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('admin.resbRequisicaos.show', [
            'resbRequisicao' => $resbRequisicao,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResbRequisicao  $identify
     *
     */
    public function update(StoreUpdateResbRequisicao $request, int $identify)
    {
        $columns = $request->all();

        if (!$resbRequisicao = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('resbRequisicaos.index')
                ->with('message', 'Registro não encontrado!');
        }

        $resbRequisicao->update($columns);

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
        if (!$resbRequisicao = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('resbRequisicaos.index')
                ->with('message', 'Registro (ResbRequisicaoe) não encontrado!');
        }

        $resbRequisicao->delete();

        return redirect()
            ->route('resbRequisicaos.index')
            ->with('message', 'Deletado com sucesso');
    }
}
