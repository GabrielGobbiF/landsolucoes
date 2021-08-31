<?php

namespace App\Http\Controllers\Painel\Obras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Concessionaria;
use App\Models\Department;
use App\Models\Obra;
use App\Models\Tipo;
use Illuminate\Support\Facades\Hash;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::whereHas('obras', function ($query) {
            $query->where('obras.status', 'aprovada');
        })->get(['id', 'username']);

        $concessionarias = Concessionaria::whereHas('obras')->get(['id', 'name']);

        return view('pages.painel.obras.obras.index', [
            'clients' => $clients,
            'concessionarias' => $concessionarias
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.obra.create');
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

        $this->repository->create($columns);

        return redirect()
            ->route('obra')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\obra  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$obra = $this->repository->with('address')->with('client')->find($id)) {
            return redirect()
                ->route('obras')
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

        return view('pages.painel.obras.obras.show', [
            'obra' => $obra,
            'clientsDepartaments' => $clientsDepartaments,
            'obraDepartamentoCliente' => $obraDepartamentoCliente,
            'tipos' => $tipos,
            'address' => $address
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\obra  $obra
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$obra = $this->repository->find($id)) {
            return redirect()
                ->route('obras')
                ->with('message', 'Registro não encontrado!');
        }

        $obra->delete();

        return redirect()
            ->route('obras')
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $identify
     * @return \Illuminate\Http\Response
     */
    public function address(array $columns, int $identify)
    {
        $columns = $request->all();



        return $address;
    }
}
