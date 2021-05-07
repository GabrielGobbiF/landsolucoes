<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Obra;
use DirectoryIterator;
use Illuminate\Support\Facades\Storage;

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
        $directorys = Storage::disk('local')->directories('00tR9vps6D');

        return view('pages.painel.obras.obras.index', [
            'directorys' => $directorys,
        ]);
    }

    public function index1()
    {
        $dir = new DirectoryIterator('../storage/app/00tR9vps6D');

        foreach ($dir as $file) {
            // verifica se $file é diferente de '.' ou '..'
            if (!$file->isDot()) {
                // listando somente os diretórios
                if ($file->isDir()) {
                    // atribui o nome do diretório a variável
                    $dirName = $file->getFilename();

                    // subdiretórios
                    $caminho = $file->getPathname();
                    // chamada da função de recursividade
                    $this->recursivo($caminho, $dirName);
                }

                // listando somente os arquivos do diretório
                if ($file->isFile()) {
                    // atribui o nome do arquivo a variável
                    $fileName = $file->getFilename();
                    //
                    echo "fotos: " . $fileName . "<br>";
                }
            }
        }
    }

    private function recursivo($caminho, $dirName)
    {
        global $dirName;

        $DI = new DirectoryIterator($caminho);

        foreach ($DI as $file) {
            if (!$file->isDot()) {
                if ($file->isFile()) {
                    $fileName = $file->getFilename();
                    echo $dirName . " : " . $fileName . "<br>";
                }
            }
        }
    }
}
