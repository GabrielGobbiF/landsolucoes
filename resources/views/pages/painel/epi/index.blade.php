@extends('app')

@section('title', 'EPI')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="page-button-box">
                            <button class="btn btn-outline-primary" data-target="#modal-add-epi" data-toggle="modal">
                                <i class="fas fa-plus"></i>
                                Adicionar Epi
                            </button>
                        </div>
                    </div>
                    <table data-toggle="table" id="table-api" data-table="epi">
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

    @include('pages.painel._partials.modals.modal-add', ['redirect' => 'epi.index', 'type' => 'epi'])

@stop
