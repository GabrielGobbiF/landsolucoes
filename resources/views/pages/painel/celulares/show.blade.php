@extends("app")

@section('title', 'Celular - ' . ucfirst($celular->linha))

@section('content')
    <div class="box">
        <div class="box-body">
            <form role="form" class="needs-validation" novalidate id="form-celulares" autocomplete="off" action="{{ route('celulares.update', $celular->id) }}" method="POST">
                @csrf
                @method("put")
                @include("pages.painel._partials.forms.form-celulares")
                <div class="row">
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
