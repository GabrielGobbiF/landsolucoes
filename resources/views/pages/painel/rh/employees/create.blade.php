@extends('app')

@section('title', 'Cadastrar Funcionário')

@section('content')
    <div class="container">
        <h1 class="text-center">Novo Funcionário</h1>
        <div class="card mt-3">
            <form role="form" class="needs-validation" novalidate id="form" autocomplete="off" novalidate="novalidate" action="{{ route('employees.store') }}" method="POST">
                @include('pages.painel._partials.forms.form-employees')
            </form>
        </div>
    </div>
@stop
