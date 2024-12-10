<?php

namespace App\Http\Controllers\Painel\Obras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentosResource;
use App\Models\Documento;
use App\Models\Pasta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;
use File as File;

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
    public function index(Request $request)
    {
        $directorys = Pasta::where(function ($query) use ($request) {
            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%');
            } else {
                $query->whereNull('folder_childer');
            }
        })->whereNull('type')->withCount('documentos')->orderBy('name', 'ASC')->paginate(30, ['*'], 'pastas'); #Storage::disk('local')->directories('00tR9vps6D');

        $obrasPastas = Pasta::where(function ($query) use ($request) {
            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%');
            } else {
                $query->whereNull('folder_childer');
            }
        })->where('type', 'obras')->withCount('documentos')->orderBy('name', 'ASC')->paginate(30, ['*'], 'obras');

        $documentos = Documento::where(function ($query) use ($request) {
            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%');
                $query->orWhere('ext', 'like', '%' . $request->search . '%');
            }
        })->orderBy('id', 'DESC')->limit(!$request->search ? 4 : null)->get();

        return view('pages.painel.obras.arquivos.index', [
            'directorys' => $directorys,
            'documentos' => $documentos,
            'obrasPastas' => $obrasPastas
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function favorites(Request $request)
    {
        $documentos = auth()->user()->filesFavorites()->where(function ($query) use ($request) {
            if ($request->search) {
                $query->orWhere('name', 'like', '%' . $request->search . '%');
                $query->orWhere('ext', 'like', '%' . $request->search . '%');
                $query->orWhere('uuid',  $request->search);
            }
        })->orderBy('id', 'DESC')->get();

        return view('pages.painel.obras.arquivos.favorites', [
            'documentos' => $documentos
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
     * Update the specified resource from storage.
     *
     * @param  \App\Models\teste  $pasta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $columns = $request->all();

        if (!$documento = $this->repository->where('uuid', $id)->first()) {
            return redirect()
                ->route('arquivos.index')
                ->with('message', 'Registro não encontrado!');
        }

        $documento->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Alterado com sucesso!');
    }

    /**
     * Move the specified resource from storage.
     *
     * @param  \App\Models\teste  $pasta
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request, $id)
    {
        $folder = $request->input('folder_move');

        if ($folder) {

            if (!$documento = $this->repository->where('uuid', $id)->first()) {
                return redirect()
                    ->back()
                    ->with('message', 'Registro não encontrado!');
            }

            if (!$folder = Pasta::where('uuid', $folder)->first()) {
                return redirect()
                    ->back()
                    ->with('message', 'Registro não encontrado!');
            }

            $url = explode('storage/', $documento->url);
            $url = $url[1] ?? $url[0];

            if (Storage::exists(($url))) {
                Storage::move($url, $folder->url . '/' . $documento->uuid . '.' . $documento->ext);
                $documento->url =  'storage/' . $folder->url . '/' . $documento->uuid . '.' . $documento->ext;
                $documento->folder = $folder->uuid;
                $documento->save();
                $documento->update();
            }

            return redirect()
                ->back()
                ->with('message', 'Movido com sucesso!');
        }

        return redirect()
            ->back()
            ->with('error', 'Não Autorizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\teste  $pasta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$documento = $this->repository->where('uuid', $id)->first()) {
            return redirect()
                ->back()
                ->with('message', 'Registro não encontrado!');
        }

        #Storage::delete(str_replace('storage/', '', $documento->url));

        $documento->delete();

        return redirect()
            ->back()
            ->with('message', 'Deletado com sucesso!');
    }

    public function favorite(Request $request)
    {
        auth()->user()->filesFavorites()->attach($request->file_id);
        return response(['fav'], 200);
    }

    public function unfavorite(Request $request)
    {
        auth()->user()->filesFavorites()->detach($request->file_id);
        return response(['unfav'], 200);
    }

    public function download(Request $request)
    {
        $files = $request->input('files');
        $files = json_decode($files, true);

        $values = array_map(function ($files) {
            return $files['id'];
        }, $files);

        $files = Documento::whereIn('id', $values)->get();

        $zip = new ZipArchive;

        Storage::delete("00tR9vps6D/arquivos.zip");

        $zip->open(storage_path("app/public/00tR9vps6D/arquivos.zip"), ZipArchive::CREATE);

        foreach ($files as $file) {
            $local = str_replace('storage/', '', $file->url);
            if (Storage::has($local)) {
                $zip->addFile(storage_path("app/public/$local"), $file->name . '.' . $file->ext);
            }
        }

        $zip->close();

        return response()->download(storage_path("app/public/00tR9vps6D/arquivos.zip"));
    }
}
