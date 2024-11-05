@extends('app')

@section('title', 'Editar - ' . ucfirst($encarregado->description))

@section('content')

    <div class='card'>
        <div class='card-body'>
            <form id="form-encarregados" role="form" class="needs-validation" novalidate autocomplete="off"
                  action="{{ route('encarregados.update', $encarregado->id) }}" method="POST">
                <div class="box-body">
                    @csrf
                    @method('put')
                    @include('pages.painel._partials.forms.form-encarregados')
                    <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@stop
