<?php

namespace App\Http\Controllers\Painel\RDSE;

use App\Models\RSDE\Handswork;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HandsworkController extends Controller
{
    protected $repository;

    public function __construct(Handswork $handsworks)
    {
        $this->repository = $handsworks;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #$handsworks = Handswork::all();

        return view('pages.painel.rdse.handsworks.index', [
            #'handsworks' => $handsworks
        ]);
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
            ->route('handswork.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Handswork  $identify
     * @return \Illuminate\Http\Response
     */
    public function show($identify)
    {
        if (!$handswork = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('handswork.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.rdse.handsworks.show', [
            'handswork' => $handswork,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Handswork  $identify
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $identify)
    {
        $columns = $request->all();

        if (!$handswork = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('handswork.index')
                ->with('message', 'Registro não encontrado!');
        }

        $handswork->update($columns);

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
        if (!$handswork = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('handswork.index')
                ->with('message', 'Registro (Handsworke) não encontrado!');
        }

        $handswork->delete();

        return redirect()
            ->route('handswork.index')
            ->with('message', 'Deletado com sucesso');
    }
}
