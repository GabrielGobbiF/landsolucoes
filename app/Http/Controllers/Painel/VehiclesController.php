<?php

namespace App\Http\Controllers\Painel;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUser;
use App\Http\Requests\StoreUpdateVehicle;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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
        $vehicles = $this->repository->where('is_active', 'Y')->get();

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

        $abastecimento = [];
        $manutencao = [];
        $atividade = [];

        foreach ($activitys as $activity) {
            $tipo = $activity->title;
            switch ($tipo) {
                case 'manutencao':
                    $manutencao[] = $activity;
                    break;
                case 'abastecimento':
                    $abastecimento[] = $activity;
                    break;
                case 'atividade':
                    $atividade[] = $activity;
                    break;
                default:
                    break;
            }
        }

        $activityEnd = $vehicle->activitys()->orderby('id', 'DESC')->first();

        $ultimaKM = isset($activityEnd->km_end) && $activityEnd->km_end != '' ? $activityEnd->km_end : '';

        return view('pages.painel.vehicles.vehicles.show', [
            'vehicle' => $vehicle,
            'manutencao' => $manutencao,
            'abastecimento' => $abastecimento,
            'atividade' => $atividade,
            //'activitys' => $activitys,
            'ultimaKM' => $ultimaKM,
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

        if ($request->hasFile('document_attach') && $request->document_attach->isValid()) {
            $columns['document_attach'] = $request->document_attach->store("vehicles/" . Str::slug($vehicle->name, '-') . "/documento");
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

        $vehicles->is_active = 'N';
        $vehicles->save();
        $vehicles->update();
        //$vehicles->delete();

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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\vehicles  $vehicles
     * @return \Illuminate\Http\Response
     */
    public function document_destroy($id)
    {
        if (!$vehicle = Vehicle::where('id', $id)->first()) {
            return redirect()
                ->route('vehicles.index')
                ->with('message', 'Registro Veiiculo não encontrado!');
        }

        if (Storage::exists($vehicle->document_attach)) {
            Storage::delete($vehicle->document_attach);
        }

        $vehicle->document_attach = null;
        $vehicle->update();
        $vehicle->save();

        return redirect()
            ->route('vehicles.show', $id)
            ->with('message', 'Deletado com sucesso!');
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

        //Verificar se existe status em aberto desse Motorista
        $activityStatusOpen = $vehicle->activitys()
            ->where('driver_id', Auth::user()->id)
            ->where('status', Config::get('constants.EM_ABERTO'))
            ->where('title', 'atividade')
            ->first();

        /* todoFazer  retirar */
        $edps = DB::select('select * from edp');

        return view('pages.painel.vehicles.vehicles.qrcode', [
            'usersDrivers' => $usersDrivers,
            'vehicle' => $vehicle,
            'edps' => $edps,
            'activityStatusOpen' => $activityStatusOpen
        ]);
    }

    public function genereted_all_qrcode()
    {
        $vehicles = $this->repository->where('is_active', 'Y')->get();

        return view('pages.painel.vehicles.vehicles.all_qrcode', [
            'vehicles' => $vehicles
        ]);
    }

    public function drivers()
    {
        return view('pages.painel.vehicles.vehicles.drivers.index', []);
    }

    public function drivers_create()
    {
        return view('pages.painel.vehicles.vehicles.drivers.create');
    }

    public function drivers_store(StoreUpdateUser $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'] ?? null,
            'password' => Hash::make('cena1234'),
            'uuid' => Str::uuid(),
            'username' => strtolower(mb_convert_case($request['username'], MB_CASE_TITLE, "UTF-8")),
            'password_verified' => 'N',
        ]);

        $dev_role = Role::where('slug', 'driver')->first();

        $user->roles()->attach($dev_role);

        return redirect()
            ->route('vehicles.drivers')
            ->with('message', 'Criado com sucesso!');
    }

    public function driver_activeOrdesactive(Request $request, $driver_id)
    {
        $type = $request->input('desactive') == true ? 1 : 0;

        if (!$user = User::where('id', $driver_id)->first()) {
            return redirect()
                ->route('vehicles.drivers')
                ->with('message', 'Registro não encontrado!');
        }

        $columns = [
            'is_active' => $type
        ];

        $user->update($columns);

        return redirect()
            ->route('vehicles.drivers')
            ->with('message', 'Alterado com sucesso!');
    }

    public function driver_reset_password($driver_id)
    {
        if (!$user = User::where('id', $driver_id)->first()) {
            return redirect()
                ->route('vehicles.drivers')
                ->with('message', 'Registro não encontrado!');
        }

        $columns = [
            'password' => Hash::make('cena1234'),
            'password_verified' => 'N'
        ];

        $user->update($columns);

        return redirect()
            ->route('vehicles.drivers')
            ->with('message', 'Senha alterada com sucesso!');
    }

    public function drivers_show($driver_id)
    {
        if (!$user = User::where('id', $driver_id)->first()) {
            return redirect()
                ->route('vehicles.drivers')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.vehicles.vehicles.drivers.show', [
            'user' => $user
        ]);
    }

    public function drivers_update(Request $request, $driver_id)
    {
        if (!$user = User::where('id', $driver_id)->first()) {
            return redirect()
                ->route('vehicles.drivers')
                ->with('message', 'Registro não encontrado!');
        }

        $columns = $request->all();

        $user->update($columns);

        return redirect()
            ->route('vehicles.drivers')
            ->with('message', 'Alterado com sucesso!');
    }
}
