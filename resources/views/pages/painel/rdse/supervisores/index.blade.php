@extends('app')

@section('title', 'Supervisores')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="form-inline" role="form">
                            <div class="btn-group mr-2">
                                <button type="button" data-toggle="modal" data-target="#modal-add-supervisores" class="btn btn-dark waves-effect waves-light">
                                    <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                                </button>
                            </div>
                        </div>
                    </div>
                    <table id="table-api" data-toggle="table" data-table="supervisores">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="name" data-sortable="true">Nome</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('pages.painel._partials.modals.modal-add', ['redirect' => 'supervisores.index', 'type' => 'supervisores'])

@endsection
