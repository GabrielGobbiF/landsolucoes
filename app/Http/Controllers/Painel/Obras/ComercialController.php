<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateComercial;
use App\Models\Addres;
use App\Models\Client;
use App\Models\Concessionaria;
use App\Models\Obra;
use App\Models\Service;
use App\Models\Viabilization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ComercialController extends Controller
{
    protected $repository;

    public function __construct(Obra $comercial)
    {
        $this->repository = $comercial;

        //$this->middleware(['can:view-comercial']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.painel.obras.comercial.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        $services = Service::all();
        $concessionarias = Concessionaria::all();

        return view('pages.painel.obras.comercial.create', [
            'clients' => $clients,
            'services' => $services,
            'concessionarias' => $concessionarias,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateComercial $request)
    {
        $address = new Addres();
        $viabilizacao = new Viabilization();

        $columnsViabilizacao = $request->only('viabilizacao');
        $columns = $request->except('viabilizacao');

        $columns['address_id'] = $address->create()->id;
        $columns['viabilization_id'] = $viabilizacao->create($columnsViabilizacao['viabilizacao'])->id;

        $this->repository->create($columns);

        return redirect()
            ->route('comercial.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comercial  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$comercial = $this->repository->where('id', $id)->with('service')->with('concessionaria')->with('viabilizacao')->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        $clients = Client::all();
        $services = Service::all();
        $concessionarias = Concessionaria::all();

        return view('pages.painel.obras.comercial.show', [
            'comercial' => $comercial,
            'clients' => $clients,
            'services' => $services,
            'concessionarias' => $concessionarias,
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
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        $client->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');

        if (!$comercial = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        return response($comercial->update(['status' => $status]), 200);
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
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        $client->delete();

        return redirect()
            ->route('comercial.index')
            ->with('message', 'Excluir com sucesso!');
    }
}
