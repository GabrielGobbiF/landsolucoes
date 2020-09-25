@extends('pages.painel.rh.app')

@section('title', 'Editar Funcionário')

@section('content')
    <div class="container">
        <h1 class="text-center">Editar Funcionário </h1>
        <div class="card">
            <form role="form" id="form" autocomplete="off" novalidate="novalidate" action="{{ route('employees.update', $employee->uuid) }}" method="POST">
                @method('PUT')
                @include('pages.painel.rh._partials.form_employee')
            </form>
        </div>
    </div>
@stop
