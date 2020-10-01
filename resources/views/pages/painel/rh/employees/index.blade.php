@extends('pages.painel.rh.app')

@section('title', 'Funcionários')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Funcionários</h1>
            <div class="btn-toolbar mb-2 mb-md-0 float-right">
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary mr-2">Exportar</button>
                    <a href="{{ route('employees.create') }}" class="btn btn-dark"><i class="fas fa-user-plus"></i>
                        Novo</a>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr class="text-center">
                    <th style="text-align:left">Nome</th>
                    <th class="mobile--hidden">RG</th>
                    <th class="mobile--hidden">Email</th>
                    <th>Ação</th>
                </tr>
            </thead>
            @foreach ($employees as $employees)
                <tr class="text-center">
                    <td style="text-align:left">{{ $employees->name }}</td>
                    <td class="mobile--hidden">{{ $employees->rg }}</td>
                    <td class="mobile--hidden">{{ $employees->email }}</td>
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
