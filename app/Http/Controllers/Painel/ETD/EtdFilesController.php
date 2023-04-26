<?php

namespace App\Http\Controllers\Painel\ETD;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEtdFile;
use App\Jobs\UploadFile;
use App\Models\Etd;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;

class EtdFilesController extends Controller
{
    protected $repository;

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $etds = Etd::limit(30)
            ->where(function ($query) use ($search) {
                $query->where(
                    function ($query) use ($search) {
                        if (isset($search) && $search != '') {
                            $query->where('nome', 'like', '%' . $search . '%');
                        }
                    }
                );
            })
            ->get();

        return view('pages.painel.etd.files.index', [
            'etds' => $etds
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!$etd = Etd::where('id', $id)->first()) {
            return redirect()
                ->route('etd.index')
                ->with('message', 'Registro não encontrado!');
        }

        $pastasPorData = File::select('created_at')
            ->where('service_type', 'App\Models\Etd')
            ->where('service_id', $etd->id)
            ->groupBy('created_at')
            ->get();

        #dd($pastasPorData);

        return view('pages.painel.etd.files.show', [
            'etd' => $etd,
            'pastasPorData' => $pastasPorData,
        ]);
    }

    public function folderFiles($etdId, $folder)
    {
        $date = Carbon::parse($folder)->format('Y-m-d');

        if (!$etd = Etd::where('id', $etdId)->first()) {
            return redirect()
                ->route('etd.index')
                ->with('message', 'Registro não encontrado!');
        }

        $files = File::where('service_type', 'App\Models\Etd')
            ->where('service_id', $etd->id)
            ->whereDate('created_at', $date)
            ->get();

        return view('pages.painel.etd.files.folder_show', [
            'etd' => $etd,
            'date' => $date,
            'files' => $files,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\View\View
     */
    public function register(Request $request)
    {
        $etds = Etd::get();

        $filesNow = File::whereDate('created_at', now())->get();

        return view('pages.painel.etd.files.register', [
            'etds' => $etds,
            'filesNow' => $filesNow
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function registerStore(StoreEtdFile $request)
    {
        $rows = $request->validated();
        $observation = $rows['observations'];
        $etdId = $rows['etd'];

        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $etd = Etd::where('id', $etdId)->first();
        $etdName = slug($etd->name);
        $dateNow = Carbon::parse(now())->format('d-m-Y');

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs("files/etd/files$etdName/$dateNow", $file, $fileName);
            $token = clear(token(15, false));

            $etd->files()->create(
                [
                    'name' => "{$fileName}",
                    'token' => $token,
                    'file_name' => $fileReceived->getClientOriginalName(),
                    'mime_type' => $fileReceived->getClientMimeType(),
                    'path' => $path,
                    'disk' => 'public',
                    #'file_hash' => $fileHash,
                    'collection' => $request->get('collection'),
                    'size' => $fileReceived->getSize(),
                    'observations' => $observation
                ]
            );

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => asset('storage/files/' . $path),
                'filename' => $fileName
            ];
        }

    }
}
