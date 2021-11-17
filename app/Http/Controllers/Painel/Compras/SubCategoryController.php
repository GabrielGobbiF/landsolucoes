<?php

namespace App\Http\Controllers\Painel\Compras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategory;
use App\Http\Requests\StoreUpdateSubCategory;
use App\Models\Compras\Atuacao;
use App\Models\Compras\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SubCategoryController extends Controller
{
    protected $repository;

    public function __construct(SubCategory $subCategories)
    {
        $this->repository = $subCategories;

        //$this->middleware(['can:view-subCategories']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateSubCategory $request)
    {
        $columns = $request->all();

        $category = $this->repository->create($columns);

        return redirect()
            ->back()
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$subCategory = $this->repository->where('id', $id)->first()) {

            return redirect()
                ->route('categories.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.compras.subCategory.show', [
            'subCategory' => $subCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateSubCategory $request, $id)
    {
        $columns = $request->all();

        if (!$subCategorie = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('categories.index')
                ->with('message', 'Registro não encontrado!');
        }

        $subCategorie->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$subCategorie = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('categories.index')
                ->with('message', 'Registro não encontrado!');
        }

        $subCategorie->delete();

        return redirect()
            ->route('categories.index')
            ->with('message', 'Excluido com sucesso!');
    }
}
