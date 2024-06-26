@extends("app")

@section('title', 'Novo Fornecedor')

@section('content')
    <div class="card">
        <div class="card-body">
            <form role="form-create-fornecedor" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('fornecedor.store') }}" method="POST">
                @csrf

                <div class="col-md-12">
                    @include("pages.painel._partials.forms.form-fornecedores")
                </div>

                <div class="col-md-12">

                    <div class='form-group'>
                        <label>Linha de Atuação</label>
                        <select name='atuacao[]' class='form-control' id="select--linha_atuacao" data-create="{{ route('api.categories.store') }}" required>
                            @foreach ($atuacao as $linha_atuacao)
                                <option value='{{ $linha_atuacao->id }}'> {{ $linha_atuacao->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('scripts')
    <script>
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
