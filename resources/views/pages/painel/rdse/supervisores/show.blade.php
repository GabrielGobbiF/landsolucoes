@extends('app')

@section('title', 'Editar - ' . ucfirst($supervisor->description))

@section('content')

    <div class='card'>
        <div class='card-body'>
            <form id="form-supervisores" role="form" class="needs-validation" novalidate autocomplete="off"
                  action="{{ route('supervisores.update', $supervisor->id) }}" method="POST">
                <div class="box-body">
                    @csrf
                    @method('put')
                    @include('pages.painel._partials.forms.form-supervisores')
                    <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@stop
