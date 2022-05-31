<?php

use App\Models\Compras\Category;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/password/expired', [App\Http\Controllers\Auth\ExpiredPasswordController::class, 'change'])->name('password.change');
Route::post('/password/post_change', [App\Http\Controllers\Auth\ExpiredPasswordController::class, 'postExpired'])->name('password.post_expired');

//Login Routes Clients...
Route::get('/cliente/login', [App\Http\Controllers\Auth\Clients\LoginController::class, 'showLoginForm']);
Route::get('/clientes/login', [App\Http\Controllers\Auth\Clients\LoginController::class, 'showLoginForm']);
Route::post('/clientes/login', [App\Http\Controllers\Auth\Clients\LoginController::class, 'login'])->name('clients.login');
Route::post('/clientes/logout', [App\Http\Controllers\Auth\Clients\LoginController::class, 'logout']);

Route::group(['middleware' => ['CheckClient']], function () {
    Route::prefix('clientes')->group(function () {
        Route::get('/obras', [App\Http\Controllers\Clients\ClientController::class, 'index'])->name('clients.obras');
        Route::get('/obras/{obraId}', [App\Http\Controllers\Clients\ClientController::class, 'show'])->name('clients.obras.show');
    });
});

Route::prefix('/v1/api')->group(function () {

    Route::group(['middleware' => ['CheckAuth']], function () {
        Route::get('obra/{obra_id}/etapas', [App\Http\Controllers\Api\ObrasEtapasApiController::class, 'all'])->name('obra.etapa.all');
        Route::get('obra/{obra_id}/etapa/{etapa_id}', [App\Http\Controllers\Api\ObrasEtapasApiController::class, 'get'])->name('obra.etapa.show');
        Route::get('etapa/{etapa_id}/comments', [App\Http\Controllers\Api\ObrasEtapasApiController::class, 'getComments'])->name('obra.etapa.comments');
        Route::get('obra/{obraId}/documents', [App\Http\Controllers\Api\ObraApiController::class, 'documents'])->name('obras.documents.all');
        Route::post('obra/{obra_id}/etapa/{etapa_id}/comment/store', [App\Http\Controllers\Api\ObrasEtapasApiController::class, 'commentStore'])->name('obra.etapa.comment.store');
        Route::delete('obra/{obra_id}/etapa/{etapa_id}/comment/{commentId}/delete', [App\Http\Controllers\Api\ObrasEtapasApiController::class, 'commentDestroy'])->name('obra.etapa.comment.destroy');
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/clients', [App\Http\Controllers\Api\TableApiController::class, 'clients'])->name('clients.all');
        Route::get('/users', [App\Http\Controllers\Api\TableApiController::class, 'users'])->name('users.all');
        Route::get('/users_table', [App\Http\Controllers\Api\TableApiController::class, 'users_table'])->name('users.table.all');
        Route::get('/concessionarias', [App\Http\Controllers\Api\TableApiController::class, 'concessionarias'])->name('concessionarias.all');
        Route::get('/services', [App\Http\Controllers\Api\TableApiController::class, 'services'])->name('services.all');
        Route::get('/comercial', [App\Http\Controllers\Api\TableApiController::class, 'comercial'])->name('comercial.all');
        Route::get('/obras', [App\Http\Controllers\Api\TableApiController::class, 'obras'])->name('obras.all');
        Route::get('/drivers', [App\Http\Controllers\Api\TableApiController::class, 'drivers'])->name('drivers.all');
        Route::get('/employees', [App\Http\Controllers\Api\TableApiController::class, 'employees'])->name('employees.all');
        Route::get('/portarias', [App\Http\Controllers\Api\TableApiController::class, 'portarias'])->name('portarias.all');
        Route::get('/vehicles', [App\Http\Controllers\Api\TableApiController::class, 'vehicles'])->name('vehicles.all');
        Route::get('/fornecedores', [App\Http\Controllers\Api\TableApiController::class, 'fornecedores'])->name('fornecedores.all');
        Route::get('/produtos', [App\Http\Controllers\Api\TableApiController::class, 'produtos'])->name('produtos.all');
        Route::get('/orcamentos', [App\Http\Controllers\Api\TableApiController::class, 'orcamentos'])->name('orcamentos.all');
        Route::get('/handswork', [App\Http\Controllers\Api\TableApiController::class, 'handswork'])->name('handswork.all');
        Route::get('/rdses', [App\Http\Controllers\Api\TableApiController::class, 'rdses'])->name('rdses.all');
        Route::get('/modelos-rdses', [App\Http\Controllers\Api\TableApiController::class, 'ModelosRdses'])->name('modelos.rdses.all');

        Route::get('/comercial/{comercial_id}/etapasFinanceiro', [App\Http\Controllers\Api\TableApiController::class, 'etapas_financeiro'])->name('comercial.etapas.financeiro.all');
        Route::post('/comercial/{comercial_id}/etapasFinanceiro/store', [App\Http\Controllers\Api\EtapasApiController::class, 'etapas_financeiro_store'])->name('comercial.etapas.financeiro.store');
        Route::get('concessionaria/{concessionaria_id}/services', [App\Http\Controllers\Painel\Obras\ConcessionariaServiceController::class, 'servicesByConcessionariaId'])->name('concessionaria.service.all');

        /**
         * Etapas
         */

        Route::delete('obra/{obra_id}/etapa/deleteSelected', [App\Http\Controllers\Api\ObrasEtapasApiController::class, 'deleteSelected'])->name('obra.etapa.destroy.selected');
        Route::post('obra/{obra_id}/update', [App\Http\Controllers\Api\ObraApiController::class, 'update'])->name('api.obra.update');
        Route::post('obra/{obra_id}/etapas', [App\Http\Controllers\Api\ObrasEtapasApiController::class, 'updateSelecteds'])->name('obra.etapa.update.selecteds');
        Route::post('obra/{obra_id}/etapa/{etapa_id}', [App\Http\Controllers\Api\ObrasEtapasApiController::class, 'update'])->name('obra.etapa.update');
        Route::post('obra/{obra_id}/etapa/{etapa_id}/status', [App\Http\Controllers\Api\ObrasEtapasApiController::class, 'updateStatus'])->name('obra.etapa.update.status');

        /**
         * Tasks
         */
        Route::get('tasks', [App\Http\Controllers\Api\TaskController::class, 'all'])->name('tasks.all');
        Route::post('tasks', [App\Http\Controllers\Api\TaskController::class, 'store'])->name('task.store');
        Route::get('tasks/{task_id}', [App\Http\Controllers\Api\TaskController::class, 'show'])->name('task.show');
        Route::post('tasks/{task_id}', [App\Http\Controllers\Api\TaskController::class, 'update'])->name('task.update');
        Route::post('tasks/{task_id}/status', [App\Http\Controllers\Api\TaskController::class, 'updateStatus'])->name('obra.etapa.update.status');

        /**
         * Departamento
         */
        Route::get('departments/{departmentId}', [App\Http\Controllers\Painel\Obras\DepartmentController::class, 'show'])->name('departments.show');

        /*
          |--------------------------------------------------------------------------
          | Etapas X Faturamento
          |--------------------------------------------------------------------------
        */
        Route::get('obras/{obraId}/finance/{etapaId}', [App\Http\Controllers\Api\FinanceiroApiController::class, 'show'])->name('etapas.faturamento.show');
        Route::delete('obras/{obraId}/finance/{etapaId}/{faturamentoId}/destroy', [App\Http\Controllers\Api\FinanceiroApiController::class, 'destroy'])->name('etapas.faturamento.destroy');
        Route::put('obras/{obraId}/finance/{etapaId}/{faturamentoId}/updateStatus', [App\Http\Controllers\Api\FinanceiroApiController::class, 'updateStatus'])->name('etapas.faturamento.update.status');


        /*
        |--------------------------------------------------------------------------
        | Pesquisa Global
        |--------------------------------------------------------------------------
        */
        Route::get('/global', [App\Http\Controllers\Api\BaseController::class, 'global'])->name('global');
        Route::get('/global-search', [App\Http\Controllers\Api\BaseController::class, 'global_search'])->name('global.search');
    });
});

