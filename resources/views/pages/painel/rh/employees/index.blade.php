@extends('pages.painel.rh.app')

@section('title', 'Funcionários')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Funcionários</h1>
            <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right">

            </div>
        </div>

        <div id="toolbar">
            <div class="form-inline" role="form">
                <div class="btn-group mr-2">
                    <a href="{{ route('employees.create') }}" class="btn btn-dark"><i class="fas fa-user-plus"></i>
                        Novo</a>
                </div>
            </div>
        </div>


        <table data-toggle="table" id="table" data-search="true" data-show-refresh="true" data-show-fullscreen="true"
            data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true" data-click-to-select="true"
            data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-cookie="true"
            data-cookie-id-table="employee" data-toolbar="#toolbar">
            <thead>
                <tr class="text-center">
                    <th data-align="left">Nome</th>
                    <th class="mobile--hidden">RG</th>
                    <th class="mobile--hidden">Email</th>

                    <th class="mobile--hidden" data-visible="false">Endereco</th>
                    <th class="mobile--hidden" data-visible="false">Cargo</th>
                    <th class="mobile--hidden" data-visible="false">Ctps</th>

                    <th>Ação</th>
                </tr>
            </thead>
            @foreach ($employees as $employees)
                <tr class="text-center">
                    <td style="text-align:left">{{ $employees->name }}</td>
                    <td class="mobile--hidden">{{ $employees->rg }}</td>
                    <td class="mobile--hidden">{{ $employees->email }}</td>

                    <td class="mobile--hidden">{{ $employees->endereco }}</td>
                    <td class="mobile--hidden">{{ $employees->cargo }}</td>
                    <td class="mobile--hidden">{{ $employees->ctps }}</td>
                    <td>
                        <a href="{{ route('employees.show', $employees->uuid) }}" class="btn btn-xs btn-dark ">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ route('employees.destroy', $employees->uuid) }}" class="btn btn-xs btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
