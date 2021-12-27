@extends("app")

@section('title', 'Produto - ' . ucfirst($produto->name))

@section('content')
    <form role="form-update-produto" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('produtos.update', $produto->id) }}" method="POST">

        <div class="card">
            <div class="card-body">

                @csrf
                @method("PUT")

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

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-4">
                    <h4 class="card-title">Variáveis</h4>
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-primary waves-effect waves-light js-store--variable mr-2">
                            <i class="ri-add-circle-line align-middle"></i> <span class="ml-2 mobile--hidden"> Nova Variável</span>
                        </button>
                        <button type="button" class="btn btn-primary btn-submit store-variable-button">Salvar Variáveis(s)</button>
                    </div>
                </div>

                <div class="div-store-variable"></div>

                @foreach ($produto->variables as $variable)
                    @include("pages.painel._partials.forms.form-etapa-variable")
                @endforeach
            </div>
        </div>
    </form>

@stop

@section('scripts')
    <script>
        $('.js-store--variable').on('click', function() {
            let html = `
                <div class="row mt-2">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="input--name">Nome</label>
                            <input type="text" name="variable[name][]" class="form-control @error('name') is-invalid @enderror"   autocomplete="off" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-2">
                        <div class="form-group">
                            <label for="input--price">Preço</label>
                            <input type="text" name="variable[price][]" class="form-control @error('price') is-invalid @enderror money"  autocomplete="off" required>
                        </div>
                    </div>

                </div>`;

            $('.div-store-variable').append(html);
            $('.store-variable-button').removeClass('d-none');

        })
    </script>
@append
