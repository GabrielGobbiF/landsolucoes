<?php


namespace App\Http\Controllers\Painel\Obras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateDepartment;
use App\Http\Requests\StoreUpdateService;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $repository;

    public function __construct(Service $services)
    {
        $this->repository = $services;

        //$this->middleware(['can:view-services']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = $this->repository->get();

        return view('pages.painel.obras.services.index', [
            'services' => $services
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.painel.obras.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateService $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('services.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teste  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$service = $this->repository->where(function ($query) use ($id) {
            $query->where('id', $id);
            $query->orWhere('slug', $id);
        })->first()) {
            return redirect()
                ->route('services.index')
                ->with('error', 'Registro não encontrado!');
        }

        return view('pages.painel.obras.services.show', [
            'service' => $service
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateService $request, $id)
    {
        $columns = $request->all();

        if (!$service = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('services.index')
                ->with('error', 'Registro não encontrado!');
        }

        $service->update($columns);

        return redirect()
            ->route('services.show', $service->id)
            ->with('message', 'Atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teste  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$service = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('services.index')
                ->with('error', 'Registro não encontrado!');
        }

        $service->delete();

        return redirect()
            ->route('services.index')
            ->with('message', 'Deletado com sucesso!');
    }
}
