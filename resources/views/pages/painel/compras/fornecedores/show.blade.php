@extends("app")

@section('title', 'Fornecedor - ' . ucfirst($fornecedor->razao_social))

@section('content')
    <form role="form-update-fornecedor" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('fornecedor.update', $fornecedor->id) }}" method="POST">

        <div class="card">
            <div class="card-body">
                @csrf
                @method('PUT')

                <div class="col-md-12">
                    @include("pages.painel._partials.forms.form-fornecedores")
                </div>

                <div class="col-md-12">
                    <div class='form-group'>
                        <label>Linha de Atuação</label>
                        <select name='atuacao[]' class='form-control' id="select--linha_atuacao" multiple='multiple' data-create="{{ route('api.categories.store') }}" required>
                            @foreach ($atuacaoAll as $linha_atuacao)
                                <option {{ isset($fornecedorAtuacaoa) && in_array($linha_atuacao['name'], $fornecedorAtuacaoa) ? 'selected' : '' }} value='{{ $linha_atuacao['id'] }}'>
                                    {{ $linha_atuacao['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                    <button type="button" class="btn btn-primary js-btn-delete float-left" data-text="Excluir Fornecedor" data-href="{{ route('fornecedor.destroy', $fornecedor->id) }}"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-4">
                    <h4 class="card-title">Contato</h4>
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-primary waves-effect waves-light js-store--contato mr-2">
                            <i class="ri-add-circle-line align-middle"></i> <span class="ml-2 mobile--hidden"> Novo Contato</span>
                        </button>
                        <button type="button" class="btn btn-primary btn-submit store-contato-button">Salvar Contato(s)</button>
                    </div>
                </div>

                <div class="div-store-contato"></div>

                @foreach ($contatos as $contato)
                    @include("pages.painel._partials.forms.form-contato")
                @endforeach
            </div>
        </div>

    </form>

@stop

@section('scripts')

    <script>
        $('.js-store--contato').on('click', function() {
            let html = `
                <div class="row mt-2">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="input--nome">Nome</label>
                            <input type="text" name="contato[nome][]" class="form-control @error('nome') is-invalid @enderror"   autocomplete="off" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="input--email">Email</label>
                            <input type="text" name="contato[email][]" class="form-control @error('email') is-invalid @enderror"   autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-2">
                        <div class="form-group">
                            <label for="input--telefone">Telefone</label>
                            <input type="text" name="contato[telefone][]" class="form-control @error('telefone') is-invalid @enderror"  autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-2">
                        <div class="form-group">
                            <label for="input--celular">Celular</label>
                            <input type="text" name="contato[celular][]" class="form-control @error('celular') is-invalid @enderror"   autocomplete="off">
                        </div>
                    </div>
                </div>`;

            $('.div-store-contato').append(html);
            $('.store-contato-button').removeClass('d-none');

        })

        function addBySelect() {
            let v = $('#select--linha_atuacao');
            let collumn = v.parent().find('.select2-search__field').val();
            let url = v.attr('data-create');

            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'POST',
                data: {
                    name: collumn
                },
                dataType: 'json',
                success: function(j) {
                    var option = new Option(collumn, j, true, true);
                    v.append(option).trigger('change').trigger('close');
                    v.select2('close');
                    toastr.success('Adicionado com sucesso');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    toastr.error('Não foi possivel Adicionar');
                }
            });
        }

        $(document).ready(function() {

            $('#select--linha_atuacao').select2({
                placeholder: 'Selecione',
                closeOnSelect: false,
                multiple: true,
                language: {
                    noResults: function() {
                        return `<a href="javascript:void(0)" onclick="addBySelect()" style="padding: 6px;height: 20px;display: inline-table;">Sem resultados, Adicionar um novo?</a>`;
                    },
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });


        })
    </script>

@append
