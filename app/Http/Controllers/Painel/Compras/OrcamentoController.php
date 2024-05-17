<?php

namespace App\Http\Controllers\Painel\Compras;

use App\Http\Controllers\Controller;
use App\Models\Compras\Category;
use App\Models\Compras\Fornecedor;
use App\Models\Compras\Produto;
use App\Models\Etapa;
use App\Models\Obra;
use App\Models\Compras\Orcamento;
use App\Models\Compras\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrcamentoController extends Controller
{
    protected $repository;

    public function __construct(Orcamento $orcamento)
    {
        $this->repository = $orcamento;

        //$this->middleware(['can:view-orcamentos']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obras = Obra::get();

        $categorias = Category::all();

        return view('pages.painel.compras.orcamento.index', [
            'obras' => $obras,
            'categorias' => $categorias
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categoria = $request->input('categoria') ?? null;

        $fornecedores = Fornecedor::whereHas('atuacao', static function ($query) use ($categoria) {
            if ($categoria) {
                return $query->where('name', '=', $categoria);
            }
        })->get();

        $itens = Orcamento::where('categoria', $categoria)->with('variables')->get();

        $unidades = $itens->groupBy('unidade');

        $categorias = Category::all();

        return view('pages.painel.compras.orcamento.create', [
            'categoria' => $categoria,
            'fornecedores' => $fornecedores,
            'itens' => $itens,
            'unidades' => $unidades,
            'categorias' => $categorias
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $columns = $request->only(['obra_id', 'categoria']);

        $orcamento = $this->repository->create($columns);

        return redirect()
            ->route('orcamento.show', [$orcamento->id, 'categoria' => $columns['categoria']])
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Orcamentoes  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (!$orcamento = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('orcamentos.index')
                ->with('message', 'Registro não encontrado!');
        }

        $categoria = $request->input('categoria') ?? null;

        $fornecedores = Fornecedor::whereHas('atuacao', static function ($query) use ($categoria) {
            if ($categoria) {
                return $query->where('name', '=', $categoria);
            }
        })->get();


        $obra = $orcamento->obra()->first();
        $itens = $obra->compras()->with('variables')->with('etapa')->get();

        //$itens = Produto::where('categoria', $categoria)->with('variables')->get();
        $unidades = $itens->groupBy('unidade');

        $categorias = Category::all();

        #dd($fornecedores);

        return view('pages.painel.compras.orcamento.show', [
            'fornecedores' => $fornecedores,
            'itens' => $itens ?? [],
            'unidades' => $unidades ?? [],
            'orcamento' => $orcamento,
            'categorias' => $categorias
        ])->with('categoria', $categoria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $columns = $request->all();

        if (!$orcamento = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('orcamentos.index')
                ->with('message', 'Registro não encontrado!');
        }

        $orcamento->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orcamentoes  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$client = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('orcamentos.index')
                ->with('message', 'Registro não encontrado!');
        }

        $client->delete();

        return redirect()
            ->route('orcamentos.index')
            ->with('message', 'Excluido com sucesso!');
    }
}
