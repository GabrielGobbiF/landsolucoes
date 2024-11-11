@extends('app')

@section('title', 'Editar - ' . ucfirst($tiposObra->description))

@section('content')

    <div class='card'>
        <div class='card-body'>
            <form id="form-tipos_obra" role="form" class="needs-validation" novalidate autocomplete="off" action="{{ route('tipos_obra.update', $tiposObra->id) }}"
                  method="POST">
                <div class="box-body">
                    @csrf
                    @method('put')
                    @include('pages.painel._partials.forms.form-tipos_obra')
                    <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@stop
