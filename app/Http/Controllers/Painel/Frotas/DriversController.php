<?php

namespace App\Http\Controllers\Painel\Frotas;

use App\Http\Requests\Frotas\StoreUpdateDriver;
use App\Models\Driver;
use App\Http\Controllers\Controller;
use App\Supports\Enums\Frota\DriversStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class DriversController extends Controller
{
    public function __construct(protected Driver $repository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $drivers = Driver::all();

        return view('pages.painel.frotas.drivers.index', [
            'drivers' => $drivers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(StoreUpdateDriver $request)
    {
        $this->repository->create($request->validated());

        return redirect()
            ->route('drivers.index')
            ->with('message', 'Criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $identify
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(int $identify)
    {
        if (!$driver = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('drivers.index')
                ->with('message', 'Registro não encontrado!');
        }

        $files = $driver->files;


        return view('pages.painel.frotas.drivers.show', [
            'driver' => $driver,
            'files' => $files,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $identify
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function update(StoreUpdateDriver $request, int $identify)
    {
        $columns = $request->all();

        if (!$drivers = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('drivers.index')
                ->with('message', 'Registro não encontrado!');
        }

        $drivers->update($columns);

        return redirect()
            ->back()
            ->with('message', 'Atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (!$drivers = $this->repository->where('id', $id)->first()) {
            return redirect()
                ->route('drivers.index')
                ->with('message', 'Registro (Driver) não encontrado!');
        }

        $drivers->delete();

        return redirect()
            ->route('drivers.index')
            ->with('message', 'Deletado com sucesso');
    }

    public function file(Request $request, $identify)
    {
        if (!$drive = $this->repository->where('id', $identify)->first()) {
            return redirect()
                ->route('drives')
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
            $path = $disk->putFileAs('drives', $file, $file->getClientOriginalName());
            $token = md5(time());
            $fileHash = sha1_file($file->path());

            $drive->files()->create(
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

    public function fileDelete($driveId, $fileToken)
    {
        if (!$drive = $this->repository->where('id', $driveId)->first()) {
            return redirect()
                ->route('vehicles.drivers.index')
                ->with('message', 'Registro não encontrado!');
        }

        if (auth()->user()->id == '5') {

            if (!$file = $drive->files()->where('token', $fileToken)->first()) {
                return redirect()
                    ->route('vehicles.drivers.index')
                    ->with('message', 'Registro arquivo não encontrado!');
            }

            if (Storage::disk('public')->exists($file->getRawOriginal('path'))) {
                Storage::disk('public')->delete($file->getRawOriginal('path'));
            }

            $file->delete();

            return redirect()
                ->route('vehicles.drivers.show', $drive->id)
                ->with('message', 'Deletado com sucesso');
        }

        return redirect()
            ->route('vehicles.drivers.show', $drive->id)
            ->with('error', 'Sem permissão');
    }

}
