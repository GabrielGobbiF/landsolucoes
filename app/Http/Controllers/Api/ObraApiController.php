<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEtapaObra;
use App\Models\Obra;
use Illuminate\Http\Request;

class ObraApiController extends Controller
{
    protected $repository, $obra;

    public function __construct(Obra $obra)
    {
        $this->obra = $obra;
    }

    public function update(StoreUpdateEtapaObra $request, $obra_id)
    {
        $columns = $request->all();

        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $obra->update([
            $columns['collumn'] => $columns['value']
        ]);

        return $obra->id;
    }

    public function documents(Request $request, int $obraId)
    {
        if (!$obra = $this->obra->where('id', $obraId)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        $pasta = $obra->pasta()->first() ?? false;

        $pasta = $pasta ? $pasta->childrens() : [];

        $returnHTML = view('pages.painel.obras.obras.documentos.index')
            ->with('pasta', $pasta)
            ->render();

        return response()->json($returnHTML  ?? [], 200);
    }
}
