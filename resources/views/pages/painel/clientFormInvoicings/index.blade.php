@extends('app')

@section('title', 'Formulario de Faturamento de Clientes')

@section('sidebar')
    <div class="d-flex justify-content-between">
        <div>
            <h3> @yield('title', '') </h3>
            <ol class="breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-item">
                    <li class="tx-15">Home</li>
                </a>
                <li class="breadcrumb-item active tx-15">Formuário de Faturamento de Clientes</li>
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
                                <a href="{{ route('clients.form.invoicing') }}" class="btn btn-dark waves-effect waves-light">
                                    <i class="ri-add-circle-line align-middle mr-2"></i>
                                    Visualizar Formulário
                                </a>
                            </div>
                        </div>
                    </div>
                    <table id="table-api" data-toggle="table" data-table="clients-form-invoicing">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-width="10%" data-width-unit="%" data-sortable="true" data-visible="false">#</th>
                                <th data-field="cnpj">CNPJ</th>
                                <th data-field="razao_social" data-sortable="true">Razão Social</th>
                                <th data-field="nome_fantasia" data-sortable="true">Nome Fantasia</th>
                                <th data-field="email_financeiro" data-sortable="true">Email Financeiro</th>
                                <th data-field="email_engenheiro" data-sortable="true">Email Engenheiro</th>
                                <th data-field="nome_obra" data-sortable="true">Nome da obra</th>
                                <th data-field="endereco_obra" data-sortable="true">Endereço Obra</th>
                                <th data-field="telefones" data-sortable="true">Telefones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @include('pages.painel._partials.modals.modal-add', ['redirect' => 'celulares.index', 'type' => 'celulares'])

@stop
