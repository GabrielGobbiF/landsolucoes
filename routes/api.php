<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->middleware('auth:web')->group(function () {

    Route::get('categories/{category_name}', [App\Http\Controllers\Api\CategoriesApiController::class, 'show'])->name('api.categorie.show');
    Route::post('categories/store', [App\Http\Controllers\Api\CategoriesApiController::class, 'store'])->name('api.categories.store');

    /**
     * Mão De obra
     */
    Route::get('handswork', [App\Http\Controllers\Painel\RDSE\Api\HandsworkApiController::class, 'index'])->name('api.handswork.all');


    /**
     * RDSE
     */
    Route::get('rdse/lastServiceId', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'getLastId'])->name('api.rdse.service.lastId');
    Route::post('rdse/{rdseId}/services', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'storeService'])->name('api.rdse.service.store');
    Route::put('rdse/{rdseId}/services/all', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'updateServices'])->name('api.rdse.services.update');
    Route::delete('rdse/{rdseId}/services/{serviceId}', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'deleteService'])->name('api.rdse.service.store');
});
