<?php

namespace App\Http\Controllers\Painel\RDSE;

use App\Exports\MedicaoExport;
use App\Models\RSDE\Rdse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateRdse;
use App\Models\Equipe;
use App\Models\Obra;
use App\Models\ResbRequisicao;
use App\Models\RSDE\RdseActivity;
use App\Models\RSDE\RdseActivityItens;
use App\Models\RSDE\RdseServices;
use App\Models\RSDE\Resb;
use App\Services\Rdse\RdseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class RdseController extends Controller
{
    public function __construct(private Rdse $repository, private RdseService $rdseService) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        # $rdses = Rdse::all();
        $date = Carbon::now()->format('d/m/Y');

        $status = $request->has('status') ? $request->input('status') : ['pending'];

        [$date_to, $date_from] = $request->has('daterange') ? explode(' - ', $request->input('daterange')) : [null, null];

        $request->merge(['status' => $status, 'date_to' => $date_to, 'date_from' => $date_from]);

        $lotes = DB::table('rdses')
            ->select('lote')
            ->whereNotNull('lote')
            ->where('lote', '<>', '0')
            ->where('modelo', 0)
            ->groupBy('lote')
            ->get();

        return view('pages.painel.rdse.rdse.index', [
            'lotes' => $lotes
        ])->with($request->only('status', 'date_to', 'date_from'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function programacao(Request $request)
    {
        $date = Carbon::now()->format('d/m/Y');

        $year = $request->has('year') ? $request->input('year') : Carbon::now()->format('Y');
        $request->merge(['year' => $year]);

        $status = $request->has('status') ? $request->input('status') : ['pending'];

        [$date_to, $date_from] = $request->has('daterange') ? explode(' - ', $request->input('daterange')) : [null, null];

        $request->merge(['status' => $status, 'date_to' => $date_to, 'date_from' => $date_from]);

        $lotes = DB::table('rdses')
            ->select('lote')
            ->whereNotNull('lote')
            ->where('lote', '<>', '0')
            ->where('modelo', 0)
            ->groupBy('lote')
            ->get();

        return view('pages.painel.rdse.rdse.programacao', [
            'lotes' => $lotes,
            'year' => $year,
        ])->with($request->only('status', 'date_to', 'date_from', 'year'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StoreUpdateRdse $request)
    {
        $columns = $request->all();
        $columns['modelo'] = false;
        $columns['n_order'] = formatNameRDSE($columns['n_order']);

        $mes = $request->input('month_date');
        $ano = $request->input('year');
        $columns['month_date'] = Carbon::createFromFormat('Y-m-d', "$ano-$mes-01");

        $rdse = $this->repository->create($columns);

        /* TODO  */
        $rdseService = new RdseServices();
        $rdseService->rdse_id = $rdse->id;
        $rdseService->save();

        return redirect()
            ->route('rdse.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show($identify)
    {
        if (!$rdse = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('rdse.index')
                ->with('message', 'Registro não encontrado!');
        }

        $services = $rdse->services();

        if ($services->count() == 0) {
            $services->create();
        }

        $typeRdse = $rdse->type;
        $typeRdseArray = collect(config("admin.rdse.type"))->where('name', $typeRdse)->first();
        $priceUps = $typeRdseArray['value'];
        $codigoType = $typeRdseArray['codigo'];
        $rdseServices = $services->with('handswork')->get();
        $logs = $rdse->logs();

        $atividades = $rdse->activities()->with('equipe')->orderBy('data')->get();
        $itensResb = Resb::where('rdse_id', $rdse->id)->limit(1)->get();

        return view('pages.painel.rdse.rdse.show', [
            'rdse' => $rdse,
            'rdseServices' => $rdseServices,
            'priceUps' => $priceUps,
            'codigoType' => $codigoType,
            'logs' => $logs,
            'atividades' => $atividades,
            'equipes' => Equipe::all(),
            'itensResb' => $itensResb,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(StoreUpdateRdse $request,  $identify)
    {
        $columns = $request->all();
        $columns['n_order'] = formatNameRDSE($columns['n_order']);

        $mes = $request->input('month_date');
        $ano = $request->input('year');
        $columns['month_date'] = Carbon::createFromFormat('Y-m-d', "$ano-$mes-01");

        if (!$rdse = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('rdse.index')
                ->with('message', 'Registro não encontrado!');
        }

        $rdse->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    $id
     */
    public function destroy($id)
    {
        if (!$rdse = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('rdse.index')
                ->with('message', 'Registro (Rdsee) não encontrado!');
        }

        if ($rdse->status != 'pending') {
            return redirect()
                ->route('rdse.show', $rdse->id)
                ->with('error', 'Registro (Rdse) não pode ser deletado!');
        }

        $rdse->delete();

        return redirect()
            ->route('rdse.index')
            ->with('message', 'Deletado com sucesso');
    }

    public function updateStatus(Request $request, $status)
    {

        if ($status) {

            $rdsesByGroup = $request->input('rdses', false);

            if ($rdsesByGroup) {

                foreach ($rdsesByGroup as $type => $itens) {

                    Rdse::whereIn('id', $itens['itens'])->update([
                        'lote' => $itens['lote'] ?? 0,
                        'status' => $status
                    ]);

                    if (isset($itens['nf'])) {
                        for ($i = 0; $i < count($itens['itens']); $i++) {

                            $rdse = Rdse::where('id', $itens['itens'][$i])->first();

                            $rdse->nf = $itens['nf'][$i] ?? 0;
                            $rdse->date_nfe_at = return_format_date($itens['date'][$i], 'en');

                            if ($rdse->parcial_1 == 0) {
                                $dataAt = 'parcial_1_at';
                            }

                            if ($rdse->parcial_1 == 1) {
                                $dataAt = 'parcial_2_at';
                            }

                            if ($rdse->parcial_2 == 1) {
                                $dataAt = 'parcial_3_at';
                            }

                            $rdse->$dataAt = now();
                            $rdse->update();
                        }
                    }
                }
            }
            return redirect()
                ->route('rdse.index', ['status' => [$status]]);
        }

        return redirect()
            ->back()
            ->with('message', 'Selecione um status');
    }

    public function createRdseByObra(Request $request, $obraId)
    {
        $rdseId = $request->input('modelo', null);

        if (!$rdse = $this->repository->where('id', $rdseId)->with('services')->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdsee) não encontrado!');
        }

        if (!$obra = Obra::where('id', $obraId)->select('id')->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Obra) não encontrado!');
        }

        $new = $rdse->replicate();
        $new->modelo = false;
        $new->obra_id = $obra->id;
        $new->description = $obra->razao_social;
        $new->n_order = null;
        $new->solicitante = "Marcos";
        $new->at = date('Y-m-d');
        //save model before you recreate relations (so it has an id)
        $new->push();
        $new->save();

        //reset relations on EXISTING MODEL (this way you can control which ones will be loaded
        $new->relations = [];

        //load relations on EXISTING MODEL
        $new->load('services');

        //re-sync everything
        foreach ($rdse->getRelations() as $relation => $items) {
            foreach ($items as $item) {
                unset($item->id);
                $new->{$relation}()->create($item->toArray());
            }
        }

        return redirect()
            ->back()
            ->with('message', 'Criado com sucesso');
    }

    public function addPartialRdse(Request $request, $rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->with('services')->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdsee) não encontrado!');
        }

        if ($rdse->parcial_1 == 0) {
            $rdse->parcial_1 = 1;
        } else if ($rdse->parcial_2 == 0) {
            $rdse->parcial_2 = 1;
        } else if ($rdse->parcial_3 == 0) {
            $rdse->parcial_3 = 1;
        }

        $rdse->status = 'pending';
        $rdse->update();

        //$partialsCount = DB::table('rdse_services_partials')
        //    ->select('partial')
        //    ->where('rdse_id', $rdse->id)
        //    ->orderBy('partial', 'desc')->limit(1)->first();
        //
        //$partialCount = !empty($partialsCount) ? intval($partialsCount->partial) + 1 : 1;
        //
        //foreach ($rdse->services as $service) {
        //    $service->partials()->create([
        //        'rdse_id' => $rdse->id,
        //        'partial' => $partialCount
        //    ]);
        //}

        return redirect()
            ->back()
            ->with('message', 'Parcial Criado com sucesso');
    }

    public function duplicateRdse($rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->with('services')->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdsee) não encontrado!');
        }

        $new = $rdse->replicate();
        $new->modelo = false;
        $new->description = $rdse->description . '_copy' . $rdse->id;
        $new->n_order = $rdse->n_order . '_copy_' . $rdse->id;
        $new->solicitante = "Marcos";
        $new->at = date('Y-m-d');
        //save model before you recreate relations (so it has an id)
        $new->push();
        $new->save();

        //reset relations on EXISTING MODEL (this way you can control which ones will be loaded
        $new->relations = [];

        //load relations on EXISTING MODEL
        $new->load('services');

        //re-sync everything
        foreach ($rdse->getRelations() as $relation => $items) {
            foreach ($items as $item) {
                unset($item->id);
                $new->{$relation}()->create($item->toArray());
            }
        }

        return  redirect()
            ->route('rdse.show', $new->id)
            ->with('message', 'Duplicado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rdse  $identify
     */
    public function pdf(int $identify)
    {
        if (!$rdse = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('rdse.index')
                ->with('message', 'Registro não encontrado!');
        }

        $typeRdse = $rdse->type;
        $typeRdseArray = collect(config("admin.rdse.type"))->where('name', $typeRdse)->first();
        $priceUps = $typeRdseArray['value'];
        $codigoType = $typeRdseArray['codigo'];

        $rdseS = new RdseServices();
        $rdseS->setPreventAttrSet(false);
        $rdseServices = $rdseS->where('rdse_id', $rdse->id)->with('handswork')->get();


        //TODO
        $total = $rdseServices->sum(function ($service) {
            return clearNumber($service->preco)
                + clearNumber($service->p_preco1)
                + clearNumber($service->p_preco2)
                + clearNumber($service->p_preco3);
        });

        $totalEspera = $rdseServices->where('codigo_sap', 212)->sum(function ($service) {
            return clearNumber($service->preco);
        });
        $totalServico =  $total  - $totalEspera;
        $totalP1 = $rdseServices->sum(function ($service) {
            return clearNumber($service->preco);
        });
        $totalUps = $total / $priceUps;

        $totalP2 = $rdseServices->sum(function ($service) {
            return clearNumber($service->p_preco1);
        });

        $totalP3 = $rdseServices->sum(function ($service) {
            return clearNumber($service->p_preco2);
        });

        $totalP4 = $rdseServices->sum(function ($service) {
            return clearNumber($service->p_preco3);
        });

        return view('pages.painel.rdse.rdse.pdf', [
            'rdse' => $rdse,
            'rdseServices' => $rdseServices,
            'priceUps' => $priceUps,
            'codigoType' => $codigoType,

            'totalEspera' => $totalEspera,
            'totalServico' => $totalServico,
            'totalP1' => $totalP1,
            'total' => $total,
            'totalUps' => $totalUps,

            'totalP2' => $totalP2,
            'totalP3' => $totalP3,
            'totalP4' => $totalP4,
        ]);
    }

    public function updateLote(Request $request)
    {
        $loteUpdate = $request->input('alterLote');
        $loteName = $request->input('lote');

        Rdse::where('lote', $loteUpdate)->update([
            'lote' => $loteName,
        ]);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Pegar os lotes que existem naquele status
     *
     * @return \Illuminate\Http\Response
     */
    public function getLotesByStatus(Request $request)
    {
        $status = $request->input('status', null);
        $lotes = Rdse::select('lote')->where('status', $status)->groupBy('lote')->get('lotes');

        return  $lotes;
    }

    public function destroyPartialRdse($rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->with('services')->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdsee) não encontrado!');
        }

        if ($rdse->parcial_3 == 1) {
            $rdse->parcial_3 = 0;
        } else if ($rdse->parcial_2 == 1) {
            $rdse->parcial_2 = 0;
        } else if ($rdse->parcial_1 == 1) {
            $rdse->parcial_1 = 0;
        }

        $rdse->status = 'invoice';

        $rdse->update();

        return redirect()
            ->back()
            ->with('message', 'Parcial Deletada com sucesso');
    }

    public function addServiceByModel(Request $request, $rdseId)
    {
        $modelo = $request->input('modelo', null);

        if (!$rdse = $this->repository->where('id', $rdseId)->with('services')->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdsee) não encontrado!');
        }

        if (!$rdseModelo = $this->repository->where('id', $modelo)->where('modelo', 1)->with('services')->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdsee) Modelo não encontrado!');
        }

        //load relations on EXISTING MODEL
        $rdseModelo->load('services');

        //re-sync everything
        foreach ($rdseModelo->getRelations() as $relation => $items) {
            foreach ($items as $item) {
                unset($item->id);
                $rdse->{$relation}()->create($item->toArray());
            }
        }

        return redirect()
            ->back()
            ->with('message', 'Modelo puxado com sucesso');
    }

    public function AttServicesAll($rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdsee) não encontrado!');
        }

        $services = $rdse->services()->with('handswork')->get();

        $typeRdse = $rdse->type;
        $typeRdseArray = collect(config("admin.rdse.type"))->where('name', $typeRdse)->first();
        $priceUps = $typeRdseArray['value'];

        foreach ($services as $service) {
            $codigoSap = $service->codigo_sap;
            $qntMinutes = $service->minutos;
            $qntAtv = $service->qnt_atividade;
            $handsworkPrice = $service->handswork ?  $service->handswork->price_ups : 0;

            if (!empty($codigoSap) && $qntAtv != 0) {
                if ($codigoSap == '212') {
                    $conversion = $qntMinutes / 30;
                    $conversionInFloor = floor($conversion);
                    $price = ($handsworkPrice * $priceUps) * $conversionInFloor;
                } else {
                    $price = ($handsworkPrice * $priceUps) * $qntAtv;
                }

                if (isset($price)) {
                    $service->update([
                        'preco' => clearNumber($price)
                    ]);
                }
            }
        }

        return redirect()
            ->back()
            ->with('message', 'Serviços atualizados com sucesso');
    }

    public function excel($rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdsee) não encontrado!');
        }

        $services = DB::select('SELECT
             handsworks.code,
            rdse_services.description,
            handsworks.price_ups,
            rdse_services.qnt_atividade,

            rdse_services.p_quantidade1,
            rdse_services.p_quantidade2,
            rdse_services.p_quantidade3,

            rdse_services.p_preco1,
            rdse_services.p_preco2,
            rdse_services.p_preco3

            FROM rdse_services

            INNER JOIN handsworks on handsworks.id = rdse_services.codigo_sap
            where rdse_services.rdse_id = ?
            ;', [$rdse->id]);

        $services = collect($services);

        return Excel::download(new MedicaoExport($services), slug($rdse->n_order, '_') . '.xlsx');
    }

    public function storeAtividade(Request $request, $rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdse) não encontrado!');
        }

        $this->rdseService->adicionarAtividade($request, $rdse);

        return redirect()
            ->route('rdse.show', $rdse->id)
            ->with('message', 'Criado com sucesso');
    }

    public function showAtividade(Request $request, $atividadeId)
    {
        if (!$rdseAtividade = RdseActivity::where('id', $atividadeId)->with('atividades', 'atividades.handswork')->first()) {
            return redirect()
                ->route('rdse.programacao.index')
                ->with('message', 'Registro (Rdse) não encontrado!');
        }

        $itens = $rdseAtividade->atividades;

        return view('pages.painel.rdse.rdse.atividade.show', [
            'rdseAtividade' => $rdseAtividade,
            'equipes' => Equipe::all(),
            'itens' => $itens,
        ]);
    }

    public function updateAtividade(Request $request, $atividadeId)
    {
        $request->merge([
            'data' => Carbon::createFromFormat('d/m/Y', $request->input('data'))->format('Y-m-d'),
        ]);

        if (!$rdseAtividade = RdseActivity::where('id', $atividadeId)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdse) não encontrado!');
        }

        $this->rdseService->atualizarAtividade($request, $rdseAtividade);

        return redirect()
            ->route('rdse.atividades.show', $rdseAtividade->id)
            ->with('message', 'Atualizado com sucesso');
    }

    public function rsbeNovaRequisicao(Request $request, $rdseId)
    {
        if (!$rdse = Rdse::where('id', $rdseId)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdse) não encontrado!');
        }

        $itensResb = Resb::where('rdse_id', $rdse->id)->get();

        $ultimaRequisicaoIndex = ResbRequisicao::where('rdse_id', $rdse->id)->max('unique');
        $novoRequisicaoIndex = is_null($ultimaRequisicaoIndex) ? 1 : $ultimaRequisicaoIndex + 1;

        foreach ($itensResb as $item) {

            ResbRequisicao::create([
                'user_id' => auth()->user()->id,
                'item_id' => $item->item_id,
                'resb_id' => $item->id,
                'rdse_id' => $rdse->id,
                'at' => now(),
                'unique' => $novoRequisicaoIndex,
            ]);
        }

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    public function rsbe(Request $request, $rdseId)
    {
        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdse) não encontrado!');
        }

        $requisicoes = ResbRequisicao::where('rdse_id', $rdse->id)->get();
        $requisicoesAgrupadas = $requisicoes->groupBy('unique');
        $qntRequisicao = $requisicoes->count();

        $type = $request->query('type', 'enel');

        $columns = ['#', 'Cód. Mat', 'UND', 'Descrição', 'Quant. Plan'];

        if ($type === 'viabilidade') {
            $columns[] = 'Quant. Viabilidade';

            if ($qntRequisicao > 0) {
                foreach ($requisicoesAgrupadas as $unique => $value) {
                    $columns[] = 'Requisição: ' . '<br>' . $value->where('unique', $unique)->first()?->at;
                    $columns[] = 'Execução: ';
                    $columns[] = 'Total: ';
                }
            }
        }

        $itensResb = Resb::where('rdse_id', $rdse->id)->get();

        $rows = [];

        if ($itensResb->isNotEmpty()) {
            #$columns = ['#', 'Cód. Mat', 'UND', 'Descrição', 'Quant. Plan'];

            foreach ($itensResb as $item) {
                $row = [
                    $item->id,
                    $item->inventory->cod_material,
                    $item->inventory->unit,
                    $item->inventory->name,
                    $item->qnt_planejada,
                ];

                if ($type === 'viabilidade') {
                    $row[] = $item->qnt_viabilidade;

                    foreach ($requisicoes->groupBy('unique') as $unique => $value) {
                        $values =  $value->where('unique', $unique);

                        $itemReq = $values->where('resb_id', $item->id)->first();

                        $row[] = $itemReq?->qnt;
                        $row[] = $itemReq?->qnt_executada;
                        $row[] = 'total';
                    }
                }

                $rows[] = $row;
            }
        } else {

            $row = [
                '',
                '',
                '',
                '',
                '',
            ];

            if ($type === 'viabilidade') {
                $row[] = '';
            }

            $rows[] = $row;
        }

        return view('pages.painel.rdse.rdse.rsbe.rsbe_executavel', [
            'rdse' => $rdse,
            'columns' => $columns,
            'rows' => $rows,
            'type' => $type,
            'itensResb' => $itensResb,
        ]);
    }

    public function rsbeSave(Request $request, $rdseId)
    {
        $col = $request->input('col', 'resb_enel');

        if (!empty($col)) {
            if (!$rdse = Rdse::where('id', $rdseId)->first()) {
                return redirect()
                    ->back()
                    ->with('message', 'Registro (Rdse) não encontrado!');
            }

            $rdse->$col  = now();
            $rdse->resb_status = str_replace('resb_', '', $col);
            $rdse->save();
        }

        return redirect()->back();
    }

    public function rsbeReset(Request $request, $rdseId)
    {
        if (!$rdse = Rdse::where('id', $rdseId)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro (Rdse) não encontrado!');
        }

        $rdse->resbs()->delete();

        $rdse->resb_enel = null;
        $rdse->resb_viabilidade = null;
        $rdse->resb_execucao = null;
        $rdse->resb_status = null;
        $rdse->save();

        return redirect()->back();
    }
}
