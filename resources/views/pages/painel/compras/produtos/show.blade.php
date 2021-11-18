@extends("app")

@section('title', 'Produto - ' . ucfirst($produto->name))

@section('content')
    <form role="form-update-produto" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('produtos.update', $produto->id) }}" method="POST">

        <div class="card">
            <div class="card-body">
                @csrf
                @method('PUT')

                <div class="col-md-12">
                    @include("pages.painel._partials.forms.form-produtos")
                </div>

                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                    <button type="button" class="btn btn-outline-danger js-btn-delete float-left" data-text="Excluir Produto" data-href="{{ route('produtos.destroy', $produto->id) }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>

@stop
