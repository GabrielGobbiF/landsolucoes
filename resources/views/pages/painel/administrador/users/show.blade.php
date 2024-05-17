@extends('app')

@section('title', 'Editar Usuário')

@section('content')
    <div class="container">
        <h4 class="text-center">{{ $user->name ?? '' }} </h4>
        <div class="card mt-3">
            <ul class="nav nav-tabs nav-tabs_user" id="myTab_user" role="tablist">
                <li class="nav-item">
                    <a class="nav-link nav-link_user active" id="dados-tab" data-toggle="tab" href="#dados" role="tab"
                        aria-controls="dados" aria-selected="true">Cadastro</a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link nav-link_user" id="documentos-tab" data-toggle="tab" href="#documentos" role="tab"
                        aria-controls="documentos" aria-selected="false">Permissões</a>
                </li>-->
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane tab-pane_user fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                    <form role="form" class="needs-validation" novalidate id="form" enctype="multipart/form-data" autocomplete="off"
                        action="{{ route('users.update', $user->uuid) }}" method="POST">
                        @method('PUT')
                        @include('pages.painel.administrador._partials.form_users')
                    </form>
                </div>
                <div class="tab-pane tab-pane_user fade" id="documentos" role="tabpanel" aria-labelledby="documentos-tab"></div>
            </div>
        </div>
    </div>
@stop
