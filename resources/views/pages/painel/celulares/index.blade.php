@extends('app')

@section('title', 'Celulares')

@section('sidebar')
    <div class="d-flex justify-content-between">
        <div>
            <h3> @yield("title", "") </h3>
            <ol class="breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-item">
                    <li class="tx-15">Home</li>
                </a>
                <li class="breadcrumb-item active tx-15">Celulares</li>
            </ol>
        </div>

    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="form-inline" role="form">
                            <div class="btn-group mr-2">
                                <button data-toggle='modal' data-target='#modal-add-celulares' class="btn btn-dark waves-effect waves-light"><i
                                        class="ri-add-circle-line align-middle mr-2"></i>
                                    Novo
                                </button>
                            </div>
                        </div>
                    </div>
                    <table data-toggle="table" id="table-api" data-table="celulares">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-width="10%" data-width-unit="%" data-sortable="true" data-visible="false">#</th>
                                <th data-field="linha">Linha</th>
                                <th data-field="responsavel" data-sortable="true">Responsavel</th>
                                <th data-field="usuario" data-sortable="true">Usuario</th>
                                <th data-field="equipe" data-sortable="true">Equipe</th>
                                <th data-field="departamento" data-sortable="true">Departamento</th>
                                <th data-field="imei" data-sortable="true" data-visible="false">Imei</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @include('pages.painel._partials.modals.modal-add', ['redirect'=>'celulares.index', 'type' => 'celulares'])

@stop
