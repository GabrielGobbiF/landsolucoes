<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\TheOneResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Uploaded;
use App\Services\UploadedService;
use Illuminate\Support\Facades\DB;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use ZipArchive;

class UploadController extends Controller
{
    public function __construct(private UploadedService $uploadedService) {}

    /**
     * Handle chunk upload via resumable.js
     */
    public function uploadChunk(Request $request)
    {
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        $save = $receiver->receive();

        if ($save->isFinished()) {
            return $this->saveFile($save->getFile(), $request->parent_model, $request->parent_id);
        }

        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    protected function saveFile(UploadedFile $file, $parentModel = null, $parentId = null)
    {
        try {

            DB::beginTransaction();

            $fileName = $this->createFilename($file);

            $mime = str_replace('/', '-', $file->getMimeType());

            $dateFolder = date("Y-m-W");

            $filePath = "upload/{$mime}/{$dateFolder}";

            $finalPath = storage_path("app/public/" . $filePath);

            $file->move($finalPath, $fileName);

            $hash = hash_file(
                'sha256',
                storage_path(
                    path: "app/public/{$filePath}/{$fileName}",
                ),
            );

            #if (Uploaded::where('file_hash', $hash)->exists()) {
            #    throw ValidationException::withMessages(['message' => 'Documento já cadastrado!']);
            #}

            $parent = $parentModel && $parentId
                ? app($parentModel)->find($parentId)
                : null;

            $this->uploadedService->save([
                'name' => $fileName,
                'mime_type' => $mime,
                'path' => "storage/{$filePath}/{$fileName}",
                'hash' => $hash,
                'parentable_type' => $parent ? $parentModel : null,
                'parentable_id' => $parent ? $parent->id : null,
            ]);

            DB::commit();

            return response()->json([
                'path' => asset('storage/' . $filePath),
                'name' => $fileName,
                'mime_type' => $mime
            ]);
        } catch (\Throwable $th) {

            DB::rollBack();
            throw ValidationException::withMessages(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();

        $filename = str_replace("." . $extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }

    public function destroy($uploadId)
    {
        if (!$upload = Uploaded::where('id', $uploadId)->first()) {
            TheOneResponse::notFound('Provider not found');
        }

        $upload->delete();

        return TheOneResponse::ok([]);
    }

    public function generateArchive(Request $request)
    {
        // Validação da requisição
        $request->validate([
            'ids' => 'required'
        ]);

        // Recupera e processa os IDs enviados (string ou array)
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        // Busca os uploads no banco de dados
        $uploads = Uploaded::whereIn('id', $ids)->get();
        if ($uploads->isEmpty()) {
            return response()->json(['message' => 'Nenhum arquivo encontrado.'], 404);
        }

        // Define o nome e o caminho do arquivo ZIP
        $zipFileName = 'arquivo_' . time() . '.zip';
        $zipFilePath = storage_path("app/public/00tR9vps6D/$zipFileName.zip");

        // Cria o arquivo ZIP
        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return response()->json(['message' => 'Não foi possível criar o arquivo ZIP.'], 500);
        }

        // Adiciona os arquivos ao ZIP
        foreach ($uploads as $upload) {
            $fileFullPath = Storage::disk($upload->disk)->path(str_replace('storage', 'public', $upload->path));

            // Verifica se o arquivo realmente existe
            if (file_exists($fileFullPath)) {
                $zip->addFile($fileFullPath, $upload->file_name);
            } else {
                \Log::warning("Arquivo não encontrado: {$fileFullPath}");
            }
        }

        // Fecha o ZIP
        $zip->close();

        // Verifica se o arquivo ZIP foi criado
        if (!file_exists($zipFilePath)) {
            return response()->json(['message' => 'O arquivo ZIP não foi gerado.'], 500);
        }

        // Retorna o arquivo para download e apaga-o após o envio
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
}
