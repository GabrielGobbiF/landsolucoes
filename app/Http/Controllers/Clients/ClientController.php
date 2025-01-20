<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateClient;
use App\Models\Client;
use App\Models\ClientFormInvoicing;
use App\Models\Obra;
use App\Models\Pasta;
use App\Models\Tipo;
use Illuminate\Http\Request;


class ClientController extends Controller
{
    protected $repository;

    public function __construct(Client $cliente)
    {
        $this->repository = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->all();

        $client = auth()->guard('clients')->user()->id;

        $obras = Obra::where('client_id', $client)
            ->where('status', 'aprovada')
            ->where(function ($query) use ($filters) {
                if (isset($filters['search']) && $filters['search'] != '') {
                    $query->orWhere('last_note', 'LIKE', '%' . $filters['search'] . '%');
                    $query->orWhere('razao_social', 'LIKE', '%' . $filters['search'] . '%');
                }
            })
            ->with('concessionaria')
            ->with('client')
            ->with('service')
            ->orderBy('id')
            ->get();

        return view('pages.clients.index', compact(
            'obras',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = auth()->guard('clients')->user()->id;

        if (!$obra = Obra::where('client_id', $client)->with('address')->with('client')->find($id)) {
            return redirect()
                ->back()
                ->with('message', 'Registro não encontrado!');
        }

        $tipos  = Tipo::all();
        $address  = $obra->address;

        $clientsDepartaments = $obra->client->departments()->get();
        $department_id = $obra->department_id;
        $obraDepartamentoCliente = null;
        if ($department_id) {
            $obraDepartamentoCliente = $clientsDepartaments->where('id', $department_id)->first();
        }

        $pastas = Pasta::where('type_id', $obra->id)->where('type', 'obras')->get();

        $pastaPadrao = file_get_contents(asset('storage/00tR9vps6D/jsons/pastas.json'));
        $pastaPadrao = json_decode($pastaPadrao, true);

        for ($i = 0; $i < count($pastaPadrao); $i++) {
            foreach ($pastas as $p) {
                if (isset($pastaPadrao[$i]) && minusculo($pastaPadrao[$i]['nome_pasta']) == minusculo($p->name)) {
                    unset($pastaPadrao[$i]);
                }
            }
        }

        return view('pages.clients.show', [
            'obra' => $obra,
            'clientsDepartaments' => $clientsDepartaments,
            'obraDepartamentoCliente' => $obraDepartamentoCliente,
            'tipos' => $tipos,
            'address' => $address,
            'pastas' => $pastas,
            'pastaPadrao' => $pastaPadrao
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateClient $request, $uuid)
    {
        $columns = $request->all();

        if (!$client = $this->repository->where('uuid', $uuid)->first()) {
            return redirect()
                ->route('clients.index')
                ->with('message', 'Registro não encontrado!');
        }

        $client->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $uuid
     */
    public function destroy($uuid)
    {
        if (!$client = $this->repository->where('uuid', $uuid)->first()) {
            return redirect()
                ->route('clients.index')
                ->with('message', 'Registro não encontrado!');
        }

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('message', 'Excluir com sucesso!');
    }

    public function showInvoicingForm(Request $request)
    {
        return view('web.form-invoicing');
    }

    public function storeInvoicingForm(Request $request)
    {
        $created = ClientFormInvoicing::create($request->all());

        if ($request->hasFile('upload')) {
            foreach ($request->file('upload') as $file) {
                // Gera o caminho e salva o arquivo
                $filePath = $file->store('uploads', 'public');
                $fileHash = md5_file($file->getRealPath());

                // Salva no banco de dados
                $created->uploads()->create([
                    'user_id' => auth()->id(),
                    'name' => $file->getClientOriginalName(),
                    'file_name' => basename($filePath),
                    'mime_type' => $file->getMimeType(),
                    'path' =>  $filePath,
                    'disk' => 'public',
                    'file_hash' => $fileHash,
                    'collection' => 'client_form_invoicing',
                    'extension' => $file->getClientOriginalExtension(),
                ]);
            }
        }

        return redirect()
            ->route('clients.form.invoicing')
            ->with('message', 'Criado com sucesso!');
    }
}
