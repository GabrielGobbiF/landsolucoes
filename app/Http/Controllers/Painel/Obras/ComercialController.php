<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateComercial;
use App\Http\Resources\ObraFinanceiroResource;
use App\Models\Addres;
use App\Models\Client;
use App\Models\Concessionaria;
use App\Models\Obra;
use App\Models\ObraEtapa;
use App\Models\Service;
use App\Models\User;
use App\Models\Viabilization;
use App\Notifications\ObraCreatedNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.painel.obras.comercial.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
                'quantidade' => $etapa->quantidade,
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
     * @param  \App\Models\Comercial  $id
     * @return \Illuminate\Http\Response
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

        return view('pages.painel.obras.comercial.show', [
            'comercial' => $comercial,
            'etapasCompras' => $etapasCompras,
            'financeiro' => $financeiro,
            'etapasAll' => $etapasAll,
            'totalFaturar' => $totalFaturar ??  0,
            'etapasFinanceiro' => $etapasFinanceiro,
            'totalFaturado' => $totalFaturado ? number_format($totalFaturado, 2, ',', ',') : 0
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
     * @param  \App\Models\Test  $id
     * @return \Illuminate\Http\Response
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

        return redirect()
            ->route('obras.show', $comercial->id)
            ->with('message', 'Sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $id
     * @return \Illuminate\Http\Response
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comercial  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        if (!$client = $this->repository->where('uuid', $uuid)->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        $client->delete();

        return redirect()
            ->route('comercial.index')
            ->with('message', 'Excluir com sucesso!');
    }
}
