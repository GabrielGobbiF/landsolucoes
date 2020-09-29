<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
        Route::post('/employees/update_auditory_applicable', [App\Http\Controllers\Painel\EmployeesController::class, 'update_auditory_applicable'])->name('update_auditory_applicable');
        Route::get('/employees', [App\Http\Controllers\Painel\EmployeesController::class, 'index'])->name('employees');
        Route::get('/employees/create', [App\Http\Controllers\Painel\EmployeesController::class, 'create'])->name('employees.create');
        Route::post('/employees/create', [App\Http\Controllers\Painel\EmployeesController::class, 'store'])->name('employees.store');
        Route::get('/employees/{id}', [App\Http\Controllers\Painel\EmployeesController::class, 'show'])->name('employees.show');
        Route::put('/employees/{id}', [App\Http\Controllers\Painel\EmployeesController::class, 'update'])->name('employees.update');
        Route::get('/employees/delete/{id}', [App\Http\Controllers\Painel\EmployeesController::class, 'destroy'])->name('employees.destroy');


        Route::post('/employees/{id}/auditory/update', [App\Http\Controllers\Painel\EmployeesController::class, 'auditoryUpdate'])->name('employees.auditory.update');

    });
});
