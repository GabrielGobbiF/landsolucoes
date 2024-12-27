<?php

namespace App\Http\Controllers\Painel\RDSE\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HandsworksResource;
use App\Http\Resources\RdseAtividadesResource;
use App\Http\Resources\RdseResource;
use App\Models\Inventory;
use App\Models\ResbRequisicao;
use App\Models\RSDE\Handswork;
use App\Models\RSDE\Rdse;
use App\Models\RSDE\RdseActivity;
use App\Models\RSDE\RdseActivityItens;
use App\Models\RSDE\RdseServices;
use App\Models\RSDE\Resb;
use App\Services\Rdse\RdseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RdseApiController extends Controller
{
    public function __construct(private Rdse $repository, private RdseService $rdseService) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {}


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $rdseId)
    {
        if (!$rdse = $this->repository->select('observations')->where('id', $rdseId)->first()) {
            return response()->json('Object RDSE not found in scope', 404);
        }

        return response()->json($rdse, 200);
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

        $statusExecutionObservation = $request->input('status_observation', null);

        if (!$statusExecution) {
            return response()->json('Select one status', 404);
        }

        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return response()->json('Object RDSE not found in scope', 404);
        }

        $rdse->status_execution = $statusExecution;
        $rdse->observation_status = $statusExecutionObservation;
        $rdse->save();

        return response()->json(true, 200);
    }

    public function storeAtividade(Request $request, $rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdse) não encontrado!');
        }

        $this->rdseService->adicionarAtividade($request, $rdse);

        return response()->json(true, 200);
    }

    public function atividades($rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdse) não encontrado!');
        }

        $atividades = $rdse->activities()->orderBy('data')->get();

        return RdseAtividadesResource::collection($atividades);
    }

    public function deleteAtividade($rdseId, $rdseAtividadeId)
    {
        if (!$rdseAtividade = RdseActivity::where('id', $rdseAtividadeId)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdse) não encontrado!');
        }

        $rdseAtividade->delete();

        return response()->json(true, 200);
    }

    public function updateRdseResb(Request $request, $rdseId)
    {
        if (!$rdse = Rdse::where('id', $rdseId)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdse) não encontrado!');
        }

        if (empty($rdse->resb_enel)) {
            $rdse->resbs()->delete();
        }

        $type = $request->query('type');

        $data = $request->input('data');

        #$columns = [
        #    'id' => 0,
        #    'Cód. Mat' => 1,
        #    'UND' => 2,
        #    'Descrição' => 3,
        #    'Quant. Plan' => 4,
        #    'Quant. Viabilidade' => 5,
        #    'Quant. Executada' => 6,
        #];

        #if ($type === 'viabilidade') {
        #    $columns['Quant. Viabilidade'] = 5;
        #}

        $requisicoes = ResbRequisicao::where('rdse_id', $rdse->id)->get();
        $requisicoesAgrupadas = $requisicoes->groupBy('unique');
        $qntRequisicao = $requisicoes->count();

        foreach ($requisicoes->groupBy('unique') as $unique => $value) {
            $columns[] = $value->where('unique', $unique)->first()?->unique;
        }

        if ($qntRequisicao > 0) {

            foreach ($data as $linhaIndex => $linha) {
                $itemId = $linha[0]; // Obtém o `item_id` (que está na coluna índice 1)

                // Para cada requisição, temos duas colunas (qnt e qnt_executada)
                for ($i = 0; $i < $qntRequisicao; $i++) {
                    // Calcula os índices das colunas
                    $posicaoQnt = 6 + ($i * 2); // Começa em 6 e avança de 2 em 2
                    $posicaoQntExecutada = $posicaoQnt + 1; // A próxima coluna é `qnt_executada`

                    if (!array_key_exists($posicaoQnt, $linha) || !array_key_exists($posicaoQntExecutada, $linha)) {
                        continue; // Pula para a próxima iteração, já que as colunas não existem
                    }

                    $qnt = $linha[$posicaoQnt];
                    $qntExecutada = $linha[$posicaoQntExecutada];


                    ResbRequisicao::where('rdse_id', $rdse->id)->where('resb_id', $itemId)->where('unique', $i + 1)?->update(
                        [
                            'qnt' => $qnt,
                            'qnt_executada' => $qntExecutada
                        ]
                    );
                }
            }
        }

        foreach ($data as $row) {

            if (empty($row[1])) {
                Resb::where('id', $row[0])?->delete();
                continue;
            }

            $itemData = [];

            $inventario = Inventory::where('cod_material', $row[1])->first();

            if ($inventario) {
                #foreach ($columns as $columnName => $index) {
                #    // Adiciona os dados mapeados por nome da coluna
                #    $itemData[$columnName] = $row[$index] ?? null;
                #}
                #
                Resb::updateOrCreate(
                    ['id' => $row[0]],
                    [
                        'rdse_id' => $rdse->id,
                        'item_id' => $inventario->id,
                        'qnt_planejada' => $row[4] ?? 0,
                        'qnt_viabilidade' => $row[5] ?? 0,
                        'qnt_executada' => $row[6] ?? 0,
                    ]
                );
            }
        }

        return response()->json(['success' => true]);
    }

    public function getAtividadesEquipesHoje(Request $request, $equipeId)
    {
        $date = $request->input('date');

        $dateSearch = __date_format($date, 'Y-m-d');

        $atividades = RdseActivity::where('equipe_id', $equipeId)
            ->whereDate('data', $dateSearch)
            ->get();

        return RdseAtividadesResource::collection($atividades);
    }

    public function getAtividadesEquipes(Request $request, $equipeId)
    {
        $atividades = RdseActivity::where('equipe_id', $equipeId)
            ->select('data')
            ->get()
            ->pluck('data');

        return response()->json($atividades);
    }
}
