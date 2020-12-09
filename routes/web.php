<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'role:rh'], function () {
    /*
    |--------------------------------------------------------------------------
    | RH - Recursos Humanos Cena
    |--------------------------------------------------------------------------
    */
    Route::prefix('rh')->middleware('auth')->group(function () {
        /*
        |--------------------------------------------------------------------------
        | Employees - Funcionários
        |--------------------------------------------------------------------------
        */
        Route::get('/', [App\Http\Controllers\Painel\EmployeesController::class, 'index'])->name('employees');
        Route::get('/employees', [App\Http\Controllers\Painel\EmployeesController::class, 'index'])->name('employees');
        Route::get('/employees/create', [App\Http\Controllers\Painel\EmployeesController::class, 'create'])->name('employees.create');
        Route::post('/employees/create', [App\Http\Controllers\Painel\EmployeesController::class, 'store'])->name('employees.store');
        Route::get('/employees/{id}', [App\Http\Controllers\Painel\EmployeesController::class, 'show'])->name('employees.show');
        Route::put('/employees/{id}', [App\Http\Controllers\Painel\EmployeesController::class, 'update'])->name('employees.update');
        Route::put('/employees/dispense/{id}', [App\Http\Controllers\Painel\EmployeesController::class, 'dispensaEmployee'])->name('employees.dispense');
        Route::get('/employees/delete/{id}', [App\Http\Controllers\Painel\EmployeesController::class, 'destroy'])->name('employees.destroy');

        /*
        |--------------------------------------------------------------------------
        | Employees - Relátorio
        |--------------------------------------------------------------------------
        */
        Route::get('/relatorio/search', [App\Http\Controllers\Painel\Relatorios\RelatorioEmployee::class, 'search'])->name('relatorio.employee.search');
        Route::get('/relatorio', [App\Http\Controllers\Painel\Relatorios\RelatorioEmployee::class, 'index'])->name('relatorios.employees');

        /*
        |--------------------------------------------------------------------------
        | Auditory_Employees - Funcionário Auditoria
        |--------------------------------------------------------------------------
        */
        Route::post('/employees/update_auditory_applicable', [App\Http\Controllers\Painel\EmployeesController::class, 'update_auditory_applicable'])->name('update_auditory_applicable');
        Route::post('/employees/{id}/auditory/update', [App\Http\Controllers\Painel\EmployeesController::class, 'auditoryUpdate'])->name('employees.auditory.update');
        Route::get('/auditorys/month/{employees_auditory_id}', [App\Http\Controllers\Painel\AuditorysController::class, 'getParcelasAuditoryById'])->name('auditorys.month.show');
        Route::post('/employees/{id}/auditory/updateAuditoryMonth', [App\Http\Controllers\Painel\AuditorysController::class, 'updateEmployeesAuditoryMonth'])->name('employees.auditory.month.update');
        Route::post('/employees/{id}/auditory/storeAuditoryEmployee', [App\Http\Controllers\Painel\AuditorysController::class, 'storeAuditoryEmployee'])->name('employees.auditory.store');
        Route::post('/employees/auditory/newEpiEmployee', [App\Http\Controllers\Painel\AuditorysController::class, 'newEpiEmployee'])->name('employees.auditory.epi.store');

        Route::post('/auditorys/document_change', [App\Http\Controllers\Painel\AuditorysController::class, 'change_document_auditory'])->name('auditorys.document.change');


        /*
        |--------------------------------------------------------------------------
        | Auditoria Empresa
        |--------------------------------------------------------------------------
        */
        Route::get('/auditory/company', [App\Http\Controllers\Painel\AuditorysController::class, 'auditory_company'])->name('auditory.company');
        Route::post('/auditory/company/update', [App\Http\Controllers\Painel\AuditorysController::class, 'auditory_company_update'])->name('auditory.company.update');
        Route::post('/auditory/company/store', [App\Http\Controllers\Painel\AuditorysController::class, 'auditory_company_store'])->name('auditory.company.store');

        Route::get('/auditory/company/{id_auditory_company}/delete', [App\Http\Controllers\Painel\AuditorysController::class, 'auditory_company_delete'])->name('auditory.company.delete');
    });
});

Route::group(['middleware' => 'role:vehicles'], function () {
    /*
    |--------------------------------------------------------------------------
    | Veiculos
    |--------------------------------------------------------------------------
    */
    Route::resource('vehicles', App\Http\Controllers\Painel\VehiclesController::class);

    /*
    |--------------------------------------------------------------------------
    | Veiculos Atividades
    |--------------------------------------------------------------------------
    */
    Route::post('vehicles/{vehicle_id}/activitys', [App\Http\Controllers\Painel\VehicleActivitiesController::class, 'store'])->name('vehicles.activitys.store');
    Route::put('vehicles/{vehicle_id}/activitys/{activity_id}', [App\Http\Controllers\Painel\VehicleActivitiesController::class, 'update'])->name('vehicles.activitys.update');

});


Route::get('vehicles/{vehicle_id}/qrcode', [App\Http\Controllers\Painel\VehiclesController::class, 'qrcode'])->name('vehicles.activitys.qrcode');

/*
|--------------------------------------------------------------------------
| Usuarios
|--------------------------------------------------------------------------
*/
Route::resource('users', App\Http\Controllers\Painel\UsersController::class);

/*
|--------------------------------------------------------------------------
| Roles
|--------------------------------------------------------------------------
*/
Route::resource('roles', App\Http\Controllers\Painel\RolesController::class);
