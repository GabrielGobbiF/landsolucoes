@extends('app')

@section('title', ucfirst($epi->name))

@section('content')
    <div class="box">
        <div class="box-body">
            <form role="form" class="needs-validation" novalidate id="form-epi" autocomplete="off"
                action="{{ route('epi.update', $epi->id) }}" method="POST">
                @csrf
                @method('put')
                @include('pages.painel._partials.forms.form-epi')
                <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
            </form>
        </div>
    </div>
@stop
