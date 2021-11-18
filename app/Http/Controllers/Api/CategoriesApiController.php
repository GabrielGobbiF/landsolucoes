<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Models\Compras\Category;
use Illuminate\Http\Request;

class CategoriesApiController extends Controller
{
    protected $repository;

    public function __construct(Category $categories)
    {
        $this->middleware('auth');

        $this->repository = $categories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->repository->paginate();

        return response()->json($categories);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        if (!$category = $this->repository->where('slug', $slug)->first()) {
            return response()->json('Object Category not found in scope', 404);
        }

        return new CategoriesResource($category);
    }
}
