@extends('pages.painel.vehicles.app')

@section('title', 'Editar Veiculo')

@section('content')
    <div class="container">
        <h4 class="text-center">{{ $vehicle->name ?? '' }} </h4>
        <div class="card mt-3">
            <ul class="nav nav-tabs nav-tabs_vehicle" id="myTab_vehicle" role="tablist">
                <li class="nav-item">
                    <a class="nav-link nav-link_vehicle active" id="dados-tab" data-toggle="tab" href="#dados" role="tab"
                        aria-controls="dados" aria-selected="true">Dados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link_vehicle" id="documentos-tab" data-toggle="tab" href="#documentos" role="tab"
                        aria-controls="documentos" aria-selected="false">Manutenção</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link_vehicle" id="documentos-tab" data-toggle="tab" href="#documentos" role="tab"
                        aria-controls="documentos" aria-selected="false">Atividades</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane tab-pane_vehicle fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                    <form role="form" class="needs-validation" novalidate id="form" autocomplete="off"
                        action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                        @method('PUT')
                        @include('pages.painel.vehicles._partials.form_vehicle')
                    </form>
                </div>
                <div class="tab-pane tab-pane_vehicle fade" id="documentos" role="tabpanel" aria-labelledby="documentos-tab">
                </div>
            </div>
        </div>
    </div>
@stop
