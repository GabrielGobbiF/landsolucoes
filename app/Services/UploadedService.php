<?php

namespace App\Services;


use App\Models\Uploaded;
use App\Repositories\UploadRepository;
use App\Supports\Traits\UploadFileTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadedService
{
    use UploadFileTrait;

    protected $fileName;

    public function __construct(protected UploadRepository $uploadRepository) {}

    public function save(array $attributes)
    {
        $this->uploadRepository->store($attributes);
    }

    /**
     * Process any uploaded images (for featured image)
     *
     *
     * @return array returns an array of details about each file resized.
     * @throws \Exception
     * @todo - This class was added after the other main features, so this duplicates some code from the main blog post admin controller (BinshopsAdminController). For next full release this should be tided up.
     */
    public function processUploadedImages($file, $sizes, $isCover, $parentable = null,  $destination = null)
    {
        DB::beginTransaction(); // Começa uma transação do banco de dados;

        try {
            $photo = $file;

            $imageDetails = $this->createFilename($photo);

            $name = $imageDetails['name'];

            $filename = $imageDetails['filename'];

            $extension = $imageDetails['extension'];

            $mime = str_replace('/', '-', $imageDetails['mime_type']);

            // Group files by the date (week
            $dateFolder = date("Y-m-W");

            // Build the file path
            $filePath = "upload/" . optional($parentable)->getTable();

            #$hash = hash_file(
            #    'sha256',
            #    storage_path(
            #        path: "app/public/{$filePath}/{$this->fileName}",
            #    ),
            #);

            #if (Uploaded::where('file_hash', $hash)->exists()) {
            #    return;
            #}

            if (!$destination) {
                $destination = storage_path("app/public/" . $filePath);
            }

            $this->increaseMemoryLimit();

            // to save in db later
            $uploaded_image_details = [];

            $sizes_to_upload = $sizes;

            // now upload a full size - this is a special case, not in the config file. We only store full size images in this class, not as part of the featured blog image uploads.
            if (isset($sizes_to_upload['full_size']) && $sizes_to_upload['full_size'] === 'true') {
                $uploaded_image_details['full_size'] = $this->UploadAndResize('', 'fullsize', $photo, $destination);
            }

            foreach ((array)config('uploaded.image_sizes') as $size => $image_size_details) {

                if (!isset($sizes_to_upload[$size]) || !$sizes_to_upload[$size] || !$image_size_details['enabled']) {
                    continue;
                }

                // this image size is enabled, and
                // we have an uploaded image that we can use
                $uploaded_image_details[$size] = $this->UploadAndResize('', $image_size_details, $photo, $destination);
            }

            $uploaded_image_details['path'] = "storage/{$filePath}/";

            $model = $parentable ? $parentable->images() : app(Uploaded::class);

            #dd([
            #    $name,
            #    $filename,
            #    $mime,
            #    $extension,
            #    optional(auth()->user())->id,
            #    $uploaded_image_details,
            #    $filePath,
            #    $isCover
            #]);

            $upload = $model->forceCreate([
                'name' => $name,
                'file_Name' => $filename,
                'mime_type' => $mime,
                'extension' => $extension,
                'uploader_id' => optional(auth()->user())->id,
                'uploaded_images' => $uploaded_image_details,
                'path' => "storage/{$filePath}/",
                'is_cover' => $isCover ? 1 : 0,
                #'hash' => $hash,
            ]);

            DB::commit();

            $uploaded_image_details['id'] = $upload->id;
        } catch (\Throwable $th) {
            DB::rollback();
            #LogChannel($th->getMessage(), 'warning');
            return [];
        }

        return [
            'id' => $upload->id,
            'path' => $upload->path,
            'cover' => $upload->uploaded_images['image_medium'],
            'name' => $name,
            'details' => $uploaded_image_details
        ];
    }

    public function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();

        $fileOriginalname = str_replace("." . $extension, "", $file->getClientOriginalName());

        $filename = $fileOriginalname . "_" . md5(time()) . "." . $extension;

        return [
            "name" => $fileOriginalname,
            "filename" => $filename,
            "extension" => $extension,
            "mime_type" => $file->getMimeType(),
        ];
    }

    public function delete($upload)
    {
        $images = $upload->uploaded_images;

        $path = $upload->path;

        foreach ($images as $image) {
            if (isset($image['filename'])) {
                $filePath = str_replace('storage/', '', $path) . $image['filename'];
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        return $upload->delete();
    }
}
