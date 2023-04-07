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
        $file->token = token();
        $file->user_Id = auth()->user()->id;
    }
}
