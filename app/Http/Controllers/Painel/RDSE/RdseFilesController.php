<?php

namespace App\Http\Controllers\Painel\RDSE;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEtdFile;
use App\Jobs\UploadFile;
use App\Models\Etd;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RdseFilesController extends Controller
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

        $rdses = Etd::limit(30)
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

        return view('pages.painel.rdse.files.index', [
            'rdses' => $rdses
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!$rdse = Etd::where('id', $id)->first()) {
            return redirect()
                ->route('rdse.index')
                ->with('message', 'Registro não encontrado!');
        }

        $pastasPorData = File::select('created_at')
            ->where('service_type', 'App\Models\Etd')
            ->where('service_id', $rdse->id)
            ->groupBy('created_at')
            ->get();

        #dd($pastasPorData);

        return view('pages.painel.rdse.files.show', [
            'rdse' => $rdse,
            'pastasPorData' => $pastasPorData,
        ]);
    }

    public function folderFiles($rdseId, $folder)
    {
        $date = Carbon::parse($folder)->format('Y-m-d');

        if (!$rdse = Etd::where('id', $rdseId)->first()) {
            return redirect()
                ->route('rdse.index')
                ->with('message', 'Registro não encontrado!');
        }

        $files = File::where('service_type', 'App\Models\Etd')
            ->where('service_id', $rdse->id)
            ->whereDate('created_at', $date)
            ->get();

        return view('pages.painel.rdse.files.folder_show', [
            'rdse' => $rdse,
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
        $rdses = Etd::get();

        $filesNow = File::whereDate('created_at', now())->get();

        return view('pages.painel.rdse.files.register', [
            'rdses' => $rdses,
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
        $rdseId = $rows['rdse'];

        $rdse = Etd::where('id', $rdseId)->first();
        $rdseName = slug($rdse->name);
        $dateNow = Carbon::parse(now())->format('d-m-Y');

        foreach ($request->attachments as $attachment) {
            $name = $attachment->hashName();
            $upload = Storage::put("rdse/files/$rdseName/$dateNow", $attachment);
            $token = clear(token(15, false));
            $fileHash = sha1_file($attachment->path());

            $rdse->files()->create(
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
