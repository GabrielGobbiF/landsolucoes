@extends('pages.painel.administrador.app')

@section('title', 'Funções')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Funções</h1>
            <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right"></div>
        </div>
        <table class="table">
            <thead>
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
                            <a href="{{ route('roles.show', $role->id) }}" data-toggle="tooltip" data-placement="top"
                                title="Visualizar" class="btn btn-xs btn-dark ">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Deletar"
                                onclick="delete_row(this)" data-href="{{ route('roles.destroy', $role->id) }}"
                                class="btn btn-xs btn-danger btn-delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
