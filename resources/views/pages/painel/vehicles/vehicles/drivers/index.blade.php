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
                </tr>
            </thead>
            <tbody>
                @foreach ($drivers as $driver)
                    <tr class="text-center">
                        <td style="text-align:left">{{ $driver->name }}</td>
                        <td style="text-align:left">{{ $driver->username }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
