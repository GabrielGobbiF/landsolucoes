<?php

namespace App\Http\Controllers\Painel;

use App\Models\VehicleActivities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateVehicleActivitie;
use App\Models\Role;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VehicleActivitiesController extends Controller
{

    protected $repository;

    public function __construct(Vehicle $vehicles)
    {
        $this->middleware('auth');

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
        //return view('pages.painel.vehicles.vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $vehicle_id)
    {
        $columns = $request->all();

        if (!$vehicle = $this->repository->find($vehicle_id)) {
            return redirect()
                ->route('vehicles.index')
                ->with('message', 'Registro não encontrado!');
        }

        $columns['driver_id'] = Auth::user()->id;
        $columns['driver_name'] = Auth::user()->name;

        $activity = $vehicle->activitys()->create($columns);

        if ($request->hasFile('image') && $request->image->isValid()) {

            $docs_name = date('Y-m-d') . '__' . $activity->id . '.' . $request->file('image')->extension();

            $columns['nota_fiscal'] = $request->image->storeAs("vehicles/" . Str::slug($vehicle->name, '-') . "/abastecimento", "{$docs_name}");

            $activity->update($columns);
        }

        return redirect()
            ->route('vehicles.show', $vehicle_id)
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

        $activitys = $vehicle->activitys()->get();

        return view('pages.painel.vehicles.vehicles.show', [
            'vehicle' => $vehicle,
            'activitys' => $activitys,
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
