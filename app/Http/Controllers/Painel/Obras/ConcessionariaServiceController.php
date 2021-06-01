<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateService;
use App\Http\Requests\StoreUpdateConcessionaria;
use App\Models\Concessionaria;
use App\Models\Service;
use App\Models\Tipo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ConcessionariaServiceController extends Controller
{
    protected $repository;

    public function __construct(Concessionaria $concessionarias, Service $services)
    {
        $this->repository = $concessionarias;
        $this->services = $services;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug_concessionaria, $slug_service)
    {
        if (!$concessionaria = $this->repository->where('slug', $slug_concessionaria)->first()) {
            return redirect()
                ->route('concessionarias.show', $slug_concessionaria)
                ->with('error', 'Registro (Concessionaria) não encontrado!');
        }

        if (!$service = $this->services->where('slug', $slug_service)->first()) {
            return redirect()
                ->route('concessionarias.show', $slug_concessionaria)
                ->with('error', 'Registro (Serviço) não encontrado!');
        }

        $tipos = Tipo::all();

        return view('pages.painel.obras.concessionarias.services.etapas.index', [
            'concessionaria' => $concessionaria,
            'service' => $service,
            'tipos' => $tipos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function concessionaria_service_store(Request $request, $id)
    {
        $id_service = $request->input('service') ?? false;

        if (!$concessionaria = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('concessionarias.index')
                ->with('error', 'Registro não encontrado!');
        }

        if (!$id_service) {
            return redirect()
                ->route('concessionarias.show', $concessionaria->slug)
                ->with('error', 'Nenhum serviço selecionado');
        }

        $concessionaria->services()->attach($id_service);

        return redirect()
            ->route('concessionarias.show', $concessionaria->slug)
            ->with('message', 'Serviço Adicionado com sucesso');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teste  $id
     * @return \Illuminate\Http\Response
     */
    public function concessionaria_service_destroy($id, $service_id)
    {
        if (!$concessionaria = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('concessionarias.index')
                ->with('error', 'Registro não encontrado!');
        }

        $concessionaria->services()->detach($service_id);

        return redirect()
            ->route('concessionarias.show', $concessionaria->slug)
            ->with('message', 'Serviço Removido com sucesso');
    }
}
