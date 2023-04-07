<?php

namespace App\Http\Controllers\Painel\EPI;

use App\Models\RSDE\Handswork;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEpi;
use App\Models\Epi;
use Illuminate\Http\Request;

class EpiController extends Controller
{
    protected $repository;

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.painel.epi.index', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateEpi $request)
    {
        $epi = Epi::create($request->validated());

        return redirect()->route('epi.index')
            ->with('message', __trans('Created Success'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!$epi = Epi::where('id', $id)->first()) {
            return redirect()
                ->route('epi.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.epi.show', [
            'epi' => $epi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateEpi $request, $id)
    {
        if (!$epi = Epi::where('id', $id)->first()) {
            return redirect()
                ->route('epi.index')
                ->with('message', 'Registro não encontrado!');
        }

        $epi->update($request->validated());

        return back()->with('message', __trans('Updated Success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!$epi = Epi::where('id', $id)->first()) {
            return redirect()
                ->route('epi.index')
                ->with('message', 'Registro não encontrado!');
        }

        $epi->delete();

        return back()->with('message', __trans('Deleted Success'));
    }
}
