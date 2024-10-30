@extends('app')

@section('title', 'Editar - ' . ucfirst($equipe->description))

@section('content')

    <div class='card'>
        <div class='card-body'>
            <form id="form-equipes" role="form" class="needs-validation" novalidate autocomplete="off" action="{{ route('equipes.update', $equipe->id) }}"
                  method="POST">
                <div class="box-body">
                    @csrf
                    @method('put')
                    @include('pages.painel._partials.forms.form-equipes')
                    <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@stop
