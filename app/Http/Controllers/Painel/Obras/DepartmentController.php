<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateDepartment;
use App\Http\Resources\DepartmentResource;
use App\Models\Client;
use App\Models\Concessionaria;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $repository, $client, $concessionaria;

    public function __construct(Department $departments, Client $client, Concessionaria $concessionaria)

    {
        $this->repository = $departments;

        $this->client = $client;

        $this->concessionaria = $concessionaria;

        //$this->middleware(['can:view-testes']);
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
    public function store(Request $request)
    {
        $columns = $request->input('dep');

        $type = $request->input('type');

        $typeValue = $request->input('typeValue');

        $repository = $type == 'concessionaria_id' ? new Concessionaria() : new Client();

        if (!$repository = $repository->where('id', $typeValue)->first()) {
            return redirect()
                ->back()
                ->with('error', 'Registro não encontrado!');
        }

        if (isset($columns['dep_responsavel'])) {
            for ($q = 0; $q < count($columns['dep_responsavel']); $q++) {
                if ($columns['dep_responsavel'][$q] != '') {

                    $columnsStore = [
                        "dep_responsavel" => $columns['dep_responsavel'][$q],
                        "dep_telefone_celular" => $columns['dep_telefone_celular'][$q],
                        "dep_telefone_fixo" => $columns['dep_telefone_fixo'][$q],
                        "dep_email" => $columns['dep_email'][$q],
                        "dep_funcao" => $columns['dep_funcao'][$q],
                    ];

                    $repository->departments()->create($columnsStore);
                }
            }
        }

        return redirect()
            ->back()
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$department = $this->repository->where('id', $id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        return new DepartmentResource($department);

        #return view('page.show', []);
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
     * @param  \App\Models\Department  $id
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
