@extends("app")

@section('title', 'Produtos')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="page-button-box">
                            <button class="btn btn-outline-primary" data-target="#modal-add-produtos" data-toggle="modal"><i class="fas fa-plus"></i> Adicionar Produto</button>
                        </div>
                    </div>
                    <table data-toggle="table" id="table-api" data-table="produtos">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="nome" data-sortable="true">Nome</th>
                                <th data-field="unidade" data-sortable="true">Unidade</th>
                                <th data-field="valor" data-sortable="true">Valor</th>
                                <th data-field="categoria" data-sortable="true">Categoria</th>
                                <th data-field="sub_categoria" data-sortable="true">Sub Categoria</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('pages.painel._partials.modals.modal-add', ['redirect'=>'produtos.index', 'type' => 'produtos', 'modalSize' => 'modal-lg'])

@stop
