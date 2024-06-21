<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateActivity;
use App\Http\Requests\StoreUpdateCategory;
use App\Http\Resources\ActivitiesResource;
use App\Http\Resources\CategoriesResource;
use App\Models\Compras\Category;
use App\Models\Obra;
use Illuminate\Http\Request;

class ActivitiesApiController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $comercialId)
    {
        if (!$comercial = Obra::where('id', $comercialId)->first()) {
            return response()->json('Object Obra not found in scope', 404);
        }

        if (!$activities = $comercial->activities()->with('user')->orderBy('id', 'desc')->get()) {
            return response()->json('Object Activities not found in scope', 404);
        }

        return ActivitiesResource::collection($activities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateActivity $request, $comercialId)
    {
        $attributes = $request->validated();

        if (!$comercial = Obra::where('id', $comercialId)->first()) {
            return response()->json('Object Obra not found in scope', 404);
        }

        $activities = $comercial->activities()->create($attributes);

        return new ActivitiesResource($activities);
    }
}
