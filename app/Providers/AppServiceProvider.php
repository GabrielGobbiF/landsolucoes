<?php

namespace App\Providers;

use App\Managers\ApiBrasil\ApiBrasilAuth;
use App\Managers\ApiBrasil\Requests\ApiBrasilRequest;
use App\Models\{
    Documento,
    Employee,
    Pasta,
    Client,
    Concessionaria,
    Driver,
    Service,
    Tipo,
    Etapa,
    File,
    Obra,
    ObraFinanceiro,
    ObraEtapa,
    User,
    Visitor,
    EtapasFaturamento
};
use App\Models\RSDE\Handswork;
use App\Models\RSDE\RdseServices;
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
    ComercialObserver,
    DriverObserver,
    EtapasFaturamentoObserver,
    FileObserver,
    ObraFinanceiroObserver,
    HandworkObserver,
    ObraEtapaObserver,
    RdseServicesObserver,
    UserObserver,
    VisitorObserver,
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
        $this->app->bind(ApiBrasilRequest::class, function () {
            $accessToken = $params['access_token'] ?? null;
            if (!$accessToken) {
                $accessToken = $this->app->make(ApiBrasilAuth::class)->getAccessToken();
            }
            return new ApiBrasilRequest($accessToken);
        });
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
        ObraFinanceiro::observe(ObraFinanceiroObserver::class);
        ObraEtapa::observe(ObraEtapaObserver::class);
        RdseServices::observe(RdseServicesObserver::class);
        Handswork::observe(HandworkObserver::class);
        File::observe(FileObserver::class);
        User::observe(UserObserver::class);
        Visitor::observe(VisitorObserver::class);
        Driver::observe(DriverObserver::class);
        EtapasFaturamento::observe(EtapasFaturamentoObserver::class);

        $this->app->instance(IlluminateDatabaseChannel::class, new DataBaseChannel);
    }
}
