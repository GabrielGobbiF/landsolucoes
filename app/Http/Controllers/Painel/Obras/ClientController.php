<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateClient;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    protected $repository;

    public function __construct(Client $cliente)
    {
        $this->repository = $cliente;

        //$this->middleware(['can:view-clients']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.painel.obras.clients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        # return view('pages.painel.obras.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateClient $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('clients.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if (!$client = $this->repository->where('id', $id)->with('departments')->first()) {

            return redirect()
                ->route('clients.index')
                ->with('message', 'Registro não encontrado!');
        }

        $departments = $client->departments ?? [];

        return view('pages.painel.obras.clients.show', [
            'client' => $client,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateClient $request, $uuid)
    {
        $columns = $request->all();

        if (!$client = $this->repository->where('uuid', $uuid)->first()) {
            return redirect()
                ->route('clients.index')
                ->with('message', 'Registro não encontrado!');
        }

        $client->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        if (!$client = $this->repository->where('uuid', $uuid)->first()) {
            return redirect()
                ->route('clients.index')
                ->with('message', 'Registro não encontrado!');
        }

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('message', 'Excluir com sucesso!');
    }
}
