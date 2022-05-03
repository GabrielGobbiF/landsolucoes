<?php

namespace App\Http\Controllers\Painel\RDSE;

use App\Models\RSDE\Rdse;
use App\Http\Controllers\Controller;
use App\Models\Obra;
use App\Models\RSDE\RdseServices;
use Illuminate\Http\Request;

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

        $status = $request->has('status') ? $request->input('status') : 'pending';

        $request->merge(['status' => $status]);

        return view('pages.painel.rdse.rdse.index', [
            #'rdses' => $rdses
        ])->with($request->only('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $priceUps = collect(config("admin.rdse.type"))->where('name', $typeRdse)->first()['value'];

        $rdseServices = $rdse->services()->with('handswork')->get();

        return view('pages.painel.rdse.rdse.show', [
            'rdse' => $rdse,
            'rdseServices' => $rdseServices,
            'priceUps' => $priceUps
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rdse  $identify
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $identify)
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

        $rdse->delete();

        return redirect()
            ->route('rdse.index')
            ->with('message', 'Deletado com sucesso');
    }

    public function updateStatus(Request $request, $status)
    {
        $ids = $request->only('medicoes', false);

        if ($ids) {
            Rdse::whereIn('id', $ids['medicoes'])->update(['status' => $status]);
        }

        return redirect()
            ->route('rdse.index', ['status' => $status]);
    }

    public function createRdseByObra(Request $request, $obraId)
    {
        $rdseId = $request->input('modelo', null);

        if (!$rdse = $this->repository->where('id', $rdseId)->first()) {
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
        //save model before you recreate relations (so it has an id)
        $new->push();

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
}
