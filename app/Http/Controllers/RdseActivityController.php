<?php

namespace App\Http\Controllers;

use App\Models\RdseActivity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RdseActivityController extends Controller
{
    protected $repository;

    public function __construct(RdseActivity $rdseActivitys)
    {
        $this->repository = $rdseActivitys;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rdseActivitys = RdseActivity::all();

        return view('admin.rdseActivitys.index', [
            'rdseActivitys'=>$rdseActivitys
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateRdseActivity $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('rdseActivitys.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RdseActivity  $identify
     * @return \Illuminate\Http\Response
     */
    public function show(int $identify)
    {
        if (!$rdseActivity = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('rdseActivitys.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('admin.rdseActivitys.show', [
            'rdseActivity' => $rdseActivity,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RdseActivity  $identify
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateRdseActivity $request, int $identify)
    {
        $columns = $request->all();

        if (!$rdseActivity = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('rdseActivitys.index')
                ->with('message', 'Registro não encontrado!');
        }

        $rdseActivity->update($columns);

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
        if (!$rdseActivity = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('rdseActivitys.index')
                ->with('message', 'Registro (RdseActivitye) não encontrado!');
        }

        $rdseActivity->delete();

        return redirect()
            ->route('rdseActivitys.index')
            ->with('message', 'Deletado com sucesso');
    }

}
