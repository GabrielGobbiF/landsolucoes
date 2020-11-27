<?php

namespace App\Http\Controllers\Painel;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehiclesController extends Controller
{
    protected $repository;

    public function __construct(Vehicle $vehicles)
    {
        $this->repository = $vehicles;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = $this->repository->all();

        return view('pages.painel.vehicles.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.painel.vehicles.vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $columns = $request->all();

        $vehicles = $this->repository->create($columns);

        return redirect()
            ->route('vehicles.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\vehicles  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$vehicle = $this->repository->find($id)) {
            return redirect()
                ->route('vehicles.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.vehicles.vehicles.show', [
            'vehicle' => $vehicle,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\vehicles  $vehicles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $columns = $request->all();

        if (!$vehicle = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('vehicles.index')
                ->with('message', 'Registro não encontrado!');
        }

        $vehicle->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\vehicles  $vehicles
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$vehicles = $this->repository->find($id)) {
            return redirect()
                ->route('vehicles.index')
                ->with('message', 'Registro não encontrado!');
        }

        $vehicles->delete();

        return redirect()
            ->route('vehicles.index')
            ->with('message', 'Deletado com sucesso!');
    }

    /**
     * Search results
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $vehicles = $this->repository
            ->where(function ($query) use ($request) {
                if ($request->filter) {
                    $query->where('name', $request->filter);
                    $query->orWhere('description', 'LIKE', "%{$request->filter}%");
                }
            })
            ->paginate();

        return view('pages.painel.vehicles.vehicles.index', compact('vehicles', 'filters'));
    }
}
