@extends("app")

@section('title', 'Novo Comercial')

@section('content')
    <div class="container">
        <div class="box">
            <div class="box-body">
                <form role="form-create-comercial" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('comercial.store') }}" method="POST">
                    @csrf
                    @include("pages.painel._partials.forms.form_comercial")
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary btn-submit float-right">Avançar Financeiro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
