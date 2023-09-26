<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Celular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class CelularesController extends Controller
{
    public function __construct(private Celular $repository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.painel.celulares.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $columns = $request->all();

        $this->repository->create($columns);

        return redirect()
            ->route('celulares.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Celular  $identify
     * @return \Illuminate\Http\Response
     */
    public function show(int $identify)
    {
        if (!$celular = $this->repository->with('files')->where('id', $identify)->first()) {
            return redirect()
                ->route('celulares.index')
                ->with('message', 'Registro não encontrado!');
        }

        $files = $celular->files;

        return view('pages.painel.celulares.show', [
            'celular' => $celular,
            'files' => $files
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Celular  $identify
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $identify)
    {
        $columns = $request->all();

        if (auth()->user()->id == '5') {
            if (!$celular = $this->repository->where('id', $identify)->first()) {
                return redirect()
                    ->route('celulares')
                    ->with('message', 'Registro não encontrado!');
            }

            $celular->update($columns);
        }

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
        $this->middleware('auth');

        $this->middleware('role:admin');

        if (!$celular = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('celulares.index')
                ->with('message', 'Registro C não encontrado!');
        }

        $celular->delete();

        return redirect()
            ->route('celulares.index')
            ->with('message', 'Deletado com sucesso');
    }

    public function file(Request $request, $identify)
    {
        if (!$celular = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('celulares')
                ->with('message', 'Registro não encontrado!');
        }

        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()); // a unique file name

            $disk = Storage::disk('public');
            $name = $fileName;
            $path = $disk->putFileAs('celulares', $file, $file->getClientOriginalName());
            $token = md5(time());
            $fileHash = sha1_file($file->path());

            $celular->files()->create(
                [
                    'name' => slug("{$name}"),
                    'token' => $token,
                    'file_name' => ($file->getClientOriginalName()),
                    'mime_type' => $file->getClientMimeType(),
                    'path' =>  $path,
                    'disk' => 'public',
                    'file_hash' => $fileHash,
                    'collection' => $request->get('collection'),
                    'size' => $file->getSize(),
                    'observations' => null
                ]
            );

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => asset('storage/' . $path),
                'filename' => $fileName
            ];
        }

        // otherwise return percentage information
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }

    public function fileDelete($celularId, $fileToken)
    {
        if (!$celular = $this->repository->where('id', $celularId)->first()) {
            return redirect()
                ->route('celulares')
                ->with('message', 'Registro não encontrado!');
        }

        if (auth()->user()->id == '5') {

            if (!$file = $celular->files()->where('token', $fileToken)->first()) {
                return redirect()
                    ->route('celulares')
                    ->with('message', 'Registro arquivo não encontrado!');
            }

            if (Storage::disk('public')->exists($file->getRawOriginal('path'))) {
                Storage::disk('public')->delete($file->getRawOriginal('path'));
            }

            $file->delete();

            return redirect()
                ->route('celulares.show', $celular->id)
                ->with('message', 'Deletado com sucesso');
        }

        return redirect()
            ->route('celulares.show', $celular->id)
            ->with('error', 'Sem permissão');
    }
}
