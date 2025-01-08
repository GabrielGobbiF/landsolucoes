<?php

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Api\EtapasApiController;
use App\Http\Controllers\Api\ObraApiController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

Route::get('obras', [ObraApiController::class, 'all'])->name('api.obras.all');

Route::prefix('v1')->middleware('auth:web')->group(function () {

    Route::delete('activities/{id}', [App\Http\Controllers\Api\ActivitiesApiController::class, 'delete'])->name('api.activities.delete');
    Route::post('comercial/{comercialId}/activities', [App\Http\Controllers\Api\ActivitiesApiController::class, 'store'])->name('api.activities.store');
    Route::get('comercial/{comercialId}/activities', [App\Http\Controllers\Api\ActivitiesApiController::class, 'index'])->name('api.activities.index');


    Route::get('categories/{category_name}', [App\Http\Controllers\Api\CategoriesApiController::class, 'show'])->name('api.categorie.show');
    Route::post('categories/store', [App\Http\Controllers\Api\CategoriesApiController::class, 'store'])->name('api.categories.store');

    /**
     * Mão De obra
     */
    Route::get('handswork', [App\Http\Controllers\Painel\RDSE\Api\HandsworkApiController::class, 'index'])->name('api.handswork.all');


    /**
     * Equipes
     */
    Route::get('rdses/equipes/{equipeId}', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'getAtividadesEquipesHoje'])->name('api.rdse.get.rdses.atividades.now');
    Route::get('rdses/equipes/{equipeId}/atividades', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'getAtividadesEquipes'])->name('api.rdse.get.rdses.atividades');

    /**
     * PROGRAMAÇÃO
     */


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
    Route::get('rdses/{rdseId}', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'show'])->name('api.rdse.show');
    Route::get('rdses', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'index'])->name('api.rdse.index');

    /**
     * RDSE atividade
     */
    Route::delete('rdses/{rdseId}/atividades/{rdseAtividadeId}', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'deleteAtividade'])->name('api.rdse.atividades.delete');
    Route::post('rdses/{rdseId}/atividades', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'storeAtividade'])->name('api.rdse.atividades.store');
    Route::get('rdses/{rdseId}/atividades', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'atividades'])->name('api.rdse.atividades.all');


    /**
     * RDSE RESB
     */
    Route::put('rdses/{rdseId}/resb', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'updateRdseResb'])->name('api.rdse.resb.update');

    /**
     * Concessionaria X Service
     */
    Route::get('concessionarias/{concessionariaId}/services', [ObraApiController::class, 'getServicesByConcessionaria'])->name('api.concessionaria.services');

    /**
     * Etapas
     */
    Route::get('etapas', [EtapasApiController::class, 'getAll'])->name('api.etapas.all');
    Route::put('obras/{obraId}', [ObraApiController::class, 'update'])->name('api.obras.update');
    Route::get('obras/{obraId}', [ObraApiController::class, 'show'])->name('api.obras.show');
    Route::get('etapas/{etapaId}/files', [EtapasApiController::class, 'getFiles'])->name('api.etapas.files');

    /**
     * Arquivos
     */
    Route::post('upload', [UploadController::class, 'uploadChunk']);
    Route::delete('uploadeds/{uploadId}', [UploadController::class, 'destroy']);
});

Route::get('check-reset-flag', function () {
    return response()->json([
        'resetRequired' => Cache::get('resetReloadFlag', false),
    ]);
});
