<?php

namespace App\Http\Controllers\Painel\Compras;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategory;
use App\Models\Compras\Atuacao;
use App\Models\Compras\Category;
use App\Models\Compras\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{
    protected $repository;

    public function __construct(Category $categories)
    {
        $this->repository = $categories;

        //$this->middleware(['can:view-categories']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('subCategories')->get();
        $subCategoriesAll = SubCategory::all();

        return view('pages.painel.compras.categories.index', [
            'categories' => $categories,
            'subCategoriesAll' => $subCategoriesAll,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.painel.compras.categories.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateCategory $request)
    {
        $columns = $request->all();

        $category = $this->repository->create($columns);

        return redirect()
            ->route('categories.index', ['category' => $category->name])
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$categories = $this->repository->where('id', $id)->first()) {

            return redirect()
                ->route('categories.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.compras.categories.show', [
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateCategory $request, $id)
    {
        $columns = $request->all();

        if (!$category = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('categories.index')
                ->with('message', 'Registro não encontrado!');
        }

        $category->update($columns);

        if (isset($columns['sub_categories'])) {
            $category->subCategories()->sync($columns['sub_categories']);
        }

        return redirect()
            ->route('categories.index', ['category' => $category->name])
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$categorie = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('categories.index')
                ->with('message', 'Registro não encontrado!');
        }

        $categorie->delete();

        return redirect()
            ->route('categories.index')
            ->with('message', 'Excluido com sucesso!');
    }
}
