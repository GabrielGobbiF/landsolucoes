<?php

namespace App\Http\Controllers;

use App\Exports\AtividadesExport;
use App\Http\Controllers\Controller;
use App\Models\RSDE\RdseActivity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RdseActivityController extends Controller
{
    protected $repository;

    public function __construct(RdseActivity $rdseActivitys)
    {
        $this->repository = $rdseActivitys;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $rdseActivitys = RdseActivity::all();

        return view('admin.rdseActivitys.index', [
            'rdseActivitys' => $rdseActivitys
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('rdseActivitys.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(int $identify)
    {
        if (!$rdseActivity = $this->repository->with('activities')->where('id', $identify)->first()) {
            return redirect()
                ->route('rdseActivitys.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('admin.rdseActivitys.show', [
            'rdseActivity' => $rdseActivity,
            'rdseActivityHistory' => $rdseActivity->activities,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request, int $identify)
    {
        $columns = $request->all();

        if (!$rdseActivity = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('rdseActivitys.index')
                ->with('message', 'Registro não encontrado!');
        }

        $rdseActivity->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        if (!$rdseActivity = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('rdseActivitys.index')
                ->with('message', 'Registro (RdseActivitye) não encontrado!');
        }

        $rdseActivity->delete();

        return redirect()
            ->route('rdseActivitys.index')
            ->with('message', 'Deletado com sucesso');
    }

    public function export(Request $request)
    {
        $request->validate([
            'period' => 'required',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $datesPeriodoSearch = calculateDates(
            $request->input('period'),
            $request->input('start_at'),
            $request->input('end_at'),
        );

        // Filtra as atividades com base nas datas
        $atividades = RdseActivity::query()
            ->join('rdses', 'rdse_activities.rdse_id', '=', 'rdses.id')
            ->join('equipes', 'rdse_activities.equipe_id', '=', 'equipes.id')
            ->join('supervisores', 'rdse_activities.supervisor_id', '=', 'supervisores.id')
            ->join('vehicles', 'rdse_activities.veiculo_id', '=', 'vehicles.id')
            ->join('encarregados', 'rdse_activities.encarregado_id', '=', 'encarregados.id')
            ->select([
                'data',
                'supervisores.name as supervisor_name',
                'vehicles.name as vehicle_name',
                'equipes.name as equipe_name',
                'encarregados.name as encarregado_name',
                'rdses.diretoria',
                'rdses.description',
                'rdses.n_order',
                'rdse_activities.atividades',
            ])
            ->where(function ($query) use ($datesPeriodoSearch) {
                if (!empty($datesPeriodoSearch)) {
                    $query->whereBetween('data', [$datesPeriodoSearch['start_at'], $datesPeriodoSearch['end_at']]);
                }
            })
            ->get()->toArray();


        // Gera o arquivo Excel com as atividades filtradas
        return Excel::download(new AtividadesExport($atividades), 'atividades.xlsx');
    }
}
