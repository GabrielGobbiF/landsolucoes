<?php

namespace App\Http\Controllers\Painel\Compras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProdutoes;
use App\Models\Compras\Atuacao;
use App\Models\Compras\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProdutosController extends Controller
{
    protected $repository;

    public function __construct(Produto $produto)
    {
        $this->repository = $produto;

        //$this->middleware(['can:view-produtos']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.painel.compras.produtos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.painel.compras.produtos.create', []);
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

        $produto = $this->repository->create($columns);

        return redirect()
            ->route('produtos.index', ['create'])
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produtoes  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$produto = $this->repository->where('id', $id)->first()) {

            return redirect()
                ->route('produtos.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.compras.produtos.show', [
            'produto' => $produto,

        ]);
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

        if (!$produto = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('produtos.index')
                ->with('message', 'Registro não encontrado!');
        }

        $produto->update($columns);

        if (isset($columns['variable'])) {
            for ($q = 0; $q < count($columns['variable']['name']); $q++) {
                if ($columns['variable']['name'][$q] != '') {

                    $columnsStore = [
                        'name' => $columns['variable']['name'][$q],
                        'price' => $columns['variable']['price'][$q],
                    ];

                    $id = isset($columns['variable']['id'][$q]) ? $columns['variable']['id'][$q] :  null;
                    $produto->variables()->updateOrCreate(
                        ['id' =>  $id],
                        $columnsStore
                    );
                }

                #$fornecedor->contatos()->create($columnsStore);
            }
        }

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produtoes  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$client = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('produtos.index')
                ->with('message', 'Registro não encontrado!');
        }

        $client->delete();

        return redirect()
            ->route('produtos.index')
            ->with('message', 'Excluido com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fornecedores  $uuid
     * @return \Illuminate\Http\Response
     */
    public function variable_destroy($produtoId, $variable)
    {
        if (!$produto = $this->repository->where('id', $produtoId)->first()) {
            return redirect()
                ->route('produtos.index')
                ->with('message', 'Registro não encontrado!');
        }

        if (!$variavel = $produto->variables()->where('id', $variable)->first()) {
            return redirect()
                ->route('produtos.index')
                ->with('message', 'Registro (Variavel) não encontrado!');
        }

        $variavel->delete();

        return redirect()
            ->route('produtos.show', $produtoId)
            ->with('message', 'Variabel Excluido com sucesso!');
    }
}
