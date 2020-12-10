@extends('pages.painel.vehicles.app')

@section('title', 'Editar Veiculo')

@section('content')
    <div class="container-fluid" style="    max-width: 1400px!important;">
        <h4 class="text-center">{{ $vehicle->name ?? '' }} </h4>
        <div class="row mt-3">
            <div class="col-md-2">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link mb-2 active" id="v-pills-dados-tab" data-toggle="pill" href="#v-pills-dados" role="tab" aria-controls="v-pills-dados" aria-selected="true">Dados</a>
                    <a class="nav-link mb-2" id="v-pills-activities-tab" data-toggle="pill" href="#v-pills-activities" role="tab" aria-controls="v-pills-activities" aria-selected="false">Atividades</a>
                    <a class="nav-link mb-2" id="v-pills-maintenance-tab" data-toggle="pill" href="#v-pills-maintenance" role="tab" aria-controls="v-pills-maintenance" aria-selected="false">Manutenção</a>
                    <a class="nav-link mb-2" id="v-pills-supply-tab" data-toggle="pill" href="#v-pills-supply" role="tab" aria-controls="v-pills-supply" aria-selected="false">Abrastecimento</a>
                    <!-- <a class="nav-link mb-2" id="v-pills-maintenance-tab" data-toggle="pill" href="#v-pills-maintenance" role="tab" aria-controls="v-pills-maintenance" aria-selected="false">Histórico</a> -->
                    <!--<a class="nav-link mb-2 " id="v-pills-new-tab" data-toggle="pill" href="#v-pills-new" role="tab" aria-controls="v-pills-new" aria-selected="false">Novo</a>-->
                    <div class="text-center">
                        <div class="col-md-12 mt-2">
                            <div class="card">
                                <div class="card-body text-center">
                                    @if (App::environment('production'))
                                        <img src="data:image/png;base64, {!!  base64_encode(
                                                QrCode::format('png')
                                                    ->size(150)
                                                    ->generate(route('vehicles.activitys.qrcode', $vehicle->id)),
                                            ) !!} ">
                                    @else
                                        {!! QrCode::size(150)->generate('ItSolutionStuff.com') !!}
                                    @endif

                                    <div class="mt-2">
                                        {{ $vehicle->board }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-dados" role="tabpanel" aria-labelledby="v-pills-dados-tab">
                        <div class="card">
                            <form role="form" class="needs-validation" novalidate id="form" autocomplete="off"
                                action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                                @method('PUT')
                                @include('pages.painel.vehicles._partials.form_vehicle')
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-activities" role="tabpanel" aria-labelledby="v-pills-activities-tab">
                        @include('pages.painel.vehicles._partials.table_activities')
                    </div>
                    <div class="tab-pane fade" id="v-pills-maintenance" role="tabpanel" aria-labelledby="v-pills-maintenance-tab">
                        @include('pages.painel.vehicles._partials.table_maintenance')
                    </div>
                    <div class="tab-pane fade" id="v-pills-supply" role="tabpanel" aria-labelledby="v-pills-supply-tab">
                        @include('pages.painel.vehicles._partials.table_supply')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
