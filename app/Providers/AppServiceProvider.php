<?php

namespace App\Providers;

use App\Models\{
    Documento,
    Employee,
    Pasta,
    Client,
    Concessionaria,
    Service,
    Tipo,
    Etapa,
    Obra
};
use App\Notifications\DataBaseChannel;
use App\Observers\{
    EmployeeObserver,
    PastaObserver,
    DocumentoObserver,
    ClientObserver,
    ConcessionariaObserver,
    ServiceObserver,
    TipoObserver,
    EtapaObserver,
    ComercialObserver
};
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');

        Paginator::useBootstrap();

        Blade::component('package-menus', \App\View\Components\Menus::class);

        Schema::defaultStringLength(191);

        Employee::observe(EmployeeObserver::class);
        Pasta::observe(PastaObserver::class);
        Documento::observe(DocumentoObserver::class);
        Client::observe(ClientObserver::class);
        Concessionaria::observe(ConcessionariaObserver::class);
        Service::observe(ServiceObserver::class);
        Tipo::observe(TipoObserver::class);
        Etapa::observe(EtapaObserver::class);
        Obra::observe(ComercialObserver::class);

        $this->app->instance(IlluminateDatabaseChannel::class, new DataBaseChannel);
    }
}
