@extends('app')

@section('title', 'Veiculos Motoristas')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h2">Motoristas</h1>
                <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right"></div>
            </div>

            <div class="table table-responsive">
                <div id="toolbar">
                    <div class="form-inline" role="form">
                        <div class="btn-group mr-2">
                            <a href="{{ route('vehicles.drivers.create') }}" data-toggle="tooltip" data-placement="top"
                                title="Novo" class="btn btn-dark"><i class="fas fa-truck"></i>
                                Novo
                            </a>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-hover" data-toggle="table" id="table-api" data-table="drivers">
                    <thead>
                        <tr>
                            <th data-field="id" data-sortable="true" data-visible="false">#</th>
                            <th data-field="name" data-sortable="true">Nome</th>
                            <th data-field="username" data-halign="center" data-align="center" data-sortable="true">Username
                            </th>
                            <th data-field="cnh_number" data-halign="center" data-align="center" data-visible="false">CNH Nº
                            </th>
                            <th data-field="cnh_validity" data-halign="center" data-align="center" data-visible="false">CNH
                                Validade</th>
                            <th data-field="cnh_category" data-halign="center" data-align="center" data-visible="false">CNH
                                Categoria</th>
                            <th data-field="status" data-halign="center" data-align="center">Status</th>
                            <th data-field="statusButton" data-halign="center" data-align="center">Ação</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
