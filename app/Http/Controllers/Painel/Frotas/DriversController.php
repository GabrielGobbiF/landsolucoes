<?php

namespace App\Http\Controllers\Painel\Frotas;

use App\Http\Requests\Frotas\StoreUpdateDriver;
use App\Models\Driver;
use App\Http\Controllers\Controller;
use App\Supports\Enums\Frota\DriversStatus;
use Illuminate\Http\Request;

class DriversController extends Controller
{
    public function __construct(protected Driver $repository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $drivers = Driver::all();

        return view('pages.painel.frotas.drivers.index', [
            'drivers' => $drivers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreUpdateDriver $request)
    {
        $this->repository->create($request->validated());

        return redirect()
            ->route('drivers.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $identify
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(int $identify)
    {
        if (!$driver = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('drivers.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.frotas.drivers.show', [
            'driver' => $driver,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $identify
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function update(StoreUpdateDriver $request, int $identify)
    {
        $columns = $request->all();

        if (!$drivers = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('drivers.index')
                ->with('message', 'Registro não encontrado!');
        }

        $drivers->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (!$drivers = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('drivers.index')
                ->with('message', 'Registro (Driver) não encontrado!');
        }

        $drivers->delete();

        return redirect()
            ->route('drivers.index')
            ->with('message', 'Deletado com sucesso');
    }
}
