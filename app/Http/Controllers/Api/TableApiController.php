<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\CelularesResource;
use App\Http\Resources\ClientFormInvoicingResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ComercialResource;
use App\Http\Resources\ConcessionariaResource;
use App\Http\Resources\DriversResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EpiResource;
use App\Http\Resources\FornecedoresResource;
use App\Http\Resources\HandsworksResource;
use App\Http\Resources\InventoryResource;
use App\Http\Resources\ModeloRdseResource;
use App\Http\Resources\NameResource;
use App\Http\Resources\ObraResource;
use App\Http\Resources\OrcamentoResource;
use App\Http\Resources\PortariaResource;
use App\Http\Resources\ProdutosResource;
use App\Http\Resources\RdseResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VehiclesResource;
use App\Http\Resources\VisitorResource;
use App\Models\Celular;
use App\Models\Client;
use App\Models\ClientFormInvoicing;
use App\Models\Compras\Category;
use App\Models\Compras\Fornecedor;
use App\Models\Compras\Orcamento;
use App\Models\Compras\Produto;
use App\Models\Concessionaria;
use App\Models\Driver;
use App\Models\Employee;
use App\Models\Encarregado;
use App\Models\Epi;
use App\Models\Equipe;
use App\Models\Etd;
use App\Models\Inventory;
use App\Models\Obra;
use App\Models\ObraEtapa;
use App\Models\ObraEtapasFinanceiro;
use App\Models\Portaria;
use App\Models\RSDE\Handswork;
use App\Models\RSDE\ModeloRdse;
use App\Models\RSDE\Rdse;
use App\Models\Service;
use App\Models\Supervisor;
use App\Models\TiposObra;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableApiController extends Controller
{
    protected $limit, $offset, $order, $search, $sort, $filter, $request;

    public function __construct(Request $request)
    {
        $this->limit = $request->input('pageSize') ?? '20';
        $this->order = $request->input('order') ?? 'asc';
        $this->offset = $request->input('offset') ?? 0;
        $this->search = $request->input('search') ?? '';
        $this->sort = $request->input('sort') ?? 'id';
        $this->filter = $request->input('filter') ?? [];
        $this->request = $request->all();
    }

    public function drivers()
    {
        $search = $this->search;

        #$drivers = User::whereHas('roles', function ($query) {
        #    return $query->where('slug', 'driver');
        #})->where(function ($query) use ($search) {
        #    if ($search != '') {
        #        $query->orWhere('name', 'LIKE', '%' . $search . '%');
        #        $query->orWhere('username', 'LIKE', '%' . $search . '%');
        #        $query->orWhere('email', 'LIKE', '%' . $search . '%');
        #    }
        #})->paginate($this->limit);

        $drivers = Driver::filtered(request()->all())->orderby('id', 'desc')->paginate($this->limit);

        return DriversResource::collection($drivers);
    }

    public function visitors()
    {
        $search = $this->search;

        $visitor = Visitor::filtered(request()->all())->orderby('id', 'desc')->paginate($this->limit);

        return VisitorResource::collection($visitor);
    }

    public function epi()
    {
        $search = $this->search;

        $epi = Epi::paginate($this->limit);

        return EpiResource::collection($epi);
    }

    public function etd()
    {
        $search = $this->search;

        $etd = Etd::paginate($this->limit);

        return EpiResource::collection($etd);
    }


    /**
     * Display a listing of the resource.
     *
     */
    public function portarias()
    {
        $filters = $this->filter;

        $filters['search'] =  $this->search;

        $portaria = DB::table('portarias')
            ->select('portarias.*', 'drivers.name as userName', 'vehicles.name as vehicleName', 'vehicles.board as vehicleBoard')
            ->leftJoin('vehicles', 'portarias.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('drivers', 'portarias.motorista_id', '=', 'drivers.id')
            ->where(function ($query) use ($filters) {
                if (isset($filters['search']) && $filters['search'] != '') {
                    $query->orWhere('vehicles.name', 'LIKE', '%' . $filters['search'] . '%');
                    $query->orWhere('vehicles.board', 'LIKE', '%' . $filters['search'] . '%');
                    $query->orWhere('drivers.name', 'LIKE', '%' . $filters['search'] . '%');
                }

                if (isset($filters['driver_id']) && $filters['driver_id'] != '') {
                    $query->where('drivers.id',  $filters['driver_id']);
                }

                if (isset($filters['vehicle_id']) && $filters['vehicle_id'] != '') {
                    $query->where('vehicles.id',  $filters['vehicle_id']);
                }

                if (isset($filters['at']) && $filters['at'] != '') {
                    $query->whereDate('portarias.created_at',  $filters['at']);
                }


                if (isset($filters['veiculo_tipo']) && $filters['veiculo_tipo'] != '') {
                    $query->where('portarias.veiculo_tipo',  $filters['veiculo_tipo']);
                }
            })
            ->orderBy('portarias.created_at', 'desc')
            ->paginate($this->limit);

        return PortariaResource::collection($portaria);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function vehicles()
    {
        $vehicles = new Vehicle();

        $searchColumns = ['board', 'year', 'id', 'name', 'renavam', 'type'];

        $vehicles = $vehicles
            ->where(function ($query) use ($searchColumns) {
                $search = $this->search;
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search . '%');
                    }
                }
            })
            ->where('is_active', 'Y')
            ->orderBy($this->sort, $this->order)
            ->paginate($this->limit);


        return VehiclesResource::collection($vehicles);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function categories()
    {
        $categories = new Category();

        $categories = $this->get($categories, ['id', 'name', 'slug']);

        return CategoriesResource::collection($categories);
    }

    public function handswork()
    {
        $handsworks = new Handswork();

        $searchColumns = ['id', 'description', 'price', 'price_ups', 'code'];

        $handsworks = $handsworks
            ->where(function ($query) use ($searchColumns) {
                $search = $this->search;
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search . '%');
                    }
                }
            })
            ->orderBy($this->sort, $this->order);

        $handsworks = $this->limit == 'all' ? $handsworks->get() : $handsworks->paginate($this->limit);

        return HandsworksResource::collection($handsworks);
    }

    public function tiposObras()
    {
        $tiposObra = new TiposObra();

        $searchColumns = ['id', 'name'];

        $tiposObra = $tiposObra
            ->where(function ($query) use ($searchColumns) {
                $search = $this->search;
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search . '%');
                    }
                }
            })
            ->orderBy($this->sort, $this->order);

        $tiposObra = $this->limit == 'all' ? $tiposObra->get() : $tiposObra->paginate($this->limit);


        return NameResource::collection($tiposObra);
    }


    public function equipes()
    {
        $equipes = new Equipe();

        $searchColumns = ['id', 'name'];

        $equipes = $equipes
            ->where(function ($query) use ($searchColumns) {
                $search = $this->search;
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search . '%');
                    }
                }
            })
            ->orderBy($this->sort, $this->order)
            ->paginate($this->limit);

        return NameResource::collection($equipes);
    }

    public function inventories()
    {
        $inventories = new Inventory();

        $searchColumns = ['id', 'name', 'cod_material'];

        $inventories = $inventories
            ->where(function ($query) use ($searchColumns) {
                $search = $this->search;
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search . '%');
                    }
                }
            })
            ->orderBy($this->sort, $this->order)
            ->paginate($this->limit);

        return InventoryResource::collection($inventories);
    }


    public function supervisores()
    {
        $supervisores = new Supervisor();

        $searchColumns = ['id', 'name'];

        $supervisores = $supervisores
            ->where(function ($query) use ($searchColumns) {
                $search = $this->search;
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search . '%');
                    }
                }
            })
            ->orderBy($this->sort, $this->order)
            ->paginate($this->limit);

        return NameResource::collection($supervisores);
    }

    public function encarregados()
    {
        $encarregados = new Encarregado();

        $searchColumns = ['id', 'name'];

        $encarregados = $encarregados
            ->where(function ($query) use ($searchColumns) {
                $search = $this->search;
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search . '%');
                    }
                }
            })
            ->orderBy($this->sort, $this->order)
            ->paginate($this->limit);

        return NameResource::collection($encarregados);
    }

    public function clientsFormInvoicing()
    {
        $ClientFormInvoicing = new ClientFormInvoicing();

        $searchColumns = ['id', 'email_financeiro'];

        $ClientFormInvoicing = $ClientFormInvoicing
            ->where(function ($query) use ($searchColumns) {
                $search = $this->search;
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search . '%');
                    }
                }
            })
            ->orderBy($this->sort, $this->order)
            ->paginate($this->limit);

        return ClientFormInvoicingResource::collection($ClientFormInvoicing);
    }

    public function ModelosRdses()
    {
        $rdses = new Rdse();

        $searchColumns = ['id', 'description', 'type'];

        $filters = $this->filter;

        $filters['search'] =  $this->search;

        $rdses = $rdses
            ->where(function ($query) use ($searchColumns) {
                $search = !is_array($this->search) ?  $this->search : (isset($this->search['term']) ? $this->search['term'] : null);
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->Orwhere($searchColumn, 'LIKE', "%$search%");
                    }
                }
            })
            ->where('modelo', 1)
            ->orderBy($this->sort, $this->order)
            ->paginate($this->limit);

        return ModeloRdseResource::collection($rdses);
    }

    public function rdses()
    {
        $rdses = new Rdse();

        $searchColumns = ['id', 'description', 'n_order', 'equipe', 'solicitante', 'at', 'type', 'status'];

        $filters = $this->filter;
        $filters['search'] =  $this->search;

        $datesPeriodoSearch = null;

        if (!empty($filters['period'])) {
            $datesPeriodoSearch = calculateDates(
                $filters['period'],
                $filters['start_at'],
                $filters['end_at']
            );
        }

        $rdses = $rdses
            ->where(function ($query) use ($searchColumns) {
                $search = $this->search;
                if ($search != '' && !is_null($searchColumns)) {
                    $search = is_array($search) && isset($search['term']) ? $search['term'] : $search;
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search . '%');
                    }
                }
            })->where(function ($query) use ($filters) {
                if (!empty($filters['status'])) {
                    $query->whereIn('rdses.status', $filters['status']);
                }
            })->where(function ($query) use ($filters) {
                if (!empty($filters['type'])) {
                    $query->where('rdses.type', $filters['type']);
                }
            })->where(function ($query) use ($filters) {
                if (isset($filters['status'])) {
                    if (!empty($filters['lote']) && $filters['status'] != '' && $filters['status'] !=  'pending') {
                        $query->where('rdses.lote', $filters['lote']);
                    }
                }
            })->where(function ($query) use ($filters) {
                if (!empty($filters['status_execution'])) {
                    $query->whereIn('rdses.status_execution', $filters['status_execution']);
                }
            })
            ->where(function ($query) use ($filters) {
                if (!empty($filters['status_closing'])) {
                    $query->whereIn('rdses.status_closing', $filters['status_closing']);
                }
            })
            ->where(function ($query) use ($filters) {
                if (!empty($filters['nfe'])) {
                    $query->where('rdses.nf', $filters['nfe']);
                }
            })
            ->where(function ($query) use ($filters) {
                if (!empty($filters['tipo_obra'])) {
                    $query->where('rdses.tipo_obra', $filters['tipo_obra']);
                }
            })
            ->where(function ($query) use ($filters) {
                if (!empty($filters['equipe_id'])) {
                    $query->whereHas('activities', function ($query) use ($filters) {
                        $query->where('equipe_id',  $filters['equipe_id']);
                    });
                }
            })
            ->where(function ($query) use ($filters) {
                if (!empty($filters['diretoria'])) {
                    $query->where('diretoria',  $filters['diretoria']);
                }
            })

            ->where(function ($query) use ($filters) {
                if (!empty($filters['daterange'])) {
                    [$date_to, $date_from] = explode(' - ', $filters['daterange']);
                    $date_to = return_format_date($date_to, 'en');
                    $date_from = return_format_date($date_from, 'en');

                    $query->whereHas('activities', function ($query) use ($date_from, $date_to) {
                        $query->whereDate('data', '>=', $date_to);
                        $query->whereDate('data', '<=', $date_from);
                    });
                }
            })
            ->where(function ($query) use ($filters) {
                if (!empty($filters['month_date'])) {
                    $query->whereMonth('month_date', $filters['month_date']);
                    $query->whereYear('month_date', $filters['year']);
                }
            })

            ->where(function ($query) use ($filters) {
                if (isset($this->request['obra_id'])) {
                    if ($this->request['obra_id'] == 'empty') {
                        $query->whereNull('obra_id');
                    }
                }
            })

            ->where(function ($query) use ($filters) {
                if (isset($filters['atividades'])) {
                    if ($filters['atividades'] !== 'all') {
                        $query->whereHas('activities', function ($query) use ($filters) {
                            if ($filters['atividades'] == 'nao_execucao') {
                                $query->whereNull('execucao'); // Filtra apenas atividades com execução nula
                            } else if ($filters['atividades'] == 'execucao') {
                                $query->whereNotNull('execucao'); // Filtra atividades com execução preenchida
                            }
                        });
                    }
                }
            })

            ->where(function ($query) use ($datesPeriodoSearch) {
                if (!empty($datesPeriodoSearch)) {
                    $query->whereHas('activities', function ($query) use ($datesPeriodoSearch) {
                        $query->whereBetween('data', [$datesPeriodoSearch['start_at'], $datesPeriodoSearch['end_at']]);
                    });
                }
            })->where(function ($q) use ($filters) {

                if (isset($filters['hour'])) {
                    $q->whereHas('activities', function ($query) use ($filters) {
                        $turno = $filters['hour'];

                        if ($turno === 'diurno') {
                            $query->whereBetween('data_inicio', ['07:00', '19:00']);
                        } elseif ($turno === 'noturno') {
                            // Turno noturno: das 19:40 às 06:00 (passando pela meia-noite)
                            $query->whereBetween('data_inicio', ['19:40', '23:59'])
                                ->orWhereBetween('data_inicio', ['00:00', '06:00']);
                        }
                    });
                }
            })

            ->where('modelo', 0)
            ->orderBy($this->sort, $this->order)
            ->paginate($this->limit);

        #dd([$rdses->toSql(), $rdses->getBindings()]);

        return RdseResource::collection($rdses);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function orcamentos()
    {
        $orcamentos = new Orcamento();

        $orcamentos = $this->get($orcamentos, ['id']);

        return OrcamentoResource::collection($orcamentos);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function produtos()
    {
        $produtos = new Produto();

        $produtos = $this->get($produtos, ['id', 'name', 'slug', 'unidade', 'categoria', 'sub_categoria']);

        return ProdutosResource::collection($produtos);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function employees()
    {
        $employees = new Employee();

        $employees = $this->get($employees, ['id', 'uuid', 'name', 'rg', 'ctps', 'endereco', 'cargo', 'cnh_number', 'equipe', 'salario', 'cnh', 'email']);

        return EmployeeResource::collection($employees);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function celulares()
    {
        $celulares = new Celular();

        $celulares = $this->get($celulares, ['id', 'linha', 'usuario', 'equipe', 'responsavel']);

        return CelularesResource::collection($celulares);
    }

    /**
     * Display a listing of the resource.
     *
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
     */
    public function fornecedores()
    {
        $fornecedores = new Fornecedor();

        $fornecedores = $this->get($fornecedores, []);

        return FornecedoresResource::collection($fornecedores);
    }

    /**
     * Display a listing of the resource.
     *
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
     */
    public function comercial()
    {
        $filters = $this->filter;
        $filters['search'] =  $this->search;

        $comercial = DB::table('obras')
            ->select('obras.*', 'services.name as service_name', 'concessionarias.name as concessionaria_name', 'clients.company_name')
            ->where(function ($query) use ($filters) {
                if (isset($filters['status']) && $filters['status'] != '') {
                    $query->whereIn('status', $filters['status']);
                } else {
                    $query->where('status', '<>', 'concluida');
                }
            })
            ->join('clients', function ($join) use ($filters) {
                $join->on('obras.client_id', '=', 'clients.id')
                    ->where(function ($query) use ($filters) {
                        if (isset($filters['client_id']) && $filters['client_id'] != '') {
                            $query->where('clients.id',  $filters['client_id']);
                        }
                    });
            })
            ->join('concessionarias', function ($join) use ($filters) {
                $join->on('obras.concessionaria_id', '=', 'concessionarias.id')
                    ->where(function ($query) use ($filters) {
                        if (isset($filters['concessionaria_id']) && $filters['concessionaria_id'] != '') {
                            $query->where('concessionarias.id',  $filters['concessionaria_id']);
                        }
                    });
            })
            ->join('services', 'obras.service_id', '=', 'services.id')

            ->whereNull('obras.deleted_at')
            ->where(function ($query) use ($filters) {
                if ($filters['search'] != '') {
                    $query->orWhere('last_note', 'LIKE', '%' . $filters['search'] . '%');
                    $query->orWhere('razao_social', 'LIKE', '%' . $filters['search'] . '%');
                }
            })
            ->groupBy('obras.id')
            ->orderBy($this->sort, $this->order)
            ->paginate($this->limit);


        return ComercialResource::collection($comercial);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function obras()
    {
        $filters = $this->filter;
        $filters['search'] =  $this->search;
        $hoje = Carbon::today();

        $obras = DB::table('obras')
            ->select(
                'obras.*',
                'services.name as service_name',
                'concessionarias.name as concessionaria_name',
                'clients.username'
            )
            ->join('clients', 'obras.client_id', '=', 'clients.id')
            ->when(isset($filters['client_id']) && $filters['client_id'] != '', function ($query) use ($filters) {
                $query->where('clients.id', $filters['client_id']);
            })
            ->join('concessionarias', 'obras.concessionaria_id', '=', 'concessionarias.id')
            ->when(isset($filters['concessionaria_id']) && $filters['concessionaria_id'] != '', function ($query) use ($filters) {
                $query->where('concessionarias.id', $filters['concessionaria_id']);
            })
            ->join('services', function ($join) use ($filters) {
                $join->on('obras.service_id', '=', 'services.id')
                    ->where(function ($query) use ($filters) {
                        if (isset($filters['service_id']) && $filters['service_id'] != '') {
                            $query->where('obras.service_id',  $filters['service_id']);
                        }
                    });
            })
            ->leftJoin('favoritables', function ($join) {
                $join->on('favoritables.favoritable_id', '=', 'obras.id')
                    ->where('favoritables.favoritable_type', 'App\\Models\\Obra')
                    ->where('favoritables.user_id', '=', auth()->user()->id);
            })

            ->join('obras_etapas', 'obras.id', '=', 'obras_etapas.id_obra')
            ->when(isset($filters['obras_etapas_a_vencer']), function ($query) use ($hoje) {
                // obras_etapas a vencer (vencimento é hoje)
                $query->where('obras_etapas.check', '<>', 'C')->whereRaw('DATE_ADD(obras_etapas.data_abertura, INTERVAL obras_etapas.prazo_atendimento DAY) = ?', [$hoje]);
            })
            ->when(isset($filters['obras_etapas_vencidas']), function ($query) use ($hoje) {
                // obras_etapas vencidas (vencimento passou)
                $query->where('obras_etapas.check', '<>', 'C')->whereRaw('DATE_ADD(obras_etapas.data_abertura, INTERVAL obras_etapas.prazo_atendimento DAY) < ?', [$hoje]);
            })
            ->when(isset($filters['updated_at']), function ($query) use ($hoje) {
                $doisDiasAtrasInicio = Carbon::now()->subDays(5)->startOfDay();
                $query->where('obras.updated_at', '<', $doisDiasAtrasInicio);
            })
            ->when(isset($filters['last_note']), function ($query) {
                $query->whereNull('obras.last_note');
            })
            ->whereNull('obras.deleted_at')
            ->when(!empty($filters['search']), function ($query) use ($filters) {
                $query->where('last_note', 'LIKE', '%' . $filters['search'] . '%')
                    ->orWhere('razao_social', 'LIKE', '%' . $filters['search'] . '%');
            })
            ->when(isset($filters['arq']) && !empty($filters['arq']), function ($query) {
                $query->where('obras.status', 'concluida');
            }, function ($query) {
                $query->whereIn('obras.status', ['aprovada'])
                    ->where('obras.status', '<>', 'concluida');
            })

            ->when(isset($filters['fav']), function ($query) {
                $query->whereNotNull('favoritables.id');
            })

            ->when(isset($filters['gestor_id']), function ($query) use ($filters) {
                $query->where('gestor_id', $filters['gestor_id']);
            })

            ->when(isset($filters['urgence']), function ($query) {
                $query->where('obras.obr_urgence', 'Y');
            })
            ->groupBy('obras.id')
            ->whereNull('obras.deleted_at')
            ->orderBy($this->sort, $this->order)
            ->paginate($this->limit);

        return ObraResource::collection($obras);
    }

    public function users_table(Request $request)
    {
        $users = new User();

        $users = $this->get($users, ['name']);

        return UserResource::collection($users);
    }
    public function users(Request $request)
    {
        $search = $request->input('q.term');

        $user = User::where(function ($query) use ($search) {
            if ($search != '') {
                $query->orWhere('name', 'LIKE', '%' . $search . '%');
                $query->orWhere('username', 'LIKE', '%' . $search . '%');
                $query->orWhere('email', 'LIKE', '%' . $search . '%');
            }
        })->get();

        return UserResource::collection($user);
    }

    public function etapas_financeiro($obra_id)
    {
        if (!$comercial = Obra::where('id', $obra_id)->first()) {
            return redirect()
                ->route('comercial.index')
                ->with('message', 'Registro não encontrado!');
        }

        $financeiro = $comercial->financeiro()->first();

        if ($financeiro) {
            $etapasFinaneiroSoma = $comercial->etapas_financeiro()->sum('valor_receber') ?? 0;
            $totalFaturar = $etapasFinaneiroSoma;
        }

        $etapasFinanceiro = $comercial->etapas_financeiro()->where('obra_id', $obra_id)->get();

        $etapasFinanceiro->map(function ($etp) {
            if (isset($etp['valor_receber']) && !empty($etp['valor_receber'])) {
                $etp['valor_receber'] =  number_format($etp['valor_receber'], 2, ',', '');
            }
            return $etp;
        });

        $etapasFinanceiro['totalFaturar'] = number_format($totalFaturar, 2, ',', '') ?? 0;

        return response()->json($etapasFinanceiro);
    }

    /**
     * Display query for DB.
     * @param  \Illuminate\Http\Model  $model
     * @param  array  $searchColumns colunas que podem ser pesquisadas
     * @param  array  $withCount
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
    //$ranking = DB::table('ranking')
    //            ->select(DB::raw('SUM(xp) AS total_xp, SUM(ap) AS total_ap, SUM(trophys_first_place) as total_trophys_first_place, SUM(trophys_second_place) as total_trophys_second_place, SUM(trophys_third_place) as total_trophys_third_place'), 'users.name', 'users.uuid as userUuid', 'users.avatar', 'users.username', 'users_social.twitter')
    //            ->join('games', function ($join) use ($request) {
    //                $join->on('ranking.game_id', '=', 'games.id')
    //                    ->where(function ($query) use ($request) {
    //                        if ($request->game_id) {
    //                            $query->orWhere('games.id', '=', $request->game_id);
    //                        }
    //                    });
    //            })
    //            ->join('users', function ($join) use ($request) {
    //                $join->on('ranking.user_id', '=', 'users.id')
    //                    ->where(DB::raw('users.is_active'), 'Y');
    //            })
    //            ->leftJoin('users_social', function ($join) use ($request) {
    //                $join->on('users_social.user_id', '=', 'users.id');
    //            })
    //            ->where('ranking.is_active', 'Y')
    //            ->groupByRaw(DB::raw('ranking.user_id'))
    //            ->orderby($order, 'DESC')
    //            ->limit($request->limit)
    //            ->get();
}
