<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Exports\ObraEtapasExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Managers\ApiBrasil\ApiBrasil;
use App\Models\Client;
use App\Models\Concessionaria;
use App\Models\Department;
use App\Models\Obra;
use App\Models\ObraEtapa;
use App\Models\Pasta;
use App\Models\RSDE\Rdse;
use App\Models\Service;
use App\Models\Tipo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ObrasController extends Controller
{
    protected $repository;

    public function __construct(Obra $obra)
    {
        $this->middleware('auth');

        $this->repository = $obra;
    }

    public function dashboard(Request $request)
    {
        $hoje = Carbon::now();
        $semana = $hoje->copy()->addDays(7);

        // 1. Contagens consolidadas de obras
        $obrasCounts = Obra::Active()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('COUNT(CASE WHEN gestor_id = ? THEN 1 END) as user_total', [auth()->id()])
            ->selectRaw('COUNT(CASE WHEN gestor_id IS NULL THEN 1 END) as null_gestor')
            ->first();

        $countObras = $obrasCounts->total;
        $countObrasByUser = $obrasCounts->user_total;
        $countObrasNotUser = $obrasCounts->null_gestor;

        // 2. Contagens combinadas de etapas atrasadas
        $atrasadasCounts = Obra::Active()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('COUNT(CASE WHEN gestor_id = ? THEN 1 END) as user_total', [auth()->id()])
            ->whereHas('etapas', function ($query) use ($hoje) {

                $query->where('check', 'EM')->where('data_prazo_total', '<', $hoje)
                    ->whereNotNull(['data_abertura', 'prazo_atendimento'])
                ;
            })
            ->first();

        $obrasComEtapasAtrasadas = $atrasadasCounts->total;
        $obrasComEtapasAtrasadasByUser = $atrasadasCounts->user_total;

        // 3. Consulta unificada de etapas
        $etapasQuery = ObraEtapa::ObraActive()
            ->where('check', 'EM')
            ->whereNotNull(['data_abertura', 'prazo_atendimento'])
            ->with('obra') // Eager loading para evitar N+1
            ->where(function ($query) use ($hoje, $semana) {
                $query->where('data_prazo_total', '<', $hoje)
                    ->orWhereDate('data_prazo_total', $hoje->toDateString())
                    ->orWhereBetween('data_prazo_total', [$hoje, $semana]);
            })
            ->orderBy('data_prazo_total')
            #->limit(100)
            ->get();

        // Filtrar resultados na memória
        $etapasAtrasadas = $etapasQuery->toBase()->filter(function ($etapa) use ($hoje) {
            $data = date_format(Carbon::parse(str_replace('/', '-', $etapa->data_prazo_total)), 'Y-m-d');
            return  $data < $hoje;
        });

        $etapasVencemHoje = $etapasQuery->toBase()->filter(function ($etapa) use ($hoje) {
            $data = date_format(Carbon::parse(str_replace('/', '-', $etapa->data_prazo_total)), 'Y-m-d');
            return $data >= $hoje->startOfDay() && $data <= $hoje->endOfDay();
        });

        $etapasPrestesAVencer = $etapasQuery->toBase()->filter(function ($etapa) use ($hoje, $semana) {
            $data = date_format(Carbon::parse(str_replace('/', '-', $etapa->data_prazo_total)), 'Y-m-d');
            return $data >= $hoje && $data <= $semana;
        });

        // 4. Consulta otimizada de gestores
        $gestores = User::GestorObras()
            ->withCount([
                'obras as total' => fn($q) => $q->Active(),
                'obras as nao_atualizadas' => fn($q) => $q->whereHas('etapas', fn($sq) =>
                $sq->where('check', 'EM')->whereNull('data_prazo_total')->orWhereNull('data_abertura')),
                'obras as sem_pendencias' => function ($query) {
                    $query->whereHas('etapas', function ($q) {
                        $q->whereNotNull('data_prazo_total')
                            ->whereNotNull('data_abertura')
                            ->where('data_prazo_total', '>', Carbon::now()->addDays(3));
                    });
                }
            ])
            ->addSelect([
                'etapas_a_vencer' => Obra::Active()->selectRaw('COUNT(DISTINCT obras.id)')
                    ->whereColumn('gestor_id', 'users.id')
                    ->whereHas('etapas', fn($q) =>
                    $q->where('check', 'EM')->whereBetween('data_prazo_total', [now(), now()->addDays(3)])
                        ->toBase()),

                'etapas_vencidas' => Obra::Active()->selectRaw('COUNT(DISTINCT obras.id)')
                    ->whereColumn('gestor_id', 'users.id')
                    ->whereHas('etapas', fn($q) =>
                    $q->where('check', 'EM')->where('data_prazo_total', '<', now()))
                    ->toBase()
            ])
            ->get();

        // 5. (Opcional) Adicionar cache para dados estáticos
        $expiration = now()->addHours(6);
        $gestores = Cache::remember('gestores_stats', $expiration, fn() => $gestores);

        // Preparar dados para gráficos
        $labels = $gestores->pluck('name')->toArray();
        $nao_atualizadas = $gestores->pluck('nao_atualizadas')->toArray();
        $etapas_a_vencer = $gestores->pluck('etapas_a_vencer')->toArray();
        $etapas_vencidas = $gestores->pluck('etapas_vencidas')->toArray();
        $sem_pendencias = $gestores->pluck('sem_pendencias')->toArray();

        return view('pages.painel.obras.dashboard',  [
            'countObras' => $countObras,
            'countObrasByUser' => $countObrasByUser,
            'countObrasNotUser' => $countObrasNotUser,
            'obrasComEtapasAtrasadas' => $obrasComEtapasAtrasadas,
            'obrasComEtapasAtrasadasByUser' => $obrasComEtapasAtrasadasByUser,

            'etapasAtrasadas' => $etapasAtrasadas,
            'etapasVencemHoje' => $etapasVencemHoje,
            'etapasPrestesAVencer' => $etapasPrestesAVencer,


            'labels' => $labels,
            'nao_atualizadas' => $nao_atualizadas,
            'etapas_a_vencer' => $etapas_a_vencer,
            'etapas_vencidas' => $etapas_vencidas,
            'sem_pendencias' => $sem_pendencias,

            #'countObras' => $countObras,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|
     */
    public function index()
    {
        #dd(app(ApiBrasil::class)->send('11971590068', ''));

        $userGestorObras = User::gestorObras()->get();

        $clients = Client::whereHas('obras', function ($query) {
            $query->where('obras.status', 'aprovada');
        })->get(['id', 'username']);

        $concessionarias = Concessionaria::whereHas('obras')->get(['id', 'name']);
        $services = Service::whereHas('obras')->get(['id', 'name']);

        return view('pages.painel.obras.obras.index', [
            'clients' => $clients,
            'concessionarias' => $concessionarias,
            'services' => $services,
            'userGestorObras' => $userGestorObras
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|
     */
    public function create()
    {
        return view('pages.obra.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('obras.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\obra  $id
     */
    public function show($id)
    {
        if (!$obra = $this->repository->with('address')->with('client')->find($id)) {
            return redirect()
                ->route('obras.index')
                ->with('message', 'Registro não encontrado!');
        }

        $userAll = User::all();
        $tipos  = Tipo::all();
        $address  = $obra->address;

        $clientsDepartaments = $obra->client->departments()->get();
        $department_id = $obra->department_id;
        $obraDepartamentoCliente = null;
        if ($department_id) {
            $obraDepartamentoCliente = $clientsDepartaments->where('id', $department_id)->first();
        }

        $pastas = Pasta::where('type_id', $obra->id)->where('type', 'obras')->get();

        $pastaPadrao = file_get_contents(asset('storage/00tR9vps6D/jsons/pastas.json'));
        $pastaPadrao = json_decode($pastaPadrao, true);

        for ($i = 0; $i < count($pastaPadrao); $i++) {
            foreach ($pastas as $p) {
                if (isset($pastaPadrao[$i]) && minusculo($pastaPadrao[$i]['nome_pasta']) == minusculo($p->name)) {
                    unset($pastaPadrao[$i]);
                }
            }
        }

        return view('pages.painel.obras.obras.show', [
            'obra' => $obra,
            'clientsDepartaments' => $clientsDepartaments,
            'obraDepartamentoCliente' => $obraDepartamentoCliente,
            'tipos' => $tipos,
            'address' => $address,
            'pastas' => $pastas,
            'pastaPadrao' => $pastaPadrao,
            'userAll' => $userAll
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\obra  $obra
     * @return \Illuminate\Contracts\View\View|
     */
    public function update(Request $request, $id)
    {
        $columns = $request->all();

        if (!$obra = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('obras')
                ->with('message', 'Registro não encontrado!');
        }

        if (isset($columns['address'])) {
            $addres = $obra->address()->updateOrCreate(
                ['id' => $obra->address_id],
                $columns['address']
            );

            $columns['address_id'] = $addres->id;
        }

        $obra->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\obra  $obra
     * @return \Illuminate\Contracts\View\View|
     */
    public function destroy($id)
    {
        if (!$obra = $this->repository->find($id)) {
            return redirect()
                ->route('obras.index')
                ->with('message', 'Registro não encontrado!');
        }

        $obra->delete();

        return redirect()
            ->route('obras.index')
            ->with('message', 'Deletado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\obra  $obra
     * @return \Illuminate\Contracts\View\View|
     */
    public function concluir($id)
    {
        if (!$obra = $this->repository->find($id)) {
            return redirect()
                ->route('obras.index')
                ->with('message', 'Registro não encontrado!');
        }

        $obra->status = 'concluida';
        $obra->update();
        $obra->save();

        return redirect()
            ->route('obras.index')
            ->with('message', 'Concluida com sucesso!');
    }

    public function favorite(Request $request, $obraId)
    {
        if (!$obra = $this->repository->find($obraId)) {
            return redirect()
                ->route('obras.index')
                ->with('message', 'Registro não encontrado!');
        }

        auth()->user()->obrasFavorites()->attach($obraId);

        return redirect()
            ->route('obras.show', $obraId)
            ->with('message', 'Favoritado!');
    }

    public function unfavorite(Request $request, $obraId)
    {
        if (!$obra = $this->repository->find($obraId)) {
            return redirect()
                ->route('obras.index')
                ->with('message', 'Registro não encontrado!');
        }

        auth()->user()->obrasFavorites()->detach($obraId);

        return redirect()
            ->route('obras.show', $obraId)
            ->with('message', 'Des Favoritado!');
    }

    /**
     * Search results
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\View\View|
     */
    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $obra = $this->repository
            ->where(function ($query) use ($request) {
                if ($request->filter) {
                    $query->where('name', $request->filter);
                    $query->orWhere('description', 'LIKE', "%{$request->filter}%");
                }
            })
            ->paginate();

        return view('pages.obra.index', compact('obra', 'filters'));
    }

    public function obrasVencidas()
    {
        $obrasEtapasVencidas = [];
        $obras = Obra::with('etapas')->where('status', 'aprovada')->get();

        foreach ($obras as $obra) {
            $etapas = $obra->etapas;

            foreach ($etapas as $etapa) {
                if ($etapa->check != 'C' && ($etapa->data_abertura != '' || $etapa->data_iniciada != '') && ($etapa->prazo_atendimento != '' || $etapa->tempo_atividade)) {
                    $in = $etapa->data_abertura != '' ? $etapa->data_abertura : $etapa->data_iniciada;
                    $out = $etapa->prazo_atendimento != '' ? $etapa->prazo_atendimento : $etapa->tempo_atividade;
                    $prazoTotal = somarData($out, $in);
                    $date = Carbon::parse($prazoTotal);
                    $dateP = Carbon::parse($prazoTotal)->format('Y-m-d');
                    $now = Carbon::now()->format('Y-m-d');
                    if ($now > $date) {
                        $obrasEtapasVencidas[] = [
                            'obra_id' => $obra->id,
                            'etapa_id' => $etapa->id,
                            'obra_name' => $obra->razao_social,
                            'etapa_name' => $etapa->nome,
                        ];
                    }
                }
            }
        }

        return view('pages.painel.obras.obras.obrasEtapasVencidas', [
            'obrasEtapasVencidas' => $obrasEtapasVencidas
        ]);
    }

    public function removeFinance($obraId)
    {
        if (!$obra = $this->repository->find($obraId)) {
            return redirect()
                ->route('obras.index')
                ->with('message', 'Registro não encontrado!');
        }

        $time = empty($obra->remove_finance) ? now() : null;

        $obra->remove_finance = $time;
        $obra->save();

        return redirect()
            ->route('obras.show', $obraId)
            ->with('message', 'Removido do Financeiro!');
    }

    public function urgence(Request $request, $obraId)
    {
        if (!$obra = $this->repository->find($obraId)) {
            return redirect()
                ->route('obras.index')
                ->with('message', 'Registro não encontrado!');
        }

        $obra->obr_urgence = $obra->obr_urgence == 'N' ? 'Y' : 'N';
        $obra->save();

        return redirect()
            ->route('obras.show', $obraId)
            ->with('message', 'Feito!');
    }

    public function linkarRdse(Request $request, $obraId)
    {
        $rdse = $request->input('rdse_id');

        if (!$obra = $this->repository->find($obraId)) {
            return redirect()
                ->route('obras.index')
                ->with('message', 'Registro não encontrado!');
        }

        if (!$rdse = Rdse::where('id', $rdse)->first()) {
            return redirect()
                ->route('rdse.index')
                ->with('message', 'Registro não encontrado!');
        }

        $rdse->obra_id = $obra->id;
        $rdse->save();

        $obra->rdse_id = $rdse->id;
        $obra->save();

        return redirect()
            ->route('obras.show', $obraId)
            ->with('message', '');
    }

    public function exportEtapas(Request $request, $obraId)
    {
        $tipoEtapa = $request->input('tipo_etapa', null);

        if (!$obra = $this->repository->with('etapas')->find($obraId)) {
            return redirect()
                ->route('obras.index')
                ->with('message', 'Registro não encontrado!');
        }

        $etapas = $obra->etapas()->where(function ($query) use ($tipoEtapa) {
            if ($tipoEtapa != null) {
                $query->where('tipo_id', $tipoEtapa);
            }
        })->with('comments')->orderBy('ordem')->get();

        $obraInfo = [
            'id' => $obra->id,
            'nome' => $obra->razao_social,
            'endereco' => $obra->AddressComplete,
            'cliente' => $obra->client->username,
            'assessor' => $obra->service->name
        ];

        return Excel::download(new ObraEtapasExport($etapas, $obraInfo), slug($obra->razao_social, '_') . '_etapas.xlsx');
    }

    public function updatedGestor(Request $request, $obraId)
    {
        if (!$obra = $this->repository->find($obraId)) {
            return redirect()
                ->route('obras.index')
                ->with('message', 'Registro não encontrado!');
        }

        $obra->gestor_id = $request->input('gestor_id');
        $obra->save();

        return redirect()
            ->route('obras.show', $obraId)
            ->with('message', 'Gestor Alterado com sucesso!');
    }
}