Route::group(['middleware' => ['CheckPassword']], function () {

    Route::get('/notifications/{uuid}/archived', [App\Http\Controllers\NotificationController::class, 'archived'])->name('notifications.archived');
    Route::get('/notifications/{uuid}/deleted', [App\Http\Controllers\NotificationController::class, 'deleted'])->name('notifications.deleted');
    Route::get('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'readAll'])->name('notifications.read.all');
    Route::resource('notifications', App\Http\Controllers\NotificationController::class);

    Route::get('/', function () {
        return view('welcome');
    })->name('home')->middleware('auth');

    Route::group(['middleware' => 'role:compras'], function () {
        Route::prefix('compras')->group(function () {

            Route::resource('fornecedor', App\Http\Controllers\Painel\Compras\FornecedoresController::class);
            Route::delete('/fornecedor/{fornecedorId}/contato/{contato_id}', [App\Http\Controllers\Painel\Compras\FornecedoresController::class, 'contato_destroy'])->name('fornecedor.contato.destroy');

            Route::resource('produtos', App\Http\Controllers\Painel\Compras\ProdutosController::class);
            Route::delete('/produtos/{produtoId}/variable/{variableId}', [App\Http\Controllers\Painel\Compras\ProdutosController::class, 'variable_destroy'])->name('produto.variable.destroy');

            Route::resource('orcamento', App\Http\Controllers\Painel\Compras\OrcamentoController::class);
            Route::resource('categories', App\Http\Controllers\Painel\Compras\CategoryController::class);
            Route::resource('sub-categories', App\Http\Controllers\Painel\Compras\SubCategoryController::class);
        });
    });

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
            #Route::get('/', [App\Http\Controllers\Painel\EmployeesController::class, 'index'])->name('employees');
            Route::get('/employees', [App\Http\Controllers\Painel\EmployeesController::class, 'index'])->name('employees.index');
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
            Route::delete('/auditory/company/{id_auditory_company}/delete', [App\Http\Controllers\Painel\AuditorysController::class, 'auditory_company_delete'])->name('auditory.company.delete');
        });
    });

    Route::group(['middleware' => 'role:builds'], function () {
        /*
        |--------------------------------------------------------------------------
        | Obras
        |--------------------------------------------------------------------------
        */

        Route::prefix('l')->middleware('auth')->group(function () {
            /*
            |--------------------------------------------------------------------------
            | Documentos
            |--------------------------------------------------------------------------
            */
            Route::get('arquivos/my-favorites', [App\Http\Controllers\Painel\Obras\DocumentosController::class, 'favorites'])->name('arquivos.my.favorites');
            Route::get('arquivos/folder/{folder_id}', [App\Http\Controllers\Painel\Obras\PastaController::class, 'show'])->name('folder.show');
            Route::post('arquivos/favorite', [App\Http\Controllers\Painel\Obras\DocumentosController::class, 'favorite'])->name('arquivos.favorite');
            Route::post('arquivos/unfavorite', [App\Http\Controllers\Painel\Obras\DocumentosController::class, 'unfavorite'])->name('arquivos.unfavorite');
            Route::post('arquivos/downloading', [App\Http\Controllers\Painel\Obras\DocumentosController::class, 'download'])->name('arquivos.download');
            Route::post('arquivos/{fileId}/move', [App\Http\Controllers\Painel\Obras\DocumentosController::class, 'move'])->name('arquivos.move');

            Route::resource('pastas', App\Http\Controllers\Painel\Obras\PastaController::class);
            Route::resource('arquivos', App\Http\Controllers\Painel\Obras\DocumentosController::class);

            /*
            |--------------------------------------------------------------------------
            | Serviços
            |--------------------------------------------------------------------------
            */
            Route::resource('services', App\Http\Controllers\Painel\Obras\ServiceController::class);

            /*
            |--------------------------------------------------------------------------
            | Obras
            |--------------------------------------------------------------------------
            */
            Route::post('obras/{obraId}/favorite', [App\Http\Controllers\Painel\Obras\ObrasController::class, 'favorite'])->name('obras.favorite');
            Route::post('obras/{obraId}//unfavorite', [App\Http\Controllers\Painel\Obras\ObrasController::class, 'unfavorite'])->name('obras.unfavorite');
            Route::get('obras/{obraId}/finance', [App\Http\Controllers\Painel\Obras\FinanceiroController::class, 'show'])->name('obras.finance');
            Route::delete('obras/{obraId}/concluir', [App\Http\Controllers\Painel\Obras\ObrasController::class, 'concluir'])->name('obras.concluir');
            Route::resource('obras', App\Http\Controllers\Painel\Obras\ObrasController::class);
            Route::get('finances', [App\Http\Controllers\Painel\Obras\FinanceiroController::class, 'index'])->name('finances.index');

            Route::put('obras/{obraId}/finance/{etapa_id}/storeFaturamento', [App\Http\Controllers\Api\FinanceiroApiController::class, 'storeFaturamento'])->name('etapas.faturamento.store');

            /*
            |--------------------------------------------------------------------------
            | Comercial
            |--------------------------------------------------------------------------
            */
            Route::post('comercial/{comercial_id}/updateStatus', [App\Http\Controllers\Painel\Obras\ComercialController::class, 'updateStatus'])->name('comercial.update.status');
            Route::post('comercial/{comercial_id}/updateFinanceiro', [App\Http\Controllers\Painel\Obras\ComercialController::class, 'updateOrCreateFinanceiro'])->name('comercial.update.financeiro');
            Route::post('comercial/approved', [App\Http\Controllers\Painel\Obras\ComercialController::class, 'approved'])->name('comercial.approved');
            Route::resource('comercial', App\Http\Controllers\Painel\Obras\ComercialController::class);

            /*
            |--------------------------------------------------------------------------
            | Clients
            |--------------------------------------------------------------------------
            */
            Route::resource('clients', App\Http\Controllers\Painel\Obras\ClientController::class);
            Route::post('department/store', [App\Http\Controllers\Painel\Obras\DepartmentController::class, 'store'])->name('departments.store');
            Route::post('department/{id}/update', [App\Http\Controllers\Painel\Obras\DepartmentController::class, 'update'])->name('departments.update');
            Route::delete('department/{id}/destroy', [App\Http\Controllers\Painel\Obras\DepartmentController::class, 'destroy'])->name('departments.destroy');

            /*
            |--------------------------------------------------------------------------
            | Concessionaria
            |--------------------------------------------------------------------------
            */
            Route::resource('concessionarias', App\Http\Controllers\Painel\Obras\ConcessionariaController::class);

            /*
            |--------------------------------------------------------------------------
            | Concessionaria X Serviço
            |--------------------------------------------------------------------------
            */
            Route::get('concessionarias/{concessionaria_id}/service/{service_id}', [App\Http\Controllers\Painel\Obras\ConcessionariaServiceController::class, 'index'])->name('concessionaria.service');
            Route::post('concessionarias/{concessionaria_id}/service/store', [App\Http\Controllers\Painel\Obras\ConcessionariaServiceController::class, 'concessionaria_service_store'])->name('concessionaria.service.store');
            Route::delete('concessionarias/{consessionaria_id}/service/{service_id}/destroy', [App\Http\Controllers\Painel\Obras\ConcessionariaServiceController::class, 'concessionaria_service_destroy'])->name('concessionaria.service.destroy');
            Route::post('concessionarias/{concessionaria_id}/service/{service_id}/etapas/store', [App\Http\Controllers\Painel\Obras\ConcessionariaServiceController::class, 'concessionaria_service_etapa_store'])->name('concessionaria.service.etapa.store');
            Route::post('concessionarias/{concessionaria_id}/service/{service_id}/etapas/destroy', [App\Http\Controllers\Painel\Obras\ConcessionariaServiceController::class, 'concessionaria_service_etapa_destroy'])->name('concessionaria.service.etapa.destroy');
            Route::post('concessionarias/{concessionaria_id}/service/{service_id}/etapas/reorder', [App\Http\Controllers\Painel\Obras\ConcessionariaServiceController::class, 'concessionaria_service_etapa_reorder'])->name('concessionaria.service.etapa.reorder');

            Route::post('etapas/tipo/store', [App\Http\Controllers\Api\EtapasApiController::class, 'store_tipo'])->name('etapas.tipo.store');
            /*
            |--------------------------------------------------------------------------
            | Etapas
            |--------------------------------------------------------------------------
            */
            Route::resource('etapas', App\Http\Controllers\Painel\Obras\Etapas\EtapaController::class);
            Route::delete('comercial/etapasFinanceiro/{etapa_id}/destroy', [App\Http\Controllers\Painel\Obras\Etapas\EtapaController::class, 'etapas_financeiro_destroy'])->name('comercial.etapas.financeiro.store');;


            /*
            |--------------------------------------------------------------------------
            | Variaveis
            |--------------------------------------------------------------------------
            */
            Route::resource('variables', App\Http\Controllers\Painel\Obras\Etapas\VariableController::class);
            Route::delete('variables/{variable_id}/destroy', [App\Http\Controllers\Painel\Obras\Etapas\VariableController::class, 'destroy'])->name('variable.destroy');
            Route::get('api/etapas', [App\Http\Controllers\Api\EtapasApiController::class, 'all'])->name('etapas.all');
            Route::get('api/concessionarias/{concessionaria_id}/service/{service_id}/etapas/all', [App\Http\Controllers\Api\EtapasApiController::class, 'etapasInConSev'])->name('concessionaria.service.destroy.etapas.all');
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
        Route::get('vehicles/drivers/all', [App\Http\Controllers\Painel\VehiclesController::class, 'drivers'])->name('drivers.index');
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
        Route::delete('vehicles/{id}/document/destroy', [App\Http\Controllers\Painel\VehiclesController::class, 'document_destroy'])->name('vehicles.document.destroy');
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
    Route::get('v/{vehicle_id}/qr', [App\Http\Controllers\Painel\VehiclesController::class, 'qrcode']);
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

    /*
    |--------------------------------------------------------------------------
    | Celulares
    |--------------------------------------------------------------------------
    */
    Route::resource('celulares', App\Http\Controllers\Painel\CelularesController::class);

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    //Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notification');
    //Route::get('/notify/sendTest', [App\Http\Controllers\NotificationController::class, 'notifyUsersTest'])->name('notifications.send.test');
    //Route::get('/notifications/{uuid}/read', [App\Http\Controllers\NotificationController::class, 'read'])->name('notifications.read');
    //Route::get('/notifications/{uuid}/archived', [App\Http\Controllers\NotificationController::class, 'archived'])->name('notifications.archived');
    //Route::get('/notifications/{uuid}/deleted', [App\Http\Controllers\NotificationController::class, 'deleted'])->name('notifications.deleted');
    //Route::get('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'readAll'])->name('notifications.read.all');

    /*
    |--------------------------------------------------------------------------
    | Task
    |--------------------------------------------------------------------------
    */
    Route::resource('tasks', App\Http\Controllers\Api\TaskController::class);

    /*
    |--------------------------------------------------------------------------
    | RDSE
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'role:rdse'], function () {
        Route::prefix('rdse')->group(function () {
            Route::put('rdse/status/{status}', [App\Http\Controllers\Painel\RDSE\RdseController::class, 'updateStatus'])->name('rdse.update.status');
            Route::get('rdse/{rdseId}/duplicate', [App\Http\Controllers\Painel\RDSE\RdseController::class, 'duplicateRdse'])->name('rdse.duplicate');
            Route::resource('rdse', App\Http\Controllers\Painel\RDSE\RdseController::class);
            Route::resource('modelo-rdse', App\Http\Controllers\Painel\RDSE\ModelosRdseController::class);
            Route::resource('handswork', App\Http\Controllers\Painel\RDSE\HandsworkController::class);

            Route::get('modelo-rdse/{modeloId}/create-rdse', [App\Http\Controllers\Painel\RDSE\ModelosRdseController::class, 'createRdseByModelo'])->name('modelo.rdse.create');
            Route::post('rdse/obra/{obraId}/store', [App\Http\Controllers\Painel\RDSE\RdseController::class, 'createRdseByObra'])->name('rdse.obra.create');
            Route::get('rdse/{rdseId}/partial', [App\Http\Controllers\Painel\RDSE\RdseController::class, 'addPartialRdse'])->name('rdse.service.partial.store');
        });
    });

    Route::group(['middleware' => 'role:desenvolvedor'], function () {
        Route::prefix('dev')->group(function () {
            Route::get('/', [App\Http\Controllers\Painel\DesenvolvedorController::class, 'index'])->name('dev.index');
            Route::get('/clients/password', [App\Http\Controllers\Painel\DesenvolvedorController::class, 'clientsAlterPassword'])->name('dev.alter.pass.clients');
            Route::post('/updateNameAllEmployee', [App\Http\Controllers\Painel\DesenvolvedorController::class, 'alterNameAllEmployees'])->name('dev.alter.name.all.employee');
            Route::post('/deleteAllEmployee', [App\Http\Controllers\Painel\DesenvolvedorController::class, 'deleteAllEmployees'])->name('dev.delete.name.all.employee');
            Route::post('/deleteDocAuditory', [App\Http\Controllers\Painel\DesenvolvedorController::class, 'deleteDocAuditory'])->name('dev.delete.doc.auditory');
            Route::post('/alterDocAuditory', [App\Http\Controllers\Painel\DesenvolvedorController::class, 'alterDocAuditory'])->name('dev.alter.doc.auditory');
        });
    });
});

Route::get('/cron', function () {
    //Artisan::call("command:carReview");
    Artisan::call("schedule:run");
});

Route::get('v1/api/celulares', [App\Http\Controllers\Api\TableApiController::class, 'celulares'])->name('celulares.all');
#Route::get('v1/api/getObraByNumberNota/{nNota}', [App\Http\Controllers\Api\BaseController::class, 'getObraByNumberNota']);
