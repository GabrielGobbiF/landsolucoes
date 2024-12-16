<?php

namespace App\Http\Controllers\Painel\Obras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Concessionaria;
use App\Models\Department;
use App\Models\Obra;
use App\Models\Pasta;
use App\Models\RSDE\Rdse;
use App\Models\Service;
use App\Models\Tipo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ObrasController extends Controller
{
    protected $repository;

    public function __construct(Obra $obra)
    {
        $this->middleware('auth');

        $this->repository = $obra;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|
     */
    public function index()
    {
        $clients = Client::whereHas('obras', function ($query) {
            $query->where('obras.status', 'aprovada');
        })->get(['id', 'username']);

        $concessionarias = Concessionaria::whereHas('obras')->get(['id', 'name']);
        $services = Service::whereHas('obras')->get(['id', 'name']);

        return view('pages.painel.obras.obras.index', [
            'clients' => $clients,
            'concessionarias' => $concessionarias,
            'services' => $services
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
            'pastaPadrao' => $pastaPadrao
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
}
