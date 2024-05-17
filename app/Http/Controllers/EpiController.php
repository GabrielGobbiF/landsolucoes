<?php

namespace App\Http\Controllers;

use App\Models\Epi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EpiController extends Controller
{
    protected $repository;

    public function __construct(Epi $epis)
    {
        $this->repository = $epis;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $epis = Epi::all();

        return view('admin.epis.index', [
            'epis'=>$epis
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateEpi $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('epis.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Epi  $identify
     * @return \Illuminate\Http\Response
     */
    public function show(int $identify)
    {
        if (!$epi = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('epis.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('admin.epis.show', [
            'epi' => $epi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Epi  $identify
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateEpi $request, int $identify)
    {
        $columns = $request->all();

        if (!$epi = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('epis.index')
                ->with('message', 'Registro não encontrado!');
        }

        $epi->update($columns);

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
        if (!$epi = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('epis.index')
                ->with('message', 'Registro (Epie) não encontrado!');
        }

        $epi->delete();

        return redirect()
            ->route('epis.index')
            ->with('message', 'Deletado com sucesso');
    }

}
