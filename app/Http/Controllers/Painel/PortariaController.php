<?php

namespace App\Http\Controllers\Painel;

use App\Models\Portaria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUser;
use App\Models\Role;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PortariaController extends Controller
{
    protected $repository;

    public function __construct(Portaria $portaria)
    {
        $this->middleware('auth');

        $this->repository = $portaria;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portarias = $this->repository->all();

        foreach ($portarias as $portaria) {

            $images = explode(', ', $portaria->files);

            $veiculo = Vehicle::where('id', $portaria->vehicle_id)->first() ?? [];
            $veiculoName = $veiculo->name . ' ' . $veiculo->board;

            $portaria['porteiro'] = User::where('id', $portaria->user_id)->first()->name ?? '';
            $portaria['motorista'] = User::where('id', $portaria->motorista_id)->first()->name ?? '';
            $portaria['veiculo'] = $veiculoName;
            $portaria['data'] = Carbon::parse($portaria->created_at)->format('d/m/Y h:i:s');
            $portaria['images'] = $images;
        }

        return view('pages.painel.vehicles.portaria.index', [
            'portarias' => $portarias
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drivers = User::whereHas('roles', function ($query) {
            return $query->where('slug', 'driver');
        })->orderby('users.name')->get();

        $vehicles = Vehicle::orderby('name')->get();

        return view('pages.painel.vehicles.portaria.register', [
            'drivers' => $drivers,
            'vehicles' => $vehicles
        ]);
    }

    /**
     * Store
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $columns = $request->all();

        $columns['user_id'] = Auth::id();

        $attachmentsSave = [];

        $date = date('d_m_Y_h_i_s');

        $localSaveAttachment = "portaria/veiculos/" . $columns['vehicle_id'] . '/' . $date;

        if ($columns['attachments']) {
            foreach ($columns['attachments'] as $attachment) {
                if ($attachment->isValid()) {
                    $path = Storage::put($localSaveAttachment, $attachment);
                    $attachmentsSave[] = $path;
                }
            }

            $attachments = implode(', ', $attachmentsSave);

            $columns['files'] = $attachments;
        }

        $this->repository->create($columns);

        return redirect()
            ->route('vehicles.portaria.register')
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
}
