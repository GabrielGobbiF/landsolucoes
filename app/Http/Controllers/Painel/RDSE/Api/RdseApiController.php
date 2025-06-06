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
     */
    public function show(Request $request, $rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return response()->json('Object RDSE not found in scope', 404);
        }

        return new RdseResource($rdse);
    }


    public function storeService(Request $request, $rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return response()->json('Object RDSE not found in scope', 404);
        }

        $lastServiceRdseById = $rdse->services()->orderby('id', 'DESC')->limit(1)->first();

        if (isset($lastServiceRdseById)) {
            if (empty($lastServiceRdseById->codigo_sap)) {
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

        if (!empty($columns['codigo_sap']) && is_array($columns['codigo_sap'])) {
            for ($i = 0; $i < count($columns['codigo_sap']); $i++) {

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

                $p_quantidade4 = !empty($columns['p_quantidade4'][$i]) ? $columns['p_quantidade4'][$i] : '';
                $p_preco4 = !empty($columns['p_preco4'][$i]) ? $columns['p_preco4'][$i] : '';

                $p_quantidade5 = !empty($columns['p_quantidade5'][$i]) ? $columns['p_quantidade5'][$i] : '';
                $p_preco5 = !empty($columns['p_preco5'][$i]) ? $columns['p_preco5'][$i] : '';

                $p_quantidade6 = !empty($columns['p_quantidade6'][$i]) ? $columns['p_quantidade6'][$i] : '';
                $p_preco6 = !empty($columns['p_preco6'][$i]) ? $columns['p_preco6'][$i] : '';

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
                            'p_preco4' => clearNumber($p_preco4),
                            'p_preco5' => clearNumber($p_preco5),
                            'p_preco6' => clearNumber($p_preco6),

                            'p_quantidade1' => $p_quantidade1,
                            'p_quantidade2' => $p_quantidade2,
                            'p_quantidade3' => $p_quantidade3,
                            'p_quantidade4' => $p_quantidade4,
                            'p_quantidade5' => $p_quantidade5,
                            'p_quantidade6' => $p_quantidade6,

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

        $created = $this->rdseService->adicionarAtividade($request, $rdse);

        if ($request->hasFile('uploads')) {
            foreach ($request->file('uploads') as $file) {
                // Gera o caminho e salva o arquivo
                $filePath = $file->store('uploads', 'public');
                $fileHash = md5_file($file->getRealPath());

                // Salva no banco de dados
                $created->uploads()->create([
                    'user_id' => auth()->id(),
                    'name' => $file->getClientOriginalName(),
                    'file_name' => basename($filePath),
                    'mime_type' => $file->getMimeType(),
                    'path' => 'storage/' . $filePath,
                    'disk' => 'public',
                    'file_hash' => $fileHash,
                    'collection' => 'activity_images',
                    'extension' => $file->getClientOriginalExtension(),
                ]);
            }
        }

        return response()->json(true, 200);
    }

    public function atividades(Request $request, $rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdse) não encontrado!');
        }

        $filters = $request->all();

        $datesPeriodoSearch = null;

        if (!empty($filters['period'])) {
            $datesPeriodoSearch = calculateDates(
                $filters['period'],
                $filters['start_at'],
                $filters['end_at']
            );
        }

        $atividades = $rdse->activities()
            ->where(function ($query) use ($filters) {
                if (!empty($filters['atividades']) && $filters['atividades'] != 'all') {
                    if ($filters['atividades'] == 'nao_execucao') {
                        $query->whereNull('execucao'); // Filtra apenas atividades com execução nula
                    } else if ($filters['atividades'] == 'execucao') {
                        $query->whereNotNull('execucao'); // Filtra atividades com execução preenchida
                    }
                }
            })


            ->where(function ($query) use ($datesPeriodoSearch) {
                if (!empty($datesPeriodoSearch)) {
                    if ($datesPeriodoSearch['start_at'] == $datesPeriodoSearch['end_at']) {
                        $query->whereDate('data', [$datesPeriodoSearch['start_at']]);
                    } else {
                        $query->whereBetween('data', [$datesPeriodoSearch['start_at'], $datesPeriodoSearch['end_at']]);
                    }
                }
            })

            ->where(function ($q) use ($filters) {

                if (isset($filters['hour']) && $filters['hour'] != 'all') {
                    $q->where(function ($query) use ($filters) {
                        $turno = $filters['hour'];

                        if ($turno === 'diurno') {
                            $query->whereTime('data_inicio', '>=', '07:00')
                                ->whereTime('data_inicio', '<', '19:00');
                        } elseif ($turno === 'noturno') {
                            // Turno noturno: das 19:40 às 06:00 (passando pela meia-noite)
                            $query->where(function ($subQuery) {
                                $subQuery->whereTime('data_inicio', '>=', '19:40')
                                    ->whereTime('data_inicio', '<=', '23:59')
                                    ->orWhereTime('data_inicio', '>=', '00:00')
                                    ->whereTime('data_inicio', '<', '06:00');
                            });
                        }
                    });
                }
            })
            ->orderBy('data', 'desc')->get();

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

    public function updateSigeoAt(Request $request, $rdseId)
    {
        $checked = $request->input('checked', null);

        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return response()->json('Object RDSE not found in scope', 404);
        }

        $rdse->sigeo_at = $checked  ? now() : null;
        $rdse->save();

        return new RdseResource($rdse);
    }
}
