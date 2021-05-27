<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateDepartment;
use App\Models\Client;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $repository;

    public function __construct(Department $departments, Client $client)

    {
        $this->repository = $departments;
        $this->client = $client;

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
    public function store(Request $request, $client_uuid)
    {
        $columns = $request->input('dep');

        if (!$client = $this->client->where('uuid', $client_uuid)->first()) {

            return redirect()
                ->route('clients.index')
                ->with('message', 'Registro (Cliente) não encontrado!');
        }

        for ($q = 0; $q < count($columns['dep_responsavel']); $q++) {
            if ($columns['dep_responsavel'][$q] != '') {
                $this->repository->create([
                    "client_id" => $client->id,
                    "dep_responsavel" => $columns['dep_responsavel'][$q],
                    "dep_telefone_celular" => $columns['dep_telefone_celular'][$q],
                    "dep_telefone_fixo" => $columns['dep_telefone_fixo'][$q],
                    "dep_email" => $columns['dep_email'][$q],
                    "dep_funcao" => $columns['dep_funcao'][$q],
                ]);
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
    public function update(Request $request,  $id, $client_uuid = false)
    {
        $columns = $request->all();

        if (!$department = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('testes.index')
                ->with('error', 'Registro não encontrado!');
        }

        $department->update($columns);

        if ($client_uuid) {
            return redirect()
                ->route('clients.show', $client_uuid)
                ->with('message', 'Atualizado com sucesso');
        }

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $client_uuid = false)
    {
        if (!$department = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->back()
                ->with('error', 'Registro não encontrado!');
        }

        $department->delete();

        if ($client_uuid) {
            return redirect()
                ->route('clients.show', $client_uuid)
                ->with('message', 'Atualizado com sucesso');
        }

        return redirect()
            ->route('clients.index')
            ->with('message', 'Excluir com sucesso!');
    }
}
