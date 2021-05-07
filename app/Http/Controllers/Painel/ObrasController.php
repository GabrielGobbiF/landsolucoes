<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Obra;

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
        #$obra = $this->repository->all();

        return view('pages.painel.obras.documentos.index', []);
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

        $obra = $this->repository->create($columns);

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
        if (!$obra = $this->repository->find($id)) {
            return redirect()
                ->route('obras')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.obras.show', [
            'obra' => $obra,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\obra  $obra
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.obra.create');
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
}
