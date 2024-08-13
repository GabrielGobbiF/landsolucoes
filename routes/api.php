<?php

use App\Http\Controllers\API\BaseController;
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

    Route::post('comercial/{comercialId}/activities', [App\Http\Controllers\Api\ActivitiesApiController::class, 'store'])->name('api.activities.store');
    Route::get('comercial/{comercialId}/activities', [App\Http\Controllers\Api\ActivitiesApiController::class, 'index'])->name('api.activities.index');


    Route::get('categories/{category_name}', [App\Http\Controllers\Api\CategoriesApiController::class, 'show'])->name('api.categorie.show');
    Route::post('categories/store', [App\Http\Controllers\Api\CategoriesApiController::class, 'store'])->name('api.categories.store');

    /**
     * Mão De obra
     */
    Route::get('handswork', [App\Http\Controllers\Painel\RDSE\Api\HandsworkApiController::class, 'index'])->name('api.handswork.all');

    /**
     * RDSE
     */
    Route::put('rdse/{rdseId}/update-status-execution', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'updateStatusExecution'])->name('api.rdse.update.status.execution');
    Route::get('rdses/bygroup', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'getRdsesByGroup'])->name('api.rdse.get.rdses.bygroup');
    Route::put('rdse/{rdseId}', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'update'])->name('api.rdse.update');
    Route::post('rdse/{rdseId}/services/reorder', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'reorderService'])->name('api.rdse.service.reorder');
    Route::post('rdse/{rdseId}/services', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'storeService'])->name('api.rdse.service.store');
    Route::put('rdse/{rdseId}/services/all', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'updateServices'])->name('api.rdse.services.update');
    Route::delete('rdse/{rdseId}/services/{serviceId}', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'deleteService'])->name('api.rdse.service.store');


    /**
     * Concessionaria X Service
     */
    Route::get('concessionarias/{concessionariaId}/services', [BaseController::class, 'getServicesByConcessionaria'])->name('api.concessionaria.services');
});
