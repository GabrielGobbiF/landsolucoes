<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\Pasta;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentosController extends Controller
{
    protected $repository;


    public function __construct(Documento $documentos)
    {
        $this->middleware('auth');

        $this->repository = $documentos;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directorys = Pasta::whereNull('folder_childer')->get(); #Storage::disk('local')->directories('00tR9vps6D');

        $documentos = Documento::whereNull('folder')->get();

        return view('pages.painel.obras.arquivos.index', [
            'directorys' => $directorys,
            'documentos' => $documentos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->input('folder_childer')) {
            $idPasta = $request->input('folder_childer');
            if (!$pasta = Pasta::where('uuid', $idPasta)->first()) {
                return redirect()
                    ->route('obras.index')
                    ->with('message', 'Registro não encontrado!');
            }
        }

        $redirect = isset($pasta) ?  route('folder.show', $pasta->uuid) : route('arquivos.index');

        foreach ($request->file as $docFile) {

            if ($docFile->isValid()) {

                $fileName = $docFile->getClientOriginalName();
                $fileExt = $docFile->getClientOriginalExtension();
                $token = uniqid(((date('s') / 12) * 24) + mt_rand(800, 9999));

                $pastaName = isset($pasta) ? $pasta->url . '/' : '';
                $docFile->move(storage_path("app/public/$pastaName"), $token . '.' . $fileExt);

                $columns = [
                    'name' => str_replace('.' . $fileExt, '', $fileName),
                    'url' => "storage/$pastaName$token.$fileExt",
                    'slug' => Str::slug(mb_strtolower(str_replace('.' . $fileExt, '', $fileName), 'UTF-8'), '_'),
                    'ext' => $fileExt,
                    'folder' => isset($pasta) ? $pasta->uuid : null
                ];

                $this->repository->create($columns);
            }
        }


        return response()->json(['redirect' => $redirect]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\teste  $pasta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$documento = $this->repository->find($id)) {
            return redirect()
                ->route('testes')
                ->with('message', 'Registro não encontrado!');
        }

        Storage::delete(str_replace('storage/', '', $documento->url));

        $documento->delete();

        return redirect()
            ->back()
            ->with('message', 'Deletado com sucesso!');
    }
}
