<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/password/expired', [App\Http\Controllers\Auth\ExpiredPasswordController::class, 'change'])->name('password.change');
Route::post('/password/post_change', [App\Http\Controllers\Auth\ExpiredPasswordController::class, 'postExpired'])->name('password.post_expired');

Route::group(['middleware' => ['CheckPassword']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->middleware('auth');

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
            | Curso
            |--------------------------------------------------------------------------
            */
            Route::delete('/employees/{id_auditory}/removeCourse', [App\Http\Controllers\Painel\AuditorysController::class, 'removeCourse'])->name('auditorys.remove.course');

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

    Route::group(['middleware' => 'role:portaria'], function () {
    });

    Route::group(['middleware' => 'role:vehicles'], function () {

        /*
        |--------------------------------------------------------------------------
        | Veiculos Motoristas
        |--------------------------------------------------------------------------
        */
        Route::get('vehicles/drivers', [App\Http\Controllers\Painel\VehiclesController::class, 'drivers'])->name('vehicles.drivers');
        Route::get('vehicles/drivers/create', [App\Http\Controllers\Painel\VehiclesController::class, 'drivers_create'])->name('vehicles.drivers.create');
        Route::get('vehicles/drivers/{driver_id}', [App\Http\Controllers\Painel\VehiclesController::class, 'drivers_show'])->name('vehicles.drivers.show');
        Route::put('vehicles/drivers/{driver_id}/update', [App\Http\Controllers\Painel\VehiclesController::class, 'drivers_update'])->name('vehicles.drivers.update');
        Route::post('vehicles/drivers/store', [App\Http\Controllers\Painel\VehiclesController::class, 'drivers_store'])->name('vehicles.drivers.store');
        Route::delete('vehicles/drivers/{driver_id}/active-or-desactive', [App\Http\Controllers\Painel\VehiclesController::class, 'driver_activeOrdesactive'])->name('vehicles.drivers.activeOrdesactive');
        Route::delete('vehicles/drivers/{driver_id}/reset-password', [App\Http\Controllers\Painel\VehiclesController::class, 'driver_reset_password'])->name('vehicles.drivers.password.reset');


        /*
        |--------------------------------------------------------------------------
        | Veiculos
        |--------------------------------------------------------------------------
        */
        Route::get('vehicles/qrcode/all-qrcode', [App\Http\Controllers\Painel\VehiclesController::class, 'genereted_all_qrcode'])->name('vehicles.all.qrcode');
        Route::resource('vehicles', App\Http\Controllers\Painel\VehiclesController::class);

        /*
        |--------------------------------------------------------------------------
        | Veiculos Atividades
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | Portaria
        |--------------------------------------------------------------------------
        */
        Route::get('portaria', [App\Http\Controllers\Painel\PortariaController::class, 'index'])->name('vehicles.portaria');
    });


    Route::get('vehicles/{vehicle_id}/qrcode', [App\Http\Controllers\Painel\VehiclesController::class, 'qrcode'])->name('vehicles.activitys.qrcode');
    Route::put('vehicles/{vehicle_id}/activitys/{activity_id}', [App\Http\Controllers\Painel\VehicleActivitiesController::class, 'update'])->name('vehicles.activitys.update');
    Route::post('vehicles/{vehicle_id}/activitys', [App\Http\Controllers\Painel\VehicleActivitiesController::class, 'store'])->name('vehicles.activitys.store');
    Route::get('portaria/register', [App\Http\Controllers\Painel\PortariaController::class, 'create'])->name('vehicles.portaria.register');
    Route::post('portaria/register', [App\Http\Controllers\Painel\PortariaController::class, 'store'])->name('vehicles.portaria.create');

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



    Route::group(['middleware' => 'role:desenvolvedor'], function () {
        Route::prefix('dev')->group(function () {
            Route::get('/', [App\Http\Controllers\Painel\DesenvolvedorController::class, 'index'])->name('dev.index');
            Route::post('/updateNameAllEmployee', [App\Http\Controllers\Painel\DesenvolvedorController::class, 'alterNameAllEmployees'])->name('dev.alter.name.all.employee');
            Route::post('/deleteAllEmployee', [App\Http\Controllers\Painel\DesenvolvedorController::class, 'deleteAllEmployees'])->name('dev.delete.name.all.employee');
            Route::post('/deleteDocAuditory', [App\Http\Controllers\Painel\DesenvolvedorController::class, 'deleteDocAuditory'])->name('dev.delete.doc.auditory');
            Route::post('/alterDocAuditory', [App\Http\Controllers\Painel\DesenvolvedorController::class, 'alterDocAuditory'])->name('dev.alter.doc.auditory');
        });
    });
});
