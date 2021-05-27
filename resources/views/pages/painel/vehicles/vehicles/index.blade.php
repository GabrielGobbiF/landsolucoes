@extends('app')

@section('title', 'Veiculos')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h1 class="h2">Veiculos</h1>
                    <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right">
                        <div class="btn-group mr-2">
                            <a href="{{ route('vehicles.create') }}" data-toggle="tooltip" data-placement="top" title="Novo" class="btn btn-dark"><i class="fas fa-car"></i>
                                Novo</a>
                        </div>
                    </div>
                </div>

                <table data-toggle="table" id="table" class="table table-hover table-striped" data-search="true" data-show-refresh="true" data-show-fullscreen="true"
                    data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true"
                    data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-cookie="true"
                    data-cookie-id-table="employee" data-toolbar="#toolbar" data-buttons-class="dark">
                    <thead>
                        <tr class="text-center">
                            <th data-align="left">Nome</th>
                            <th class="mobile--hidden">Placa</th>
                            <th class="mobile--hidden">Ano</th>

                            <th class="mobile--hidden" data-visible="false">Renavam</th>
                            <th class="mobile--hidden" data-visible="false">Seguro</th>

                            <th>Ação</th>
                        </tr>
                    </thead>
                    @foreach ($vehicles as $vehicle)
                        <tr class="text-center">
                            <td style="text-align:left">{{ $vehicle->name }}</td>
                            <td class="mobile--hidden">{{ $vehicle->board }}</td>
                            <td class="mobile--hidden">{{ $vehicle->year }}</td>

                            <td class="mobile--hidden">{{ $vehicle->renavam }}</td>
                            <td class="mobile--hidden">{{ $vehicle->secure }}</td>
                            <td>
                                <a href="{{ route('vehicles.show', $vehicle->id) }}" data-toggle="tooltip" data-placement="top" title="Visualizar" class="btn btn-xs btn-dark ">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="JavaScript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Desativar"
                                    data-href="{{ route('vehicles.destroy', [$vehicle->id, 'desactive' => true]) }}"
                                    class="btn btn-xs btn-danger btn-delete"
                                    data-original-title="Desativar Carro">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
