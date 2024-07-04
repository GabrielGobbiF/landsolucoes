<?php

namespace App\Http\Controllers\Painel\RDSE\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HandsworksResource;
use App\Http\Resources\RdseResource;
use App\Models\RSDE\Handswork;
use App\Models\RSDE\Rdse;
use App\Models\RSDE\RdseServices;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class RdseApiController extends Controller
{
    protected $repository;

    public function __construct(Rdse $rdses)
    {
        $this->repository = $rdses;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    public function storeService(Request $request, $rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return response()->json('Object RDSE not found in scope', 404);
        }

        $lastServiceRdseById = $rdse->services()->orderby('id', 'DESC')->limit(1)->first();

        if (isset($lastServiceRdseById)) {
            if ($lastServiceRdseById->minutos == '0') {
                return response()->json('andamento', 200);
            }
        }

        $service = $rdse->services()->create();

        return response()->json($service->id, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request, int $identify)
    {
        $columns = $request->input('collumn');

        $value = $request->input('value');

        if (!$rdse = $this->repository->where('id', $identify)->first()) {
            return response()->json('Object RDSE not found in scope', 404);
        }

        $rdse->update([
            $columns => $value
        ]);

        return response()->json(true, 200);
    }

    public function updateServices(Request $request, $rdseId)
    {
        $columns = $request->all();

        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return response()->json('Object RDSE not found in scope', 404);
        }

        if (!empty($columns['chegada']) && is_array($columns['chegada'])) {
            for ($i = 0; $i < count($columns['chegada']); $i++) {

                /* TODO  */
                $serviceId = !empty($columns['serviceId'][$i]) ? $columns['serviceId'][$i] : false;

                $chegada = !empty($columns['chegada'][$i]) ? $columns['chegada'][$i] : '';
                $minutos = !empty($columns['minutos'][$i]) ? $columns['minutos'][$i] : '';
                $saida = !empty($columns['saida'][$i]) ? $columns['saida'][$i] : '';
                $horas = !empty($columns['horas'][$i]) ? $columns['horas'][$i] : '';
                $codigo_sap = !empty($columns['codigo_sap'][$i]) ? $columns['codigo_sap'][$i] : null;
                $description = !empty($columns['description'][$i]) ? $columns['description'][$i] : '';
                $qnt_atividade = !empty($columns['qnt_atividade'][$i]) ? $columns['qnt_atividade'][$i] : '';
                $preco = !empty($columns['preco'][$i]) ? $columns['preco'][$i] : '';

                $p_quantidade1 = !empty($columns['p_quantidade1'][$i]) ? $columns['p_quantidade1'][$i] : '';
                $p_preco1 = !empty($columns['p_preco1'][$i]) ? $columns['p_preco1'][$i] : '';

                $p_quantidade2 = !empty($columns['p_quantidade2'][$i]) ? $columns['p_quantidade2'][$i] : '';
                $p_preco2 = !empty($columns['p_preco2'][$i]) ? $columns['p_preco2'][$i] : '';

                $p_quantidade3 = !empty($columns['p_quantidade3'][$i]) ? $columns['p_quantidade3'][$i] : '';
                $p_preco3 = !empty($columns['p_preco3'][$i]) ? $columns['p_preco3'][$i] : '';

                if ($serviceId) {
                    $serviceRdseById = RdseServices::where('id', $serviceId)->limit(1)->first();

                    if (!empty($serviceRdseById)) {
                        RdseServices::where('id', $serviceId)->update([
                            'codigo_sap' => $codigo_sap,
                            'chegada' => $chegada,
                            'saida' => $saida,
                            'minutos' => $minutos,
                            'horas' => $horas,
                            'description' => maiusculo($description),
                            'qnt_atividade' => $qnt_atividade,
                            'preco' => clearNumber($preco),

                            'p_preco1' => clearNumber($p_preco1),
                            'p_preco2' => clearNumber($p_preco2),
                            'p_preco3' => clearNumber($p_preco3),

                            'p_quantidade1' => $p_quantidade1,
                            'p_quantidade2' => $p_quantidade2,
                            'p_quantidade3' => $p_quantidade3,

                        ]);
                    }
                }
            }
        }

        return response()->json(true, 200);
    }

    public function deleteService($rdseId, $serviceId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return response()->json('Object RDSE not found in scope', 404);
        }

        if (!$service = $rdse->services()->where('id', $serviceId)->first()) {
            return response()->json('Object Service  not found in scope', 404);
        }

        if ($rdse->services()->count() != 1) {
            $service->delete();
        }

        return response()->json(true, 200);
    }

    public function reorderService(Request $request, $rdseId)
    {
        $itens = $request->input('itens');

        if (!empty($itens)) {

            if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
                return response()->json('Object RDSE not found in scope', 404);
            }

            try {
                foreach ($itens as $a => $value) {
                    $a = $a + 1;

                    $service = $rdse->services()->where('id', str_replace('services_', '', $value))->limit(1)->select('id')->first();

                    if (!empty($service)) {
                        $service->order = $a;
                        $service->save();
                    }
                }
                return response()->json('Reorder', 200);
            } catch (\Throwable $th) {
                #slack('não foi possivel reorder');

                dd($th->getMessage());

                return response()->json('Não foi possivel reordernar', 500);
            }
        }
    }

    public function getRdsesByGroup(Request $request)
    {
        $arrayGroupByRdseByType = [];

        $allRdse = [];

        $rdses = $request->input('rdses');
        $status = $request->input('status');

        foreach ($rdses as $rdse) {
            $rdseDecode = json_decode($rdse);
            $rdseId = $rdseDecode->id;
            $getRdse = Rdse::find($rdseId) ?? null;

            if ($getRdse) {
                $allRdse[] =  $getRdse;
            }
        }

        $groupByRdseByType = collect($allRdse)->groupby('type');

        foreach ($groupByRdseByType as $groupRdse => $itens) {
            $lotes = DB::table('rdses')
                ->select('lote')
                ->where('status', $status)
                ->where('type', $groupRdse)
                ->whereNotNull('lote')
                ->where('modelo', 0)
                ->groupBy('lote')
                ->get();

            $l = $lotes->map(function ($rdse) {
                return $rdse->lote === 0 ? 1 : $rdse->lote;
            });

            if (count($l) > 0) {
                $l->push(count($l) + 1);
            }

            $arrayGroupByRdseByType[$groupRdse] = [
                "lotes" => count($l) > 0 ? $l : [1],
                "itens" => RdseResource::collection($itens)
            ];
        }

        return response()->json($arrayGroupByRdseByType, 200);
    }

    public function updateStatusExecution(Request $request, $rdseId)
    {
        $statusExecution = $request->input('status_execution', null);

        if (!$statusExecution) {
            return response()->json('Select one status', 404);
        }

        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return response()->json('Object RDSE not found in scope', 404);
        }

        $rdse->update([
            'status_execution' => $statusExecution
        ]);

        return response()->json(true, 200);
    }
}
