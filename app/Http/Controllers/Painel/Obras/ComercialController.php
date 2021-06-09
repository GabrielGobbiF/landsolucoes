<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateComercial;
use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ComercialController extends Controller
{
    protected $repository;

    public function __construct(Obra $comercial)
    {
        $this->repository = $comercial;

        //$this->middleware(['can:view-comerciais']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comerciais  = $this->repository
            ->where('status', '<>', 'aprovada')
            ->with('concessionaria')
            ->with('service')
            ->with('client')
            ->get();

        return view('pages.painel.obras.comercial.index', [
            'comerciais' => $comerciais
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        # return view('pages.painel.obras.comerciais.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateComercial $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('comerciais.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        if (!$client = $this->repository->where('uuid', $uuid)->with('departments')->first()) {

            return redirect()
                ->route('comerciais.index')
                ->with('message', 'Registro não encontrado!');
        }

        $departments = $client->departments ?? [];

        return view('pages.painel.obras.comerciais.show', [
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
    public function update(StoreUpdateComercial $request, $uuid)
    {
        $columns = $request->all();

        if (!$client = $this->repository->where('uuid', $uuid)->first()) {
            return redirect()
                ->route('comerciais.index')
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
     * @param  \App\Models\Comercial  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        if (!$client = $this->repository->where('uuid', $uuid)->first()) {
            return redirect()
                ->route('comerciais.index')
                ->with('message', 'Registro não encontrado!');
        }

        $client->delete();

        return redirect()
            ->route('comerciais.index')
            ->with('message', 'Excluir com sucesso!');
    }
}
