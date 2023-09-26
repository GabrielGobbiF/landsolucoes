<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\File;

class FileObserver
{
    /**
     * Handle the File "creating" event.
     *
     * @param  \App\Models\File  $file
     * @return void
     */
    public function creating(File $file)
    {
        $file->token = md5(time());
        $file->user_Id = auth()->user()->id;
    }
}
