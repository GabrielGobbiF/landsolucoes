<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEtapa;
use App\Models\Etapas;
use Illuminate\Http\Request;

class EtapasController extends Controller
{
    protected $repository;

    public function __construct(Etapas $etapas)
    {
        $this->repository = $etapas;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateEtapa $request)
    {
        $columns = $request->except('redirect');

        $this->repository->create($columns);

        #return response()->json(['created' => true]);

        if ($redirect = $request->input('redirect')) {
            return redirect()
                ->to($redirect . '?tipo=' . $columns['tipo_id'])
                ->with('message', 'Criado com sucesso');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Etapas  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        if (!$department = $this->repository->where('slug', $slug)->first()) {
            return redirect()
                ->route('testes.index')
                ->with('error', 'Registro não encontrado!');
        }

        return view('page.show', []);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $columns = $request->all();

        $type = $request->input('type');

        $typeValue = $request->input('typeValue');

        $redirect = $type == 'concessionaria_id' ? 'concessionaria' : 'client';

        if (!$department = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('testes.index')
                ->with('error', 'Registro não encontrado!');
        }

        if ($columns['dep_responsavel'] != '') {
            $department->update($columns);
        }

        return redirect()
            ->route($redirect . 's.show', $typeValue)
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Etapas  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$department = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('testes.index')
                ->with('error', 'Registro não encontrado!');
        }

        $department->delete();

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }
}
