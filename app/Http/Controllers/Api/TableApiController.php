<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ComercialResource;
use App\Http\Resources\ConcessionariaResource;
use App\Http\Resources\ServiceResource;
use App\Models\Client;
use App\Models\Concessionaria;
use App\Models\Obra;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TableApiController extends Controller
{
    protected $limit, $offset, $order;

    public function __construct(Request $request)
    {
        $this->limit = $request->input('pageSize') ?? '10';
        $this->order = $request->input('order') ?? 'desc';
        $this->offset = $request->input('offset') ?? 0;
        $this->search = $request->input('search') ?? '';
        $this->sort = $request->input('sort') ?? 'id';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clients()
    {
        $clients = new Client();

        $clients = $this->get($clients, ['company_name', 'username', 'cnpj']);

        return ClientResource::collection($clients);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function services()
    {
        $services = new Service();

        $services = $this->get($services, ['name', 'slug']);

        return ServiceResource::collection($services);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function concessionarias()
    {
        $concessionarias = new Concessionaria();

        $concessionarias = $this->get($concessionarias, ['name', 'slug'], ['services']);

        return ConcessionariaResource::collection($concessionarias);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comercial()
    {
        $search = $this->search;

        $comercial = Obra::where(function ($query) use ($search) {
            if ($search != '') {
                $query->orWhere('razao_social', 'LIKE', '%' . $search . '%');
            }
        })
            ->where('status', '<>', 'aprovada')
            ->with('concessionaria')
            ->with('service')
            ->with('client')
            ->paginate($this->limit);


        return ComercialResource::collection($comercial);
    }

    /**
     * Display query for DB.
     * @param  \Illuminate\Http\Model  $model
     * @param  array  $searchColumns colunas que podem ser pesquisadas
     * @param  array  $withCount
     * @return \Illuminate\Http\Response
     */
    public function get($model, array $searchColumns, array $withCount = [])
    {
        return $model
            ->where(function ($query) use ($searchColumns) {
                $search = $this->search;
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search . '%');
                    }
                }
            })
            ->where(function ($query) use ($searchColumns) {
                $search = $this->search;
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search . '%');
                    }
                }
            })
            ->withCount($withCount)
            ->orderBy($this->sort, $this->order)
            ->paginate($this->limit);
    }

    //->with(["client" => function ($q) use ($search) {
    //    if ($search != '') {
    //        $q->orWhere('clients.company_name', 'LIKE', '%' . $search . '%');
    //    }
    //}])
    //->with(["concessionaria" => function ($q) use ($search) {
    //    if ($search != '') {
    //        $q->orWhere('concessionarias.name', 'LIKE', '%' . $search . '%');
    //    }
    //}])
    //->with(["service" => function ($q) use ($search) {
    //    if ($search != '') {
    //        $q->orWhere('services.name', 'LIKE', '%' . $search . '%');
    //    }
    //}])
}
