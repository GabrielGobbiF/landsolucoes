<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comercial\UpdateData;
use App\Http\Requests\StoreUpdateComercial;
use App\Http\Resources\ObraFinanceiroResource;
use App\Models\Addres;
use App\Models\Client;
use App\Models\Concessionaria;
use App\Models\Obra;
use App\Models\ObraEtapa;
use App\Models\Pasta;
use App\Models\Service;
use App\Models\User;
use App\Models\Viabilization;
use App\Notifications\ObraCreatedNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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
     */
    public function index()
    {
        $clients = Client::whereHas('obras', function ($query) {
            // $query->where('obras.status', 'aprovada');
        })->get(['id', 'username']);

        $concessionarias = Concessionaria::whereHas('obras')->get(['id', 'name']);

        return view('pages.painel.obras.comercial.index', [
            'clients' => $clients,
            'concessionarias' => $concessionarias,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $clients = Client::all();
        $services = Service::all();
        $concessionarias = Concessionaria::all();

        //$users = User::whereDoesntHave('roles', static function ($query) {
        //    return $query->where('slug', '<>', 'vehicles');
        //})->get();

        return view('pages.painel.obras.comercial.create', [
            'clients' => $clients,
            'services' => $services,
            'concessionarias' => $concessionarias,
        ]);
    }

    public function edit($comercialId)
    {
        if (!$comercial = $this->repository->where('id', $comercialId)->with('service')->with('concessionaria')->with('viabilizacao')->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        $clients = Client::all();
        $services = Service::all();
        $concessionarias = Concessionaria::all();

        return view('pages.painel.obras.comercial.edit', [
            'comercial' => $comercial,
            'clients' => $clients,
            'services' => $services,
            'concessionarias' => $concessionarias,
        ]);
    }

    public function updateData(UpdateData $request, $comercialId)
    {
        if (!$comercial = $this->repository->where('id', $comercialId)->with('service')->with('concessionaria')->with('viabilizacao')->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        throw_if(
            $comercial->status->value != 'elaboração',
            ValidationException::withMessages(['message' => 'Só é possivel alterar um comercial com status em Elaboração'])
        );

        $comercial->etapas()->delete();
        $concessionaria_id = $request->input('concessionaria_id');
        $service_id = $request->input('service_id');
        if (!$concessionaria = Concessionaria::where('id', $concessionaria_id)->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('error', 'Registro Concessionaria não encontrado!');
        }
        $etapas = $concessionaria->etapas($service_id)->get();
        $this->storeEtapasComercial($etapas, $comercial->id);

        $comercial->update($request->validated());

        return redirect()
            ->route('comercial.show', $comercial->id)
            ->with('message', 'Atualizado!');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreUpdateComercial $request)
    {
        $concessionaria_id = $request->input('concessionaria_id');
        $service_id = $request->input('service_id');

        if (!$concessionaria = Concessionaria::where('id', $concessionaria_id)->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('error', 'Registro Concessionaria não encontrado!');
        }

        $address = new Addres();
        $viabilizacao = new Viabilization();

        $columnsViabilizacao = $request->only('viabilizacao');
        $columns = $request->except('viabilizacao');

        $columns['address_id'] = $address->create()->id;
        $columns['viabilization_id'] = $viabilizacao->create($columnsViabilizacao['viabilizacao'])->id;

        $comercial = $this->repository->create($columns);

        $etapas = $concessionaria->etapas($service_id)->get();

        $this->storeEtapasComercial($etapas, $comercial->id);

        $url = '00tR9vps6D';
        $folder =  Pasta::create([
            'name' => $comercial->razao_social,
            'type' => 'obras',
            'url' => '00tR9vps6D',
            'type_id' => $comercial->id
        ]);
        Storage::makeDirectory($url . '/' . $folder->uuid);

        return redirect()
            ->route('comercial.show', $comercial->id)
            ->with('message', 'Criado com sucesso, Atualize o Financeiro');
    }

    public function storeEtapasComercial(Object $etapas, int $comercial_id)
    {
        foreach ($etapas as $etapa) {
            $obraEtapa = ObraEtapa::create([
                'id_obra' => $comercial_id,
                'id_etapa' => $etapa->id,
                'tipo_id' => $etapa->tipo_id,
                'nome' => $etapa->name,
                'ordem' => $etapa->pivot->order,
                'preco' => $etapa->preco,
                'unidade' => $etapa->unidade,
                'quantidade' => $etapa->quantidade ?? 0,
            ])->id;

            $variables = $etapa->variables()->get();

            if (count($variables) > 0) {
                foreach ($variables as $variable) {
                    DB::insert(
                        'insert into obras_etapas_variables (etapa_id, obra_id, nome, preco) values (?,?,?,?)',
                        [
                            $obraEtapa,
                            $comercial_id,
                            $variable->name,
                            $variable->price,
                        ]
                    );
                }
            }
        }
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Obra  $id
     */
    public function show($id)
    {
        if (!$comercial = $this->repository->where('id', $id)->with('service')->with('concessionaria')->with('viabilizacao')->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        $etapasFinanceiro = $comercial->etapas()->whereDoesntHave('financeiro')->get();
        $etapasAll = $comercial->etapas()->with('variables')->get();
        $etapasCompras = $etapasAll->where('tipo_id', '4');
        $financeiro = $comercial->financeiro()->first();
        $financeiro = $this->financeiroResource($financeiro);
        $financeiro = is_array($financeiro) ? false : $financeiro->toArray($financeiro);

        if ($financeiro) {
            $etapasFinaneiroSoma = $comercial->etapas_financeiro()->sum('valor_receber') ?? 0;
            $totalFaturar = $financeiro['valor_negociado'] - $etapasFinaneiroSoma;
            $totalFaturado = $etapasFinaneiroSoma;
        }

        $activities = $comercial->activities()->get();

        #dd($activities);

        return view('pages.painel.obras.comercial.show', [
            'comercial' => $comercial,
            'etapasCompras' => $etapasCompras,
            'financeiro' => $financeiro,
            'etapasAll' => $etapasAll,
            'totalFaturar' => $totalFaturar ??  0,
            'etapasFinanceiro' => $etapasFinanceiro,
            'activities' => $activities,
            'totalFaturado' => isset($totalFaturado) ? number_format($totalFaturado, 2, ',', ',') : 0
        ]);
    }

    public function financeiroResource($financeiro)
    {
        return !empty($financeiro) ? new ObraFinanceiroResource($financeiro) : [];
    }

    public function updateOrCreateFinanceiro(Request $request, $comercial_id)
    {
        $columns = $request->except('variable', 'etapa', '_token');

        if (!$comercial = $this->repository->where('id', $comercial_id)->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        /**
         * financeiro
         */
        $financeiro = $comercial->financeiro()->first();
        empty($financeiro) ? $comercial->financeiro()->create($columns) : $financeiro->update($columns);

        /**
         * Variaveis
         */
        $etapas = $request->input('etapa');
        if (!is_null($etapas)) {
            $comercialEtapas = $comercial->etapas()->where('tipo_id', '4')->get();

            foreach ($etapas as $obraEtapaId => $value) {
                $etp = $comercialEtapas->where('id', $obraEtapaId)->first();
                $etp->update(['quantidade' => $value]);
            }
        }

        $variables = $request->input('variable');
        if (!is_null($variables)) {
            foreach ($variables as $obraVariablesId => $value) {
                DB::update('update obras_etapas_variables set quantidade = ? where id = ?', [
                    $value,
                    $obraVariablesId,
                ]);
            }
        }

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(StoreUpdateComercial $request, $id)
    {
        $columnsViabilizacao = $request->only('viabilizacao');

        $columns = $request->except('viabilizacao');

        if (!$comercial = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        $comercial->update($columns);

        $columnsViabilizacao['viabilizacao']['elaboracao'] = !isset($columnsViabilizacao['viabilizacao']['elaboracao']) ? NULL : $columnsViabilizacao['viabilizacao']['elaboracao'];
        $columnsViabilizacao['viabilizacao']['qualidade'] = !isset($columnsViabilizacao['viabilizacao']['qualidade']) ? NULL : $columnsViabilizacao['viabilizacao']['qualidade'];
        $columnsViabilizacao['viabilizacao']['ambiental'] = !isset($columnsViabilizacao['viabilizacao']['ambiental']) ? NULL : $columnsViabilizacao['viabilizacao']['ambiental'];
        $columnsViabilizacao['viabilizacao']['seguranca_via'] = !isset($columnsViabilizacao['viabilizacao']['seguranca_via']) ? NULL : $columnsViabilizacao['viabilizacao']['seguranca_via'];

        $comercial->viabilizacao()->update($columnsViabilizacao['viabilizacao']);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    public function approved(Request $request)
    {
        $comercial_id = $request->input('comercial_id');

        $users = $request->input('users');

        if (!$comercial = $this->repository->where('id', $comercial_id)->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        $comercial->update(['status' => 'aprovada']);

        if (!empty($users)) {
            foreach ($users as $users => $value) {
                $userNotify = User::where('id', $value)->first();
                $userNotify->notify(new ObraCreatedNotification($comercial));
            }
        }

        //$url = '00tR9vps6D';
        //$folder =  Pasta::create([
        //    'name' => $comercial->razao_social,
        //    'type' => 'obras',
        //    'url' => '00tR9vps6D',
        //    'type_id' => $comercial->id
        //]);
        //Storage::makeDirectory($url . '/' . $folder->uuid);

        return redirect()
            ->route('obras.show', $comercial->id)
            ->with('message', 'Sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');

        if (!$comercial = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        if ($status == 'aprovada' && $comercial->financeiro()->first() == null) {
            return response(['status' => false, 'message' => 'primeiro atualize o financiero da obra'], 404);
        }

        return response($comercial->update(['status' => $status]), 200);
    }


    public function duplicate(Request $request, $id)
    {
        $name = $request->input('name', null);

        if (!$comercial = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        //copy attributes from original model
        $newRecord = $comercial->replicate();

        // Reset any fields needed to connect to another parent, etc
        $newRecord->id = Obra::orderBy('id', 'DESC')->first()->id + 1;
        //save model before you recreate relations (so it has an id)
        $newRecord->push();

        $newRecord->save();
        $newRecord->update();
        //reset relations on EXISTING MODEL (this way you can control which ones will be loaded
        $comercial->relations = [];
        //load relations on EXISTING MODEL
        $comercial->load('financeiro', 'etapas', 'etapas_financeiro');
        //re-sync the child relationships
        $relations = $comercial->getRelations();

        foreach ($relations as $relation) {
            foreach ($relation as $relationRecord) {

                if (!is_bool($relationRecord)) {
                    $newRelationship = $relationRecord->replicate();


                    $newRelationship->id_obra = $newRecord->id;
                    $newRelationship->push();
                }
            }
        }

        $newRecord->razao_social = $name ?? $comercial->razao_social . '_copy';
        $newRecord->save();
        $newRecord->update();

        return redirect()
            ->route('comercial.show', $newRecord->id)
            ->with('message', 'Sucesso');
    }

}
