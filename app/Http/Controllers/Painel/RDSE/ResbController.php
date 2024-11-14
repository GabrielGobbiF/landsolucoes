<?php

namespace App\Http\Controllers;

use App\Models\Resb;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResbController extends Controller
{
    protected $repository;

    public function __construct(Resb $resbs)
    {
        $this->repository = $resbs;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resbs = Resb::all();

        return view('admin.resbs.index', [
            'resbs'=>$resbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateResb $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('resbs.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resb  $identify
     * @return \Illuminate\Http\Response
     */
    public function show(int $identify)
    {
        if (!$resb = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('resbs.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('admin.resbs.show', [
            'resb' => $resb,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resb  $identify
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateResb $request, int $identify)
    {
        $columns = $request->all();

        if (!$resb = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('resbs.index')
                ->with('message', 'Registro não encontrado!');
        }

        $resb->update($columns);

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
        if (!$resb = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('resbs.index')
                ->with('message', 'Registro (Resbe) não encontrado!');
        }

        $resb->delete();

        return redirect()
            ->route('resbs.index')
            ->with('message', 'Deletado com sucesso');
    }

}
