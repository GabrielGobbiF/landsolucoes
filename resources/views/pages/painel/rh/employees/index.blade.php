@extends('app')

@section('title', 'Funcionários')

@section('sidebar')
    <div class="d-flex justify-content-between">
        <div>
            <h3> @yield("title", "") </h3>
            <ol class="breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-item">
                    <li class="tx-15">Home</li>
                </a>
                <li class="breadcrumb-item active tx-15">Funcionários</li>
            </ol>
        </div>
        <div class="page-button-box">
            <a href="{{ route('employees.create') }}" data-toggle="tooltip" data-placement="top" title="Novo" class="btn btn-outline-primary"><i class="fas fa-user-plus"></i>
                Adicionar Funcionário
            </a>
        </div>
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table table-api">
                <div class="table-responsive d-none">
                    <table data-toggle="table" id="table-api" data-table="employees">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-width="10%" data-width-unit="%" data-sortable="true" data-visible="false">#</th>
                                <th data-field="name" data-sortable="true">Nome</th>
                                <th data-field="rg" data-visible="false">RG</th>
                                <th data-field="email">Email</th>
                                <th data-field="endereco">Endereço</th>
                                <th data-field="cargo" data-visible="false">Cargo</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('pages.painel._partials.modals.modal-add', ['redirect'=>'client.index', 'type' => 'employees', 'modalSize' => 'modal-lg'])

@stop
