@extends('pages.painel.rh.app')

@section('title', 'Relátorio')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
            <h1 class="h2">Relátorios</h1>
        </div>

        <form action="{{ route('relatorio.employee.search') }}" class="form" method="GET">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Funcionário</label>
                                <select name="filter[funcionario]" class="form-control select2">
                                    <option value="">Todos</option>
                                    @foreach ($employees as $employee)
                                        <option
                                            {{ isset($filters['filter']['funcionario']) && $filters['filter']['funcionario'] == $employee->name ? 'selected' : '' }}
                                            value="{{ $employee->name }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!--<div class="col-md-3">
                            <div class="form-group">
                                <label for="input--cargo">Pendência</label>
                                <select name="filter[pendencia]" class="form-control select2">
                                    <option
                                        {{ isset($filters['filter']['pendencia']) && $filters['filter']['pendencia'] == '' ? 'selected' : '' }}
                                        value="">Todas</option>
                                    <option
                                        {{ isset($filters['filter']['pendencia']) && $filters['filter']['pendencia'] == 'pendencia' ? 'selected' : '' }}
                                        value="pendencia">Somente Pendência</option>
                                </select>
                            </div>
                        </div>-->

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="input--cargo">Tipo de Auditoria</label>
                                <select name="filter[tipo_auditoria]" class="form-control select2">
                                    <option
                                        {{ isset($filters['filter']['tipo_auditoria']) && $filters['filter']['tipo_auditoria'] == '' ? 'selected' : '' }}
                                        value="">Todas</option>
                                    <option
                                        {{ isset($filters['filter']['tipo_auditoria']) && $filters['filter']['tipo_auditoria'] == 'Entrevista' ? 'selected' : '' }}
                                        value="Entrevista">Entrevista</option>
                                    <option
                                        {{ isset($filters['filter']['tipo_auditoria']) && $filters['filter']['tipo_auditoria'] == 'Contratação' ? 'selected' : '' }}
                                        value="Contratação">Contratação</option>
                                    <option
                                        {{ isset($filters['filter']['tipo_auditoria']) && $filters['filter']['tipo_auditoria'] == 'acompanhamento' ? 'selected' : '' }}
                                        value="acompanhamento">Acompanhamento Mensal</option>
                                    <option
                                        {{ isset($filters['filter']['tipo_auditoria']) && $filters['filter']['tipo_auditoria'] == 'Cursos' ? 'selected' : '' }}
                                        value="Cursos">Cursos</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>

        @if (count($results) > 0)
            <table id="table" class="table table-hover table-striped mt-3">

                @foreach ($results as $employee)
                    <tr class="">
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->auditory }} Pendência(s)</td>
                        <td>
                            <a href="{{route('employees.show', $employee->uuid)}}" data-toggle="tooltip" data-placement="top" title="Visualizar"
                                class="btn btn-xs btn-dark"> <i class="fa fa-info"></i>
                            </a>
                        </td>

                    </tr>
                @endforeach

            </table>
        @endif
    </div>

@endsection
