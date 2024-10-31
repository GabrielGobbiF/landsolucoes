@extends('app')

@section('title', 'Atividade')

@section('content')

    <div class='card'>
        <div class='card-body'>

            <div class="mb-3">
                <a href="{{ route('rdse.show', $rdseAtividade->rdse_id) }}" >
                    <i class="fa-solid fa-arrow-left-long"></i>
                    Voltar
                </a>
            </div>

            <form id="form-handsworkes" role="form" class="needs-validation" novalidate autocomplete="off"
                  action="{{ route('rdse.atividades.update', $rdseAtividade->id) }}" method="POST">
                <div class="box-body">
                    @csrf
                    @method('put')
                    @include('pages.painel._partials.forms.form-rdse_atividades')
                    <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@stop
