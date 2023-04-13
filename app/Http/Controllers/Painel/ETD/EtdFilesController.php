<?php

namespace App\Http\Controllers\Painel\ETD;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEtdFile;
use App\Models\Etd;
use App\Models\File;
use Carbon\Carbon;
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
    public function index()
    {
        return view('pages.painel.etd.index', []);
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\View\View
     */
    public function register()
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
