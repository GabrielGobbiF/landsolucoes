@extends("app")

@section('title', 'Novo Orçamento')

@section('content-max-fluid')

    <style>
        .form-control.active {
            border: 1px solid green;
        }

        table thead tr th {

            width: 2% !important;
        }

    </style>

    <div class="row">

        @if (count($fornecedores) > 0)
            <div class="col-10">
                <div class="card">
                    <div class="card-body">

                        <div class="col-12 col-md-12">
                            @if (__trans('compras.orcamento.status.messages.' . $orcamento->status))
                                <div class="row mb-2 align-items-center">
                                    <div class="col-12 col-md-12">
                                        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                            <i class="mdi mdi-grease-pencil me-2"></i>
                                            {!! __('compras.orcamento.status.messages.' . $orcamento->status) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <div class="search-table-outter wrapper scrollbox table-responsive" style="overflow: auto;">
                                <div class="float-right">
                                    <a href="javascript:void(0)" class="" data-toggle='modal' data-target='#exampleModal'>Editar fornecedores</a>


                                </div>
                                <table class='table table-hover' style="font-size: 0.8rem;
                                                                                            font-weight: 200 !important;
                                                                                            font-family: system-ui;
                                                                                            width: 100%">
                                    <thead class='thead-light'>
                                        <tr>
                                            <th>Descrição</th>
                                            <th>Uni</th>
                                            <th>Quantidade</th>
                                            @foreach ($fornecedores as $fornecedor)
                                                <th class="tr__fornecedor-{{ $fornecedor->id }}">{{ limit($fornecedor->razao_social, 12) }}</th>
                                            @endforeach
                                            <th style="text-align: center;">Valor Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($itens as $item)
                                            <tr id="{{ $item->id }}">
                                                @if ($item->variables->count() > 0)
                                                    <th colspan="{{ count($fornecedores) + 4 }}">
                                                        <a href="javascript:void(0)" data-id="{{ $item->id }}" class="js-openClose__variable">{{ limit($item->nome, 30) }}</a>
                                                    </th>
                                                @else
                                                    <th>{{ limit($item->nome, 40) }}</th>
                                                    <th>{{ $item->unidade }}</th>
                                                    <th>
                                                        <input type="number" data-unidade="{{ $item->unidade }}" class="form-control qnt reset" min="1" name="qnt" required
                                                            value="0"
                                                            data-tr="{{ $item->id }}" value="{{ $item->quantidade }}">
                                                    </th>
                                                    @foreach ($fornecedores as $fornecedor)
                                                        <th class="tr__fornecedor-{{ $fornecedor->id }}">
                                                            <input type="text" style="max-width: 100%;" class="form-control money price reset" name="price" id="{{ $fornecedor->id }}"
                                                                data-tr="{{ $item->id }}" required
                                                                value="0">
                                                        </th>
                                                    @endforeach
                                                    <th class="text-center total">0</th>
                                                @endif
                                            </tr>

                                            @if ($item->variables->count() > 0)
                                                <div class="variables">
                                                    @foreach ($item->variables as $variable)
                                                        <tr id="{{ $item->id . $variable->id }}" class="div_variables--{{ $item->id }}">
                                                            <th>
                                                                <a href="javascript:void(0)" class="row-delete" data-tr="{{ $item->id . $variable->id }}">
                                                                    <i class="fas fa-trash tx-danger mr-3"></i>
                                                                </a>
                                                                {{ $variable->nome }}
                                                            </th>
                                                            <th>{{ $item->unidade }}</th>
                                                            <th>
                                                                <input type="number" data-unidade='{{ $item->unidade }}' class="form-control qnt reset" min="1" name="qnt"
                                                                    data-tr="{{ $item->id . $variable->id }}" required value="{{ $variable->quantidade ?? 0 }}">
                                                            </th>
                                                            @foreach ($fornecedores as $fornecedor)
                                                                <th class="tr__fornecedor-{{ $fornecedor->id }}">
                                                                    <input type="text" class="form-control money price reset" name="price" id="{{ $fornecedor->id }}"
                                                                        data-tr="{{ $item->id . $variable->id }}" required value="0">
                                                                </th>
                                                            @endforeach
                                                            <th class="text-center total">0</th>
                                                        </tr>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12 d-none">
                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                            <button type="button" class="btn btn-outline-danger js-btn-delete float-left" data-text="Excluir Produto" data-href="{{ route('produtos.destroy', $produto->id ?? '') }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2 d-none">

                <div class='card'>
                    <div class='card-body'>
                        <button class="btn btn-primary"><i class="fas fa-edit"></i> Pedir Aprovação</button>
                        <button class="btn btn-warning"><i class="fas fa-edit"></i> Relátorio</button>
                    </div>
                </div>


                <div class='card  d-none'>
                    <div class='card-body'>
                        <h4>Preencher</h4>
                        @foreach ($unidades as $unidade => $produtos)
                            @if ($unidade != '')
                                <div class='form-group'>
                                    <label>{{ $unidade }}</label>
                                    <input type='text' class='form-control js-complete-unidade' data-unidade='{{ $unidade }}' autocomplete='off'>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="card-body">
                        <div id="div-etapas">
                            <div class="d-flex justify-content-between mb-2">
                                <input type="text" class="form-control wd-250" name="search-etapa" id="search-etapa" value="" placeholder="Pesquisar">
                                <button class="btn btn-primary btn-new-store">Novo Produto</button>
                            </div>

                            <div class="no-padding table-responsive d-none" style="max-height: 293px;overflow-x: hidden !important;">
                                <table id="table-etapas" class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th class="text-center" width="8%">Ação</th>
                                            <!--<th>#</th>-->
                                            <th>Produto</th>
                                        </tr>
                                    </tbody>
                                    <tbody id="results-table"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12">
                <div class='card'>
                    <div class='card-body d-grid text-center'>
                        <span>Não existe nenhum fonecedor com a categoria "{{ $categoria }}"</span>
                        <div class="row justify-content-center mt-4">
                            <div class="col-3">
                                <label>Selecione a categoria</label>
                                <select name='categoria' id="select__categoria" class='form-control select2' required>
                                    @foreach ($categorias as $atuacao)
                                        <option {{ request()->input('categoria') && request()->input('categoria') == $atuacao->name ? 'selected' : '' }} value='{{ $atuacao->name }}'>
                                            {{ $atuacao->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class='modal' id='exampleModal' tabindex='-1' role='dialog'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Fornecedores</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <ul class="message-list">
                        @foreach ($fornecedores as $fornecedor)
                            <li class="">
                                <div class="col-mail col-mail-1">
                                    <div class="checkbox-wrapper-mail">
                                        <input type="checkbox" id="chk{{ $fornecedor->id }}" data-id="{{ $fornecedor->id }}" class="select--fornecedor" checked>
                                        <label class="form-label" for="chk{{ $fornecedor->id }}"></label>
                                    </div>
                                    <a href="#" class="title"> {{ $fornecedor->razao_social }}</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-primary btn-submit'>Salvar</button>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

    <script>
        $(document).ready(function() {
            let click = 0;
            let timeButtonConfirm = 0;

            $('.row-delete').on('click', function(e) {
                e.preventDefault();
                const btn = $(this);
                click++;

                btn.html('<i class="fa fa-exclamation-circle mr-3"></i>');
                btn.addClass("js-click-to-confirm");

                if (click == 2) {
                    let findTr = $(this).attr('data-tr');
                    let tr = $(`tr[id="${findTr}"]`);
                    tr.remove();
                    click = 0;
                }

                clearTimeout(timeButtonConfirm);
                timeButtonConfirm = setTimeout(function() {
                    btn.html('<i class="fa fa-trash mr-3"></i>');
                    btn.removeClass("js-click-to-confirm");
                    click = 0;
                }, 1900);
            });


            $('.reset').on('focus click', function() {
                $(this).val() == '0' ? $(this).val('') : null
            })

            $('.reset').on('focusout', function() {
                $(this).val() == '' ? $(this).val('1') : null
            })

            $('.qnt').on('change', function() {
                let findTr = $(this).attr('data-tr');
                let tr = $(`tr[id="${findTr}"]`);
                valorTotal(tr)
            })

            $('.price').on('change keyupd', function() {

                let findTr = $(this).attr('data-tr');
                let tr = $(`tr[id="${findTr}"]`);

                var arr = tr.find('.price').map(function() {
                    return {
                        'id': $(this).attr('id'),
                        'value': $(this).val(),
                    }
                }).get();

                var key;
                var value = 1000000;

                $.each(arr, function(idx, val) {
                    valindex = clearNumber(val.value.replace(".", ""));
                    // Se o valor atual da iteração é maior que o auxiliar
                    if (valindex != 0 && valindex < value) {
                        // Atualiza o valor da variável auxiliar
                        value = clearNumber(val.value);
                        // Atribue a nova key
                        key = val.id;
                    }
                });
                tr.find('.price').removeClass('active');
                tr.find(`#${key}`).addClass('active')

                valorTotal(tr);
            })


            function clearNumber(number) {
                number = number.toString().replace("R$", "").replace(".", "");
                number = number.replace(",", ".");
                return number != '' ? numeral(number).value() : 0;
            }

            function valorTotal(tr) {
                let qnt = tr.find('input[name="qnt"]').val();
                qnt = qnt == 0 ? 1 : parseFloat(qnt);

                var key;
                var value = 1000000;

                var arr = tr.find('.price').map(function() {
                    return {
                        'id': $(this).attr('id'),
                        'value': $(this).val(),
                    }
                }).get();

                $.each(arr, function(idx, val) {
                    valindex = clearNumber(val.value.replace(".", ""));
                    // Se o valor atual da iteração é maior que o auxiliar
                    if (valindex != 0 && valindex < value) {
                        // Atualiza o valor da variável auxiliar
                        value = clearNumber(val.value);
                        // Atribue a nova key
                        key = val.id;
                    }
                });
                let price = tr.find(`#${key}`).val()

                if (price != undefined) {
                    let total = clearNumber(price.replace(".", "")) * qnt;
                    tr.find('.total').html(`R$ ${numberFormat(total)}`)
                }
            }

            function numberFormat(number) {
                return number.toLocaleString('pt-br', {
                    minimumFractionDigits: 2
                })
                //return new Intl.NumberFormat('pt-BR', {
                //    //style: 'currency',
                //    currency: 'BRL',
                //}).format(number);
            }


            $('.js-openClose__variable').on('click', function() {
                let id = $(this).attr('data-id');
                $(`.div_variables--${id}`).toggleClass('d-none');
            })

            $('.js-complete-unidade').on('change', function() {
                $(this).val() == '' ? $(this).val('1') : null

                let unidade = $(this).attr('data-unidade');
                let value = $(this).val();

                $(`input[data-unidade='${unidade}']`).val(value);
            })

            $('#select__categoria').on('change', function() {
                const url = $('meta[name="url"]').attr('content');
                let val = $(this).val();
                window.location.href = `${url}?categoria=${val}`;
            })







            //Produtos
            initTableEtapas()

            let time_search_produtos = null;

            $('#search-etapa').on('keyup', function() {
                clearTimeout(time_search_produtos);
                time_matchs = setTimeout(function() {
                    initTableEtapas();
                }, 1200);
            });

            function initTableEtapas() {
                var data = $('#tipo').select2('data');
                var search = $('#search-etapa').val();
                $.ajax({
                    url: `{{ route('etapas.all') }}`,
                    type: 'GET',
                    ajax: true,
                    data: {
                        tipo: '4',
                        search: search,
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        var options = '';
                        if (data.length != 0) {
                            $.each(data.data, function(index, value) {
                                options += '<tr>';
                                options +=
                                    '<td class="buttons"><button onclick="this.disabled = true;add_to_orcamento(' + value.id +
                                    ', this)" class="btn btn-sm btn-dark"><i class="fas fa-arrow-left"></i> <span class="mobile--hidden"></span></button></td>';
                                //options += '    <td class="text-center"><i class="fa fa-edit" onclick="edit_etapa(' + value.id + ')"></i></td>';
                                options += '    <td>' + value.name + '</td>';
                                options += '</tr>';
                            });
                        }
                        $('#results-table').html(options);
                        $('#preloader-content-table').addClass('d-none');
                        $('.table-responsive').removeClass('d-none');
                        $('#div-etapas').removeClass('d-none');
                    },
                });
            }

            function add_to_orcamento(id, v) {
                $(v).attr("disabled", true);
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: 'POST',
                    data: {
                        etapa_id: id,
                    },
                    dataType: 'json',
                    success: function(response) {
                        initDiv();
                        initEtapas();
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        toastr.error(thrownError);
                    }
                });
            }

            $('.select--fornecedor').on('click', function() {

                let fornecedorId = $(this).attr('data-id');

                if ($(this).is(':checked')) {
                    $(`.tr__fornecedor-${fornecedorId}`).removeClass('d-none')
                } else {
                    $(`.tr__fornecedor-${fornecedorId}`).addClass('d-none')
                }

            })



        })
    </script>
@append
