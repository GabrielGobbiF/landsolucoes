<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Obra;
use App\Models\Pasta;
use DirectoryIterator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class DocumentosController extends Controller
{
    protected $repository;


    public function __construct(Obra $obra)
    {
        $this->middleware('auth');

        $this->repository = $obra;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directorys = Pasta::whereNull('folder_childer')->get(); #Storage::disk('local')->directories('00tR9vps6D');

        return view('pages.painel.obras.documentos.index', [
            'directorys' => $directorys,
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
        dd($request);
        $columns = $request->except('_token');

        if (isset($columns['attachments'])) {
            if ($columns['attachment']->isValid()) {
                Storage::disk('local')->put($folder->uuid, $columns['attachment']);
            }
        }


        return redirect()
            ->back()
            ->with('message', 'Criado com sucesso');
    }
}
