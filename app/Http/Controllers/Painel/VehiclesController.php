<?php

namespace App\Http\Controllers\Painel;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateVehicle;
use App\Models\Role;

class VehiclesController extends Controller
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
        return view('pages.painel.vehicles.vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateVehicle $request)
    {
        $columns = $request->all();

        $columns['secure'] = isset($columns['secure']) ? '1' : '0';
        $columns['tracker'] = isset($columns['tracker']) ? '1' : '0';
        $columns['rented'] = isset($columns['rented']) ? '1' : '0';
        $columns['external_camera'] = isset($columns['external_camera']) ? '1' : '0';
        $columns['internal_camera'] = isset($columns['internal_camera']) ? '1' : '0';

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

        $activitys = $vehicle->activitys()->orderby('id', 'DESC')->get();

        $activityEnd = $vehicle->activitys()->orderby('id', 'DESC')->first();

        $ultimaKM = isset($activityEnd->km_end) && $activityEnd->km_end != '' ? $activityEnd->km_end : '';

        return view('pages.painel.vehicles.vehicles.show', [
            'vehicle' => $vehicle,
            'activitys' => $activitys,
            'ultimaKM' => $ultimaKM
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

        $columns['secure'] = isset($columns['secure']) ? '1' : '0';
        $columns['tracker'] = isset($columns['tracker']) ? '1' : '0';
        $columns['rented'] = isset($columns['rented']) ? '1' : '0';
        $columns['external_camera'] = isset($columns['external_camera']) ? '1' : '0';
        $columns['internal_camera'] = isset($columns['internal_camera']) ? '1' : '0';

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function qrcode($vehicle_id)
    {
        if (!$vehicle = $this->repository->find($vehicle_id)) {
            return redirect()
                ->route('vehicles.index')
                ->with('message', 'Registro não encontrado!');
        }

        $drivers = Role::where('slug', 'driver')->first();

        $usersDrivers = $drivers->users()->get();

        return view('pages.painel.vehicles.vehicles.qrcode', [
            'usersDrivers' => $usersDrivers,
            'vehicle' => $vehicle
        ]);
    }
}
