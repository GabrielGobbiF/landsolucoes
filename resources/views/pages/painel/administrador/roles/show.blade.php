@extends('pages.painel.administrador.app')

@section('title', 'Editar Função')

@section('content')
    <div class="container">
        <h4 class="text-center">{{ $role->name ?? '' }} </h4>
        <div class="card mt-3">
            <ul class="nav nav-tabs nav-tabs_role" id="myTab_role" role="tablist">
                <li class="nav-item">
                    <a class="nav-link nav-link_role active" id="dados-tab" data-toggle="tab" href="#dados" role="tab"
                        aria-controls="dados" aria-selected="true">Dados</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane tab-pane_role fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                    <form role="form" class="needs-validation" novalidate id="form" enctype="multipart/form-data" autocomplete="off"
                        action="{{ route('roles.update', $role->id) }}" method="POST">
                        @method('PUT')
                        @include('pages.painel.administrador._partials.form_roles')
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
