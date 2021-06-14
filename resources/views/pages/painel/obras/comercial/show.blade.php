@extends("app")

@section('title', 'Comercial - ' . ucfirst($comercial->razao_social))

@section('content')
    <div class="container">
        <div class="box">
            <div class='box-body '>
                <form role="form-update-comercial" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('comercial.update', $comercial->id) }}" method="POST">
                    @csrf
                    @method("put")
                    @include("pages.painel._partials.forms.form_comercial", ['tab'=> true])
                    <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                </form>
            </div>

            <div class="box-body d-none">
                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Excluir Comercial" data-href="{{ route('comercial.destroy', $comercial->id) }}"
                    class="btn btn-xs btn-danger btn-delete float-left"
                    data-original-title="Excluir Cliente"><i class="fa fa-trash"></i> Excluir Obra
                </a>
            </div>
        </div>
    </div>
@stop
