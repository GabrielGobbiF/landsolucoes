<?php

namespace App\Repositories;

use App\Models\Uploaded;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

class UploadRepository extends AbstractRepository
{
    protected static string $model = Uploaded::class;

    public function store(array $attributes, Model $model = null): ?Uploaded
    {
        $upload = new Uploaded();
        $upload->name = $attributes['name'];
        $upload->file_name = $attributes['name'];
        $upload->mime_type = $attributes['mime_type'];
        $upload->path = $attributes['path'];
        $upload->uploader_id = auth()->user()->id;
        $upload->file_hash = $attributes['hash'];
        $upload->parentable_type = $attributes['parentable_type'] ?? null;
        $upload->parentable_id = $attributes['parentable_id'] ?? null;
        $upload->extension = $attributes['extension'] ?? null;
        $upload->user_id = auth()->user()->id;
        return tap($upload)->save();
    }
}
