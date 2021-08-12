@extends('app')

@section('title', 'Editar Funcionário')

@section('content')
    <div class="container">
        <h4 class="text-center">{{ $employee->name ?? '' }} </h4>
        <div class="card mt-3">
            <ul class="nav nav-tabs nav-tabs_employee" id="myTab_employee" role="tablist">
                <li class="nav-item">
                    <a class="nav-link nav-link_employee active" id="dados-tab" data-toggle="tab" href="#dados" role="tab"
                        aria-controls="dados" aria-selected="true">Cadastro</a>
                </li>
                @if (Auth::user()->can('view_employee_document_auditory'))
                    <li class="nav-item">
                        <a class="nav-link nav-link_employee" id="documentos-tab" data-toggle="tab" href="#documentos" role="tab"
                            aria-controls="documentos" aria-selected="false">Auditoria
                        </a>
                    </li>
                @endif
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane tab-pane_employee fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                    <form role="form" class="needs-validation" novalidate id="form" autocomplete="off"
                        action="{{ route('employees.update', $employee->uuid) }}" method="POST">
                        @method('PUT')
                        @include('pages.painel._partials.forms.form-employees')
                    </form>
                </div>
                @if (Auth::user()->can('view_employee_document_auditory'))
                    <div class="tab-pane tab-pane_employee fade" id="documentos" role="tabpanel" aria-labelledby="documentos-tab">
                        @include('pages.painel.rh.employees.auditory')
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('panel/js/pages/auditory.js') }}"></script>
@endsection
