@extends('app')

@section('title', 'Funções')

@section('sidebar')
    <div class="d-flex justify-content-between">
        <div>
            <h3> @yield("title", "") </h3>
            <ol class="breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-item">
                    <li class="tx-15">Home</li>
                </a>
                <li class="breadcrumb-item active tx-15">Funções</li>
            </ol>
        </div>
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th data-align="left">Nome</th>
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td style="text-align:left">{{ $role->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route("roles.show", $role->id) }}" data-toggle="tooltip" data-placement="top"
                                            title="Visualizar" class="btn btn-xs btn-dark ">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Deletar"
                                            onclick="delete_row(this)" data-href="{{ route("roles.destroy", $role->id) }}"
                                            class="btn btn-xs btn-danger btn-delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

