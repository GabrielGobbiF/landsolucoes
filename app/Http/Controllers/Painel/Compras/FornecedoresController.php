<?php

namespace App\Http\Controllers\Painel\Compras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateFornecedores;
use App\Models\Compras\Atuacao;
use App\Models\Compras\Category;
use App\Models\Compras\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FornecedoresController extends Controller
{
    protected $repository;

    public function __construct(Fornecedor $fornecedor)
    {
        $this->repository = $fornecedor;

        //$this->middleware(['can:view-fornecedores']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.painel.compras.fornecedores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $atuacao = Category::all();

        return view('pages.painel.compras.fornecedores.create', [
            'atuacao' => $atuacao
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
        $columns = $request->all();

        $fornecedor = $this->repository->create($columns);

        if ($columns['atuacao']) {
            $fornecedor->atuacao()->sync($columns['atuacao']);
        }

        return redirect()
            ->route('fornecedor.show', $fornecedor->id)
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fornecedores  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$fornecedor = $this->repository->where('id', $id)->first()) {

            return redirect()
                ->route('fornecedor.index')
                ->with('message', 'Registro não encontrado!');
        }

        $fornecedorAtuacao = $fornecedor->atuacao()->get(['name']) ?? [];

        foreach ($fornecedorAtuacao as $fornA) {
            $fornecedorAtuacaoa[] = $fornA['name'];
        }

        $atuacaoAll = Category::all()->toArray();

        $contatos = $fornecedor->contatos()->get();

        return view('pages.painel.compras.fornecedores.show', [
            'fornecedor' => $fornecedor,
            'contatos' => $contatos,
            'fornecedorAtuacaoa' => $fornecedorAtuacaoa ?? [],
            'atuacaoAll' => $atuacaoAll,
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

        if (!$fornecedor = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('fornecedor.index')
                ->with('message', 'Registro não encontrado!');
        }

        $fornecedor->update($columns);

        if ($columns['atuacao']) {
            $fornecedor->atuacao()->sync($columns['atuacao']);
        }

        if (isset($columns['contato'])) {
            for ($q = 0; $q < count($columns['contato']['nome']); $q++) {
                if ($columns['contato']['nome'][$q] != '') {

                    $columnsStore = [
                        'nome' => $columns['contato']['nome'][$q],
                        'email' => $columns['contato']['email'][$q],
                        'telefone' => $columns['contato']['telefone'][$q],
                        'celular' => $columns['contato']['celular'][$q],
                    ];

                    $id = isset($columns['contato']['id'][$q]) ? $columns['contato']['id'][$q] :  null;
                    $fornecedor->contatos()->updateOrCreate(
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
     * @param  \App\Models\Fornecedores  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$client = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('fornecedor.index')
                ->with('message', 'Registro não encontrado!');
        }

        $client->delete();

        return redirect()
            ->route('fornecedor.index')
            ->with('message', 'Excluido com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fornecedores  $uuid
     * @return \Illuminate\Http\Response
     */
    public function contato_destroy($fornecedorId, $contatoId)
    {
        if (!$fornecedor = $this->repository->where('id', $fornecedorId)->first()) {
            return redirect()
                ->route('fornecedor.index')
                ->with('message', 'Registro não encontrado!');
        }

        if (!$contato = $fornecedor->contatos()->where('id', $contatoId)->first()) {
            return redirect()
                ->route('fornecedor.index')
                ->with('message', 'Registro (Contato) não encontrado!');
        }

        $contato->delete();

        return redirect()
            ->route('fornecedor.show', $fornecedorId)
            ->with('message', 'Contato Excluido com sucesso!');
    }
}
