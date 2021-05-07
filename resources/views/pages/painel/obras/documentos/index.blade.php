@extends('pages.painel.obras.app')

@section('title', 'Obras')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Documentos</h1>
            <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right"></div>
        </div>

        <div id="toolbar">
            <div class="form-inline" role="form">
                <div class="btn-group mr-2">
                    <a href="{{ route('employees.create') }}" data-toggle="tooltip" data-placement="top" title="Novo" class="btn btn-dark"><i class="fas fa-user-plus"></i>
                        Novo</a>
                </div>
            </div>
        </div>

        @if (1 == 2)
            <table data-toggle="table" id="table" class="table table-hover table-striped" data-search="true" data-show-refresh="true" data-show-fullscreen="true"
                data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true" data-click-to-select="true"
                data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-cookie="true"
                data-cookie-id-table="employee" data-toolbar="#toolbar" data-click-to-select="true" data-buttons-class="dark">
                <thead>
                    <tr class="text-center">
                        <th data-field="state" data-checkbox="true"></th>
                        <th data-align="left">Nome</th>
                        <th class="mobile--hidden">RG</th>
                        <th class="mobile--hidden">Email</th>

                        <th class="mobile--hidden" data-visible="false">Endereco</th>
                        <th class="mobile--hidden" data-visible="false">Cargo</th>
                        <th class="mobile--hidden" data-visible="false">Ctps</th>

                        <th>Ação</th>
                    </tr>
                </thead>

                </tbody>
            </table>
        @endif
    </div>

@endsection
