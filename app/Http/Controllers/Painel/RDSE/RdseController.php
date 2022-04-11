<?php

namespace App\Http\Controllers\Painel\RDSE;

use App\Models\RSDE\Rdse;
use App\Http\Controllers\Controller;
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
}
