<?php

namespace App\Http\Controllers;

use App\Models\ETD;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ETDController extends Controller
{
    protected $repository;

    public function __construct(ETD $eTDs)
    {
        $this->repository = $eTDs;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eTDs = ETD::all();

        return view('admin.eTDs.index', [
            'eTDs'=>$eTDs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateETD $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('eTDs.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ETD  $identify
     * @return \Illuminate\Http\Response
     */
    public function show(int $identify)
    {
        if (!$eTD = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('eTDs.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('admin.eTDs.show', [
            'eTD' => $eTD,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ETD  $identify
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateETD $request, int $identify)
    {
        $columns = $request->all();

        if (!$eTD = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('eTDs.index')
                ->with('message', 'Registro não encontrado!');
        }

        $eTD->update($columns);

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
        if (!$eTD = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('eTDs.index')
                ->with('message', 'Registro (ETDe) não encontrado!');
        }

        $eTD->delete();

        return redirect()
            ->route('eTDs.index')
            ->with('message', 'Deletado com sucesso');
    }

}
