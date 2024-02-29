@extends('app')

@section('title', 'Portaria')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table table-api">
                <div id="toolbar">
                    <div class="form-inline" role="form">
                        <div class="btn-group mr-2">
                            <button data-toggle="modal" data-target="#modal-add-visitors" class="btn btn-dark"><i class="fas fa-truck"></i>
                                Novo Visitante
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive d-none">
                    <table id="table-api" data-toggle="table" data-table="visitors">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="name">Nome</th>
                                <th data-field="company_name">Empresa</th>
                                <th data-field="finality">Finalidade</th>
                                <th data-field="document">Documento</th>
                                <th data-field="vehicle">Veiculo</th>
                                <th data-field="visitor_at">Dia</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('pages.painel._partials.modals.modal-add', ['redirect'=>'visitors.index', 'type' => 'visitors'])

@endsection
