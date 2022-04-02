@extends('app')

@section('title', "RDSE'S")

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="form-inline" role="form">
                            <div class="btn-group mr-2">
                                <button type="button" data-toggle="modal" data-target="#modal-add-rdse" class="btn btn-dark waves-effect waves-light">
                                    <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                                </button>
                            </div>
                        </div>
                    </div>
                    <table data-toggle="table" id="table-api" data-table="rdses">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="n_order" data-sortable="true">Nº Ordem</th>
                                <th data-field="description">Descrição</th>
                                <th data-field="equipe" data-sortable="true">Equipe</th>
                                <th data-field="solicitante" data-sortable="true">Solicitante</th>
                                <th data-field="at" data-sortable="true">Data</th>
                                <th data-field="type" data-sortable="true">Tipo</th>
                                <th data-field="status_label">Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('pages.painel._partials.modals.modal-add', ['redirect' => 'rdse.index', 'type' => 'rdse'])

@endsection
