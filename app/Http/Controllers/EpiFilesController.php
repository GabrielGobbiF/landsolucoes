<?php

namespace App\Http\Controllers;

use App\Models\EpiFiles;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EpiFilesController extends Controller
{
    protected $repository;

    public function __construct(EpiFiles $epiFiless)
    {
        $this->repository = $epiFiless;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $epiFiless = EpiFiles::all();

        return view('admin.epiFiless.index', [
            'epiFiless'=>$epiFiless
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateEpiFiles $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('epiFiless.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EpiFiles  $identify
     * @return \Illuminate\Http\Response
     */
    public function show(int $identify)
    {
        if (!$epiFiles = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('epiFiless.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('admin.epiFiless.show', [
            'epiFiles' => $epiFiles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EpiFiles  $identify
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateEpiFiles $request, int $identify)
    {
        $columns = $request->all();

        if (!$epiFiles = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('epiFiless.index')
                ->with('message', 'Registro não encontrado!');
        }

        $epiFiles->update($columns);

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
        if (!$epiFiles = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('epiFiless.index')
                ->with('message', 'Registro (EpiFilese) não encontrado!');
        }

        $epiFiles->delete();

        return redirect()
            ->route('epiFiless.index')
            ->with('message', 'Deletado com sucesso');
    }

}
