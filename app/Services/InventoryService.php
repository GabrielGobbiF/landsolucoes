<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Uploaded;
use App\Repositories\InventoryRepository;
use App\Services\UploadedService;
use Illuminate\Http\Request;

class InventoryService
{
    public function getInventories()
    {
        return Inventory::all();
    }

    public function getInventoryById($id)
    {
        return Inventory::where('id', $id)->firstOrFail();
    }

    public function store($attributes)
    {
        $inventory = Inventory::create($attributes);

        if (isset($attributes['files']) && count($attributes['files']) > 0) {
            #$this->saveCoverImage($inventory, $attributes['files'], $attributes['sizes_to_upload']);
        }

        return $inventory;
    }

    public function update($inventory, $attributes)
    {
        if (isset($attributes['files']) && count($attributes['files']) > 0) {
            #$this->saveCoverImage($inventory, $attributes['files'], $attributes['sizes_to_upload']);
        }

        return tap($inventory)->update($attributes);
    }

    #private function saveCoverImage($inventory, $files, $sizes)
    #{
    #    foreach ($files as $file) {
    #        $isCover = !$inventory->images()->where('is_cover', true)->exists();
#
    #        app(UploadedService::class)->processUploadedImages($file, $sizes, $isCover, $inventory);
    #    }
    #}
#
    #public function removeImage($inventory)
    #{
    #    app(UploadedService::class)->delete(
    #        Uploaded::where('id', $inventory->images()->first()['id'])->first()
    #    );
#
    #    return Inventory::remove_image($inventory);
    #}
}
