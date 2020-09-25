@extends('pages.painel.rh.app')

@section('title', 'Cadastrar Funcionário')

@section('content')
    <div class="container">
        <h1 class="text-center">Novo Funcionário</h1>
        <div class="card mt-5">
            <form role="form" id="form" autocomplete="off" novalidate="novalidate" action="{{ route('employees.store') }}" method="POST">
                @include('pages.painel.rh._partials.form_employee')
            </form>
        </div>
    </div>
@stop
