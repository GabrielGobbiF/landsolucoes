<?php

namespace App\Http\Controllers\Painel\RDSE;

use App\Models\RSDE\Rdse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateRdse;
use App\Models\Obra;
use App\Models\RSDE\RdseServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RdseController extends Controller
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
        # $rdses = Rdse::all();
        $date = Carbon::now()->format('d/m/Y');

        $status = $request->has('status') ? $request->input('status') : 'pending';
        [$date_to, $date_from] = $request->has('daterange') ? explode(' - ', $request->input('daterange')) : [null, null];

        $request->merge(['status' => $status, 'date_to' => $date_to, 'date_from' => $date_from]);

        #dd([$date_to, $date_from]);

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateRdse $request)
    {
        $columns = $request->all();
        $columns['modelo'] = false;

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
     *
     * @param  \App\Models\Rdse  $identify
     * @return \Illuminate\Http\Response
     */
    public function show(int $identify)
    {
        if (!$rdse = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('rdse.index')
                ->with('message', 'Registro não encontrado!');
        }

        if ($rdse->services()->count() == 0) {
            $rdse->services()->create();
        }

        $typeRdse = $rdse->type;
        $typeRdseArray = collect(config("admin.rdse.type"))->where('name', $typeRdse)->first();
        $priceUps = $typeRdseArray['value'];
        $codigoType = $typeRdseArray['codigo'];

        $rdseServices = $rdse->services()->with('handswork', 'partials')->get();

        return view('pages.painel.rdse.rdse.show', [
            'rdse' => $rdse,
            'rdseServices' => $rdseServices,
            'priceUps' => $priceUps,
            'codigoType' => $codigoType
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rdse  $identify
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateRdse $request, int $identify)
    {
        $columns = $request->all();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
        $rdsesByGroup = $request->input('rdses', false);

        if ($rdsesByGroup) {

            foreach ($rdsesByGroup as $type => $itens) {

                Rdse::whereIn('id', $itens['itens'])->update([
                    'lote' => $itens['lote'] ?? 0,
                    'status' => $status
                ]);

                if (isset($itens['nf'])) {
                    for ($i = 0; $i < count($itens['itens']); $i++) {
                        Rdse::where('id', $itens['itens'][$i])->update([
                            'nf' => $itens['nf'][$i] ?? 0,
                            'date_nfe_at' => return_format_date($itens['date'][$i], 'en'),
                        ]);
                    }
                }
            }
        }

        return redirect()
            ->route('rdse.index', ['status' => $status]);
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
     * @return \Illuminate\Http\Response
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
        ]);
    }
}
