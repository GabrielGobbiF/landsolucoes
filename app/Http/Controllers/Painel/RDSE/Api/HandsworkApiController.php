<?php

namespace App\Http\Controllers\Painel\RDSE\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HandsworksResource;
use App\Models\RSDE\Handswork;
use Illuminate\Http\Request;

class HandsworkApiController extends Controller
{
    protected $repository;

    public function __construct(Handswork $categories)
    {
        $this->middleware('auth');

        $this->repository = $categories;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $search = $request->input('search', null);

        $searchColumns = ['code', 'description', 'price'];

        $handsworks = $this->repository
            ->where(function ($query) use ($searchColumns, $search) {
                if (!empty($search['term']) && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search['term'] . '%');
                    }
                }
            })->get();

        return HandsworksResource::collection($handsworks);
    }
}
