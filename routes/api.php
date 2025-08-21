<?php

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Api\EtapasApiController;
use App\Http\Controllers\Api\ObraApiController;
use App\Http\Controllers\Api\TableApiController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Painel\Obras\FinanceiroController;
use App\Http\Controllers\Painel\RDSE\Api\RdseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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

Route::get('projects', [TableApiController::class, 'rdses'])->name('api.rdses.all');

//Route::get('obras', [ObraApiController::class, 'all'])->name('api.obras.all');

Route::get('concessionarias', [BaseController::class, 'concessionarias'])->name('api.concessionarias.all');
Route::get('servicos', [BaseController::class, 'servicos'])->name('api.sevicos.all');

Route::prefix('v1')->middleware('auth:web')->group(function () {

    Route::get('finances', [FinanceiroController::class, 'getAll'])->name('api.finances.all');

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
    Route::put('rdse/{rdseId}/update-sigeo_at', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'updateSigeoAt'])->name('api.rdse.update.sigeo.at');
    Route::put('rdse/{rdseId}/update-status-execution', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'updateStatusExecution'])->name('api.rdse.update.status.execution');
    Route::get('rdses/bygroup', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'getRdsesByGroup'])->name('api.rdse.get.rdses.bygroup');
    Route::put('rdse/{rdseId}', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'update'])->name('api.rdse.update');
    Route::post('rdse/{rdseId}/services/reorder', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'reorderService'])->name('api.rdse.service.reorder');
    Route::post('rdse/{rdseId}/services', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'storeService'])->name('api.rdse.service.store');
    Route::put('rdse/{rdseId}/services/all', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'updateServices'])->name('api.rdse.services.update');
    Route::delete('rdse/{rdseId}/services/{serviceId}', [App\Http\Controllers\Painel\RDSE\Api\RdseApiController::class, 'deleteService'])->name('api.rdse.service.delete');
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
    Route::get('etapas/{etapaId}/get-files', [EtapasApiController::class, 'getEtapaFiles'])->name('api.get.etapas.files');

    /**
     * Arquivos
     */
    Route::post('uploadeds/generateArchive', [UploadController::class, 'generateArchive']);
    Route::post('upload', [UploadController::class, 'uploadChunk']);
    Route::delete('uploadeds/{uploadId}', [UploadController::class, 'destroy']);
});

Route::get('check-reset-cache', function () {
    if (auth()->check()) {
        $resetCache = DB::table('reset_cache')
            ->where('user_id', auth()->user()->id)
            ->value('reset_cache');

        if ($resetCache === null) {
            DB::table('reset_cache')->insert([
                'user_id' => auth()->user()->id,
                'reset_cache' => false,
            ]);

            $resetCache = true; // Define como false, já que acabou de ser criado
        }
    }

    return response()->json(['reset_cache' => $resetCache?? false]);
});

Route::post('disable-reset-cache', function () {

    DB::table('reset_cache')
        ->where('user_id', auth()->user()->id)
        ->update(['reset_cache' => false]);

    return response()->json(['success' => true]);
});

/*
|--------------------------------------------------------------------------
| Rotas para o sistema de notificações
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/notifications/unread', [NotificationController::class, 'getUnread']);
    Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
});
