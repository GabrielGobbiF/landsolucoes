<?php

namespace App\Http\Controllers\Painel\RDSE\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HandsworksResource;
use App\Models\RSDE\Handswork;
use Illuminate\Http\Request;

class RdseApiController extends Controller
{
    protected $repository;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    public function storeService(Request $request)
    {
        dd($request->all());
    }
}
