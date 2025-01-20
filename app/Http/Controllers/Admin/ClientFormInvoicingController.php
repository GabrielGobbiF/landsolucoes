<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClientFormInvoicing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientFormInvoicingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $clientFormInvoicings = ClientFormInvoicing::all();

        return view('pages.painel.clientFormInvoicings.index', [
            'clientFormInvoicings' => $clientFormInvoicings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateClientFormInvoicing $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('clientFormInvoicings.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientFormInvoicing  $identify
     * @return \Illuminate\Http\Response
     */
    public function show(int $identify)
    {
        if (!$clientFormInvoicing = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('clientFormInvoicings.index')
                ->with('message', 'Registro não encontrado!');
        }

        return view('admin.clientFormInvoicings.show', [
            'clientFormInvoicing' => $clientFormInvoicing,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientFormInvoicing  $identify
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateClientFormInvoicing $request, int $identify)
    {
        $columns = $request->all();

        if (!$clientFormInvoicing = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('clientFormInvoicings.index')
                ->with('message', 'Registro não encontrado!');
        }

        $clientFormInvoicing->update($columns);

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
        if (!$clientFormInvoicing = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('clientFormInvoicings.index')
                ->with('message', 'Registro (ClientFormInvoicinge) não encontrado!');
        }

        $clientFormInvoicing->delete();

        return redirect()
            ->route('clientFormInvoicings.index')
            ->with('message', 'Deletado com sucesso');
    }
}
