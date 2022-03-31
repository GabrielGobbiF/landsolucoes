@extends('app')

@section('title', 'Mãos de Obra')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="form-inline" role="form">
                            <div class="btn-group mr-2">
                                <button type="button" data-toggle="modal" data-target="#modal-add-handswork" class="btn btn-dark waves-effect waves-light">
                                    <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                                </button>
                            </div>
                        </div>
                    </div>
                    <table data-toggle="table" id="table-api" data-table="handswork">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="code" data-sortable="true">Código</th>
                                <th data-field="description" data-sortable="true">Descrição</th>
                                <th data-field="price_ups">Preço UPS</th>
                                <th data-field="price" data-sortable="true">Preço</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('pages.painel._partials.modals.modal-add', ['redirect' => 'handsworks.index', 'type' => 'handswork'])

@endsection
