<?php

namespace App\Http\Controllers\Painel\Obras;

use App\Models\Pasta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentosResource;
use App\Models\Documento;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PastaController extends Controller
{
    protected $repository;

    public function __construct(Pasta $pasta)
    {
        $this->middleware('auth');

        $this->repository = $pasta;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pasta = $this->repository->whereNull('folder_childer')->toSql();

        return view('admin.pages.settings.index', []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.teste.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $columns = $request->except('_token');

        $idPastaPai = $request->input('folder_childer') ?? false;

        if ($idPastaPai) {
            $pastaPai    = $this->repository->where('uuid', $idPastaPai)->first();
        }

        if (isset($pastaPai)) {
            $url = $pastaPai->url;
            $idType = $pastaPai->type_id ?? null;
            $type = $pastaPai->type ?? null;
        } else {
            $url = '00tR9vps6D';
        }
        $idType = $idType ?? null;
        $type = $type ?? null;
        if ($columns['name'] != '') {
            $columns['url'] = $url;
            $columns['type_id'] = $idType;
            $columns['type'] = $type;
            $folder =  $this->repository->create($columns);
            Storage::makeDirectory($url . '/' . $folder->uuid);
        }
        return redirect()
            ->back()
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\teste  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$pasta = $this->repository->where('uuid', $id)->first()) {
            return redirect()
                ->route('obras.index')
                ->with('message', 'Registro não encontrado!');
        }

        $pastasFilhas = $this->repository->where('folder_childer', $id)->withCount('documentos')->orderBy('name', 'ASC')->get();

        $pastaPai    = $this->repository->where('uuid', $pasta->folder_childer)->where('id', '<>', $pasta->id)->first();

        $documentos = Documento::where('folder', $pasta->uuid)->get();

        return view('pages.painel.obras.arquivos.folders.show', [
            'pasta' => $pasta,
            'pastasFilhas' => $pastasFilhas,
            'pastaPai' => $pastaPai,
            'documentos' => DocumentosResource::collection($documentos)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\teste  $pasta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.teste.create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\teste  $pasta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $columns = $request->all();

        if (!$pasta = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('testes')
                ->with('message', 'Registro não encontrado!');
        }

        $pasta->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\teste  $pasta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$pasta = $this->repository->find($id)) {
            return redirect()
                ->route('testes')
                ->with('message', 'Registro não encontrado!');
        }

        $pasta->delete();

        return redirect()
            ->back()
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

        $pasta = $this->repository
            ->where(function ($query) use ($request) {
                if ($request->filter) {
                    $query->where('name', $request->filter);
                    $query->orWhere('description', 'LIKE', "%{$request->filter}%");
                }
            })
            ->paginate();

        return view('pages.teste.index', compact('teste', 'filters'));
    }
}
