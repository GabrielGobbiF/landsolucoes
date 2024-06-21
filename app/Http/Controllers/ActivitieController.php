<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateClient;
use App\Models\Client;
use App\Services\ClientService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivitieController extends Controller
{

    public function __construct()
    {
        #$this->middleware('permission:clients');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        #$clientCount = Client::count();

        return view('admin.clients.index', [
            #'clients' => $this->clientService->getClients(),
            #'clientCount' => $clientCount,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastClients = Client::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.clients.create', [
            'lastClients' => $lastClients
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreUpdateClient $request)
    {
        $client = $this->clientService->store($request->validated());

        return redirect()
            ->route('admin.clients.show', $client->id)
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $adresses = $client->addresses()->paginate();

        $startAt = Carbon::now()->startOfMonth()->format('d/m/Y');

        $endAt = Carbon::now()->endOfMonth()->format('d/m/Y');

        return view('admin.clients.show', [
            'client' => $client,
            'adresses' => $adresses,
            'startAt' => $startAt,
            'endAt' => $endAt,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateClient $request, Client $client)
    {
        $this->clientService->update($client, $request->validated());

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $this->clientService->delete($client);

        return redirect()
            ->route('admin.clients.index')
            ->with('message', 'Deletado com sucesso');
    }
}
