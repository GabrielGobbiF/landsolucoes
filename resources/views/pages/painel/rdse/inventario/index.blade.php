@extends('app')

@section('title', 'Invetario')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="form-inline" role="form">
                            <div class="btn-group mr-2">
                                <button type="button" data-toggle="modal" data-target="#modal-add-inventories" class="btn btn-dark waves-effect waves-light">
                                    <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                                </button>
                            </div>
                        </div>
                    </div>
                    <table id="table-api" data-toggle="table" data-table="inventories">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-width="10%" data-width-unit="%" data-sortable="true" data-visible="false">#</th>
                                <th data-field="cod_item">Cód Item</th>
                                <th data-field="name">Nome</th>
                                <th data-field="unit">Unidade</th>
                                <th data-field="code_ncm">Cód NCM</th>
                                <th data-field="market_price">Preço Venda</th>
                                <th data-field="stock">Estoque</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('pages.painel._partials.modals.modal-add', ['redirect' => 'inventories.index', 'type' => 'inventories'])

@endsection
