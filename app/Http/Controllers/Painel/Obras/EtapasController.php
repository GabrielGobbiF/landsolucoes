<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEtapa;
use App\Http\Resources\EtapasResource;
use App\Models\Concessionaria;
use App\Models\Etapa;
use App\Models\Service;
use Illuminate\Http\Request;

class EtapasController extends Controller
{
    protected $repository;

    public function __construct(Etapa $etapas)
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

        $store = $etapa = $this->repository->create($columns);

        if (!$concessionaria = Concessionaria::where('id', $columns['concessionaria'])->first()) {
            return redirect()
                ->route('concessionarias.show', $columns['concessionaria'])
                ->with('error', 'Registro (Concessionaria) não encontrado!');
        }

        if (!$service = Service::where('id', $columns['service'])->first()) {
            return redirect()
                ->route('concessionarias.show', $columns['service'])
                ->with('error', 'Registro (Serviço) não encontrado!');
        }

        $UltimaEtapa = $concessionaria->etapas($service->id)->where('tipo_id', $etapa->tipo_id)->orderby('con_service_etp.id', 'DESC')->first();

        $order = 0;

        if (!is_null($UltimaEtapa)) {
            $order = $UltimaEtapa->pivot->order;
            $order = $order + 1;
        }

        $concessionaria->etapas($service->id)->attach($etapa->id, ['service_id' => $service->id, 'order' => $order]);

        return response()->json([
            'store' => $store,
            'success' => $store
        ]);

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
    public function show($id)
    {
        if (!$etapa = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('testes.index')
                ->with('error', 'Registro não encontrado!');
        }

        return new EtapasResource($etapa);
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
        $columns = $request->except(['redirect', 'tipo_id']);

        $redirect = $request->input('redirect');

        if (!$etapa = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('concessionarias.index')
                ->with('error', 'Registro não encontrado!');
        }

        $edit = $etapa->update($columns);

        return response()->json([
            'edit' => $edit,
            'success' => $edit
        ]);

        if ($redirect = $request->input('redirect')) {
            return redirect()
                ->to($redirect . '?tipo=' . $etapa->tipo_id)
                ->with('message', 'Alterado com sucesso');
        }
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
