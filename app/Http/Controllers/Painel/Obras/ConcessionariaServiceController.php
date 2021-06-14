<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Concessionaria;
use App\Models\Etapa;
use App\Models\Service;
use App\Models\Tipo;
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

    public function concessionaria_service_etapa_store(Request $request, $id_concessionaria, $id_service)
    {
        $order = 0;

        $etapa_id = $request->input('etapa_id');

        if (!$concessionaria = $this->repository->where('id', $id_concessionaria)->first()) {
            return response()->json('Object not found');
        }

        if (!$service = $this->services->where('id', $id_service)->first()) {
            return response()->json('Object not found');
        }

        if (!$etapa = Etapa::where('id', $etapa_id)->first()) {
            return response()->json('Object not found');
        }

        $UltimaEtapa = $concessionaria->etapas($service->id)->where('tipo_id', $etapa->tipo_id)->orderby('con_service_etp.id', 'DESC')->first();

        $order = 0;

        if (!is_null($UltimaEtapa)) {
            $order = $UltimaEtapa->pivot->order;
            $order = $order + 1;
        }

        $concessionaria->etapas($service->id)->attach($etapa_id, ['service_id' => $service->id, 'order' => $order]);

        return response()->json(['created' => true]);
    }

    public function concessionaria_service_etapa_destroy(Request $request, $id_concessionaria, $id_service)
    {
        $etapa_id = $request->input('etapa_id');

        if (!$concessionaria = $this->repository->where('id', $id_concessionaria)->first()) {
            return response()->json('Object not found');
        }

        if (!$service = $this->services->where('id', $id_service)->first()) {
            return response()->json('Object not found');
        }

        if (!$etapa = Etapa::where('id', $etapa_id)->first()) {
            return response()->json('Object not found');
        }

        $concessionaria->etapas($service->id)->detach($etapa->id);

        return response()->json(['detach' => true]);
    }

    public function concessionaria_service_etapa_reorder(Request $request, $id_concessionaria, $id_service)
    {
        $itens = $request->input('itens');

        if (!$concessionaria = $this->repository->where('id', $id_concessionaria)->first()) {
            return response()->json('Object not found');
        }

        if (!$service = $this->services->where('id', $id_service)->first()) {
            return response()->json('Object not found');
        }

        $etapa = $concessionaria->etapas($service->id)->get();

        foreach ($itens as $a => $value) {
            $a = $a + 1;
            $etp = $etapa->where('pivot.etapa_id', $value)->first();
            $etp->pivot->order = $a;
            $etp->pivot->update();
            $etp->pivot->save();
        }

        return response()->json('reorder');
    }

    public function servicesByConcessionariaId($id_concessionaria)
    {
        if (!$concessionaria = Concessionaria::where('id', $id_concessionaria)->with('services')->first()) {
            return response()->json('Object concessionaria not found', 404);
        }

        $services = $concessionaria->services ?? [];

        return ServiceResource::collection($services);
    }
}
