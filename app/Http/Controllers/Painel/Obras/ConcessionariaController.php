<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateConcessionaria;
use App\Models\Concessionaria;
use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;

class ConcessionariaController extends Controller
{
    protected $repository;

    public function __construct(Concessionaria $concessionarias)
    {
        $this->repository = $concessionarias;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::get();

        return view('pages.painel.obras.concessionarias.index', [
            'services' => $services
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateConcessionaria $request)
    {
        $columns = $request->all();

        $concessionaria = $this->repository->create($columns);

        $concessionaria->services()->attach($columns['service']);

        return redirect()
            ->route('concessionarias.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teste  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$concessionaria = $this->repository->where(function ($query) use ($id) {
            $query->where('id', $id);
            $query->orWhere('slug', $id);
        })->with('departments')->with('services')->first()) {
            return redirect()
                ->route('concessionarias.index')
                ->with('error', 'Registro não encontrado!');
        }

        $departments = $concessionaria->departments ?? [];

        $services = $concessionaria->services()->orderBy('name')->get() ?? [];

        $id_concessionaria = $concessionaria->id;

        $servicesNotConces = Service::whereDoesntHave('concessionaria', function (Builder $query) use ($id_concessionaria){
            $query->where('concessionaria_id', $id_concessionaria);
        })->get();

        return view('pages.painel.obras.concessionarias.show', [
            'concessionaria' => $concessionaria,
            'departments' => $departments,
            'Cservices' => $services,
            'servicesNotConces' => $servicesNotConces,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateConcessionaria $request, $id)
    {
        $columns = $request->all();

        if (!$concessionaria = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('concessionarias.index')
                ->with('error', 'Registro não encontrado!');
        }

        $concessionaria->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teste  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$concessionaria = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('concessionarias.index')
                ->with('error', 'Registro não encontrado!');
        }

        $concessionaria->delete();

        return redirect()
            ->route('concessionarias.index')
            ->with('message', 'Deletado com sucesso!');
    }
}
