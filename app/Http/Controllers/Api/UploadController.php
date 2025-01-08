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
}
