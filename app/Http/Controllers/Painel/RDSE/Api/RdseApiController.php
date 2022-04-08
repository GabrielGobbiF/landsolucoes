<?php

namespace App\Http\Controllers\Painel\RDSE\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HandsworksResource;
use App\Models\RSDE\Handswork;
use App\Models\RSDE\Rdse;
use App\Models\RSDE\RdseServices;
use Illuminate\Http\Request;

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
                        ]);
                    }
                }
            }
        }

        return response()->json(true, 200);
    }

    public function getLastId()
    {
        $rdse = RdseServices::orderby('id', 'DESC')->select('id')->limit(1)->first();
        return response()->json(!empty($rdse) ? $rdse->id : '1', 200);
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
}
