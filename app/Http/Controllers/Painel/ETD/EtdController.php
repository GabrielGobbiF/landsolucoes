<?php

namespace App\Http\Controllers\Painel\ETD;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEtd;
use App\Models\Etd;
use Illuminate\Http\Request;

class EtdController extends Controller
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
        return view('pages.painel.etd.index', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateEtd $request)
    {
        $etd = Etd::create($request->validated());

        return redirect()->route('etd.index')
            ->with('message', __trans('Created Success'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!$etd = Etd::where('id', $id)->first()) {
            return redirect()
                ->route('etd.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('pages.painel.etd.show', [
            'etd' => $etd,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateEtd $request, $id)
    {
        if (!$etd = Etd::where('id', $id)->first()) {
            return redirect()
                ->route('etd.index')
                ->with('message', 'Registro não encontrado!');
        }

        $etd->update($request->validated());

        return back()->with('message', __trans('Updated Success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!$etd = Etd::where('id', $id)->first()) {
            return redirect()
                ->route('etd.index')
                ->with('message', 'Registro não encontrado!');
        }

        $etd->delete();

        return back()->with('message', __trans('Deleted Success'));
    }
}
