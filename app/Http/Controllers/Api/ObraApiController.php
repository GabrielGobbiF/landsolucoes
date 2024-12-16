<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEtapaObra;
use App\Http\Resources\ObraResource;
use App\Http\Resources\ServiceResource;
use App\Models\Concessionaria;
use App\Models\Obra;
use App\Models\Pasta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ObraApiController extends Controller
{
    protected $repository, $obra;

    public function __construct(Obra $obra)
    {
        $this->obra = $obra;
    }

    public function all(Request $request)
    {
        $filters = $request->all();

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
                $query->whereNotNull('favoritables.id'); // Filtra somente obras marcadas como favoritas
            })
            ->when(isset($filters['urgence']), function ($query) {
                $query->where('obras.obr_urgence', 'Y');
            })
            ->groupBy('obras.id')
            ->paginate(60);

        return ObraResource::collection($obras);
    }

    public function show(Request $request, $obra_id)
    {
        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        return new ObraResource($obra);
    }

    public function update(StoreUpdateEtapaObra $request, $obra_id)
    {
        $columns = $request->all();

        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $obra->update([
            $columns['collumn'] => $columns['value']
        ]);

        return $obra->id;
    }

    public function documents(Request $request, int $obraId)
    {
        if (!$obra = $this->obra->where('id', $obraId)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $pasta = $obra->pasta()->orderBy('id', 'ASC')->first() ?? false;

        if ($pasta) {
            $docsPasta = $pasta->documentos()->get();
        } else {
            $url = '00tR9vps6D';
            $folder =  Pasta::create([
                'name' => $obra->razao_social,
                'type' => 'obras',
                'url' => '00tR9vps6D',
                'type_id' => $obra->id
            ]);
            Storage::makeDirectory($url . '/' . $folder->uuid);
        }

        $pasta = $pasta ? $pasta->childrens() : [];

        $returnHTML = view('pages.painel.obras.obras.documentos.index')
            ->with('pasta', $pasta)
            ->with('docsPasta', $docsPasta ?? [])
            ->with('obra', $obra)
            ->render();

        return response()->json($returnHTML  ?? [], 200);
    }

    public function getServicesByConcessionaria(Request $request, $concessionariaId)
    {
        $searchColumns = ['name'];

        $q = json_decode($request->input('filters', null))?->search;

        if (!$concessionaria = Concessionaria::where('id', $concessionariaId)->first()) {
            return response(['resource not found'], 404);
        }

        $services = $concessionaria->services()
            ->where(function ($query) use ($searchColumns, $q) {
                $search = $q;
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->orWhere($searchColumn, 'LIKE', '%' . $search . '%');
                    }
                }
            })
            ->orderBy('name')->get() ?? [];

        return ServiceResource::collection($services);
    }
}
