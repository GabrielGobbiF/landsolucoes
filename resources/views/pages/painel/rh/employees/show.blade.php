@extends('pages.painel.rh.app')

@section('title', 'Editar Funcionário')

@section('content')
    <div class="container">
        <h4 class="text-center">{{ $employee->name ?? '' }} </h4>
        <div class="card">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link " id="dados-tab" data-toggle="tab" href="#dados" role="tab"
                        aria-controls="dados" aria-selected="true">Informações</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="documentos-tab" data-toggle="tab" href="#documentos" role="tab"
                        aria-controls="documentos" aria-selected="false">Auditoria</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade " id="dados" role="tabpanel" aria-labelledby="dados-tab">
                    <form role="form" class="needs-validation" novalidate id="form" autocomplete="off"
                        action="{{ route('employees.update', $employee->uuid) }}" method="POST">
                        @method('PUT')
                        @include('pages.painel.rh._partials.form_employee')
                    </form>
                </div>
                <div class="tab-pane fade show active" id="documentos" role="tabpanel" aria-labelledby="documentos-tab">
                    @include('pages.painel.rh.employees.auditory')
                </div>
            </div>
        </div>
    </div>
@stop
