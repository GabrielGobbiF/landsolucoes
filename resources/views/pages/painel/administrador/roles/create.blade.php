@extends('app')

@section('title', 'Nova Função')

@section('content')
    <div class="container">
        <h1 class="text-center">Nova Função</h1>
        <div class="card mt-3">
            <form role="form" class="needs-validation" enctype="multipart/form-data" novalidate id="form" autocomplete="off" novalidate="novalidate" action="{{ route('roles.store') }}" method="POST">
                @include('pages.painel.administrador._partials.form_roles')
            </form>
        </div>
    </div>
@stop
