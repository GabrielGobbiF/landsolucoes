<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateInventory;
use App\Imports\InventoryImport;
use App\Models\Inventory;
use App\Services\InventoryService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

class InventarioController extends Controller
{
    public function __construct(private InventoryService $inventoryService)
    {
        #$this->middleware('permission:itens');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        #$inventoryCount = Inventory::count();

        return view('pages.painel.rdse.inventario.index', [
            #'inventories' => Inventory::paginate(),
            #'inventoryCount' => $inventoryCount,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastInventorys = Inventory::orderBy('created_at', 'desc')->limit(5)->get();

        return view('pages.painel.rdse.inventario.create', [
            'lastInventorys' => $lastInventorys
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreUpdateInventory $request)
    {
        $inventory = $this->inventoryService->store($request->validated());

        return redirect()
            ->route('inventories.show', $inventory->id)
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        #$images = $inventory->images()->get();

        return view('pages.painel.rdse.inventario.show', [
            'inventory' => $inventory,
            #'images' => $images,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateInventory $request, Inventory $inventory)
    {
        $this->inventoryService->update($inventory, $request->validated());

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        throw_if(
            !$inventory->canDelete(),
            ValidationException::withMessages(['message' => 'Não é possivel deletar'])
        );

        $inventory->delete();

        return redirect()
            ->route('pages.painel.rdse.inventario.index')
            ->with('message', 'Deletado com sucesso');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new InventoryImport, $request->file('file'));

        return redirect()
            ->route('pages.painel.rdse.inventario.index')
            ->with('message', 'Importado com sucesso');
    }
}
