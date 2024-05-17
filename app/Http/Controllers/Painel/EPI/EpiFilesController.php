<?php

namespace App\Http\Controllers\Painel\EPI;

use App\Models\RSDE\Handswork;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEpiFile;
use App\Http\Requests\StoreUpdateEpi;
use App\Models\Epi;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EpiFilesController extends Controller
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
        return view('pages.painel.epi.index', []);
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\View\View
     */
    public function register()
    {
        $epis = Epi::get();

        $filesNow = File::whereDate('created_at', now())->get();

        return view('pages.painel.epi.files.register', [
            'epis' => $epis,
            'filesNow' => $filesNow
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function registerStore(StoreEpiFile $request)
    {
        $epi = Epi::where('id', $request->validated('epi'))->first();
        $epiName = slug($epi->name);
        $dateNow = Carbon::parse(now())->format('d-m-Y');

        foreach ($request->attachments as $attachment) {
            $name = $attachment->hashName();
            $upload = Storage::put("epi/files/$epiName/$dateNow", $attachment);
            $token = clear(token(15, false));
            $fileHash = sha1_file($attachment->path());

            $epi->files()->create(
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
