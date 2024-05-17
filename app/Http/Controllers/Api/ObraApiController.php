<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEtapaObra;
use App\Models\Obra;
use App\Models\Pasta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $pasta = $obra->pasta()->orderBy('id', 'ASC')->first() ?? false;

        if ($pasta) {
            $docsPasta = $pasta->documentos()->get();
        } else {
            $url = '00tR9vps6D';
            $folder =  Pasta::create([
                'name' => $obra->razao_social,
                'type' => 'obras',
                'url' => '00tR9vps6D',
                'type_id' => $obra->id
            ]);
            Storage::makeDirectory($url . '/' . $folder->uuid);
        }

        $pasta = $pasta ? $pasta->childrens() : [];

        $returnHTML = view('pages.painel.obras.obras.documentos.index')
            ->with('pasta', $pasta)
            ->with('docsPasta', $docsPasta??[])
            ->with('obra', $obra)
            ->render();

        return response()->json($returnHTML  ?? [], 200);
    }
}
