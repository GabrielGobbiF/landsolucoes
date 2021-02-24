@extends('pages.painel.vehicles.app')

@section('title', 'Veiculos')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Motoristas</h1>
            <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right"></div>
        </div>

        <div id="toolbar">
            <div class="form-inline" role="form">
                <div class="btn-group mr-2">
                    <a href="{{ route('vehicles.drivers.create') }}" data-toggle="tooltip" data-placement="top" title="Novo" class="btn btn-dark"><i class="fas fa-truck"></i>
                        Novo</a>
                </div>
            </div>
        </div>

        <table data-toggle="table" id="table" class="table table-hover table-striped" data-search="true" data-show-refresh="true"
            data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true"
            data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-cookie="true"
            data-cookie-id-table="employee" data-toolbar="#toolbar" data-buttons-class="dark">
            <thead>
                <tr class="text-center">
                    <th data-align="left">Nome</th>
                    <th class="mobile--hidden">Username</th>
                    <th class="mobile--hidden">Status</th>
                    <th class="mobile--hidden">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($drivers as $driver)
                    <tr class="text-center">
                        <td style="text-align:left">{{ $driver->name }}</td>
                        <td style="text-align:left">{{ $driver->username }}</td>
                        <td>{!! $driver->is_active == 0
                            ? '<span class="badge badge-soft-success font-size-12">Ativo</span>'
                            : '<span
                                class="badge badge-soft-danger font-size-12">Desativado</span>' !!}</td>
                        <td>
                            <a href="JavaScript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Resetar Senha" data-href="{{ route('vehicles.drivers.password.reset', $driver->id) }}"
                                class="btn btn-xs btn-warning btn-delete"
                                data-original-title="Resetar">
                                <i class="fa fa-unlock-alt"></i>
                            </a>
                            <a href="{{ route('vehicles.drivers.show', [$driver->id]) }}" data-toggle="tooltip" data-placement="top" data-title="Ativar"
                                    class="btn btn-xs btn-dark"
                                    data-original-title="Editar Usuário">
                                    <i class="fa fa-edit"></i>
                                </a>
                            @if ($driver->is_active == '0')
                                <a href="JavaScript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Desativar"
                                    data-href="{{ route('vehicles.drivers.activeOrdesactive', [$driver->id, 'desactive' => true]) }}"
                                    class="btn btn-xs btn-danger btn-delete"
                                    data-original-title="Desativar Usuário">
                                    <i class="fa fa-times"></i>
                                </a>
                            @else
                                <a href="JavaScript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Ativar"
                                    data-href="{{ route('vehicles.drivers.activeOrdesactive', [$driver->id, 'desactive' => false]) }}"
                                    class="btn btn-xs btn-success btn-delete"
                                    data-original-title="Ativar Usuário">
                                    <i class="fa fa-plus"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
