@extends('app')

@section('title', 'Usuários')

@section('sidebar')
    <div class="d-flex justify-content-between">
        <div>
            <h3> @yield('title', '') </h3>
            <ol class="breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-item">
                    <li class="tx-15">Home</li>
                </a>
                <li class="breadcrumb-item active tx-15">Usuários</li>
            </ol>

        </div>
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Novo Usuário</a>

            <div class="table table-api">
                <div class="table-responsive d-none">
                    <table data-toggle="table" id="table-api" data-table="users_table">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-width="10%" data-width-unit="%" data-sortable="true"
                                    data-visible="false">#</th>
                                <th data-field="name" data-sortable="true">Nome</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
