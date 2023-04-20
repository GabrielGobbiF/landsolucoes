<?php

namespace App\Http\Controllers\Painel\ETD;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEtdFile;
use App\Models\Etd;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $etd = Etd::where('id', $etdId)->first();
        $etdName = slug($etd->name);
        $dateNow = Carbon::parse(now())->format('d-m-Y');

        foreach ($request->attachments as $attachment) {
            $name = $attachment->hashName();
            $upload = Storage::put("etd/files/$etdName/$dateNow", $attachment);
            $token = clear(token(15, false));
            $fileHash = sha1_file($attachment->path());

            $etd->files()->create(
                [
                    'name' => "{$name}",
                    'token' => $token,
                    'file_name' => $attachment->getClientOriginalName(),
                    'mime_type' => $attachment->getClientMimeType(),
                    'path' => $upload,
                    'disk' => 'public',
                    #'file_hash' => $fileHash,
                    'collection' => $request->get('collection'),
                    'size' => $attachment->getSize(),
                    'observations' => $observation
                ]
            );

            #if ($attachment->isValid()) {
            #    $path = Storage::put($localSaveAttachment, $attachment);
            #    $attachmentsSave[] = $path;
            #}
        }

        return redirect()->back()->with('message', 'Sucesso');
    }
}
