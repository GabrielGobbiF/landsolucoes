    @php
        $cadastro = isset($type) && $type == 'cadastro' ? 'd-none' : '';
    @endphp
    <div class="collapse {{ $cadastro == 'd-none' ? 'show' : '' }}" id="lista_compra">
        <div class="box box-default box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        @if (count($etapasCompras) > 0)
                            <div class="table-responsive">
                                <table class='table table-hover'>
                                    <thead class='thead-light'>
                                        <tr>
                                            <th>Nome</th>
                                            <th class="text-center">Quantidade</th>
                                            <th>Unidade</th>
                                            <th>Preço Uni.</th>
                                            <th>SubTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($etapasCompras as $etapa)
                                            @if ($etapa->variables->count() == 0)
                                                <tr id="{{ $etapa->id }}">
                                                    <th>{{ $etapa->nome }}</th>
                                                    <th style="width: 20%">
                                                        <div class="text-center">
                                                            <input type="number" min="0" name="etapa[{{ $etapa->id }}]" data-id="{{ $etapa->id }}" data-price="{{ $etapa->preco }}"
                                                                value="{{ $etapa->quantidade }}"
                                                                class="js-qntEtapa wd-70 text-center">
                                                        </div>
                                                    </th>
                                                    <th>{{ $etapa->unidade }}</th>
                                                    <th>R$ {{ $etapa->preco }}</th>
                                                    <th class="sub-total" data-value="{{ 
                                                    $etapa->quantidade * 
                                                    ($etapa->preco != '' ? $etapa->preco : 0) }}
                                                    "> R$
                                                        {{ $etapa->quantidade * ($etapa->preco != '' ? $etapa->preco : 0) }}
                                                    </th>
                                                </tr>
                                            @else
                                                <tr class="bd-t-0-f">
                                                    <th colspan="5">
                                                        <a style="color:#ff0000" data-toggle="collapse" href="#collapseExample{{ $etapa->id }}">{{ $etapa->nome }}</a>
                                                    </th>
                                                </tr>

                                                <tr class="bd-t-0-f">
                                                    <td class="collapse" style="border-top: none;padding:0px" colspan="5" id="collapseExample{{ $etapa->id }}">
                                                        <div style="position: relative;
                                                    border-radius: 12px;
                                                    margin-bottom: 20px;
                                                    box-shadow: rgb(0 0 0 / 10%) 0px 0px 1px;
                                                    border-left: 1px solid rgb(0, 0, 0);
                                                    border-right: 1px solid rgb(10, 10, 10);
                                                    border-bottom: 1px solid rgb(0, 0, 0);">
                                                            <table class="table">
                                                                <tbody>
                                                                    @foreach ($etapa->variables as $variable)
                                                                        <tr id="{{ $variable->id }}">
                                                                            <th style="width: 16%;">{{ $variable->nome }}</th>
                                                                            <th style="width: 20%">
                                                                                <div class="text-center">
                                                                                    <input type="number" name="variable[{{ $variable->id }}]" min="0" data-id="{{ $variable->id }}"
                                                                                        data-price="{{ $variable->preco }}"
                                                                                        value="{{ $variable->quantidade }}" class="js-qntEtapa wd-70 text-center">
                                                                                </div>
                                                                            </th>
                                                                            <th style="width: 20%;">{{ $etapa->unidade }}</th>
                                                                            <th>R$ {{ $variable->preco }}</th>
                                                                            <th class="sub-total" data-value="{{ $variable->quantidade * $variable->preco }}"> R$
                                                                                {{ $variable->quantidade * $variable->preco }}</th>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="align-self-center">
                                <h6 class="text-center" style="font-variant: all-petite-caps;">Sem etapas de compras</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default box-solid mt-pag {{ $cadastro }}">
        <div class="col-md-12">
            <div class="box-header with-border">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h3 class="box-title">Método de Pagamento</h3>
                    <span class="tx-15 js-spanValorNegociado"
                        data-valor="{{ $totalFaturar }}" data-valor-antigo="{{ $totalFaturar }}"> R$ {{ number_format($totalFaturar, 2, ',', '.') }}
                    </span>
                </div>
            </div>
            <div class="box-body">
                <div class="row pd-y-5">
                    <div class="col-md-4">
                        <label for="select--etapa" class="select-etapa">Seleciona a Etapa</label>
                        <select name="etapa_id" class="form-control select2 select-etapa" id="select--etapa">
                            <option value="" selected>Selecione</option>
                            @foreach ($etapasFinanceiro as $etapa)
                                <option value="{{ $etapa->id }}">{{ $etapa->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-auto">
                        <label>Método</label>
                        <div class="form-group mg-t-5">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input wd-15 ht-15 js-metodoType" name="metodo" type="radio" id="metodo_real" value="real" checked>
                                <label class="form-check-label" for="metodo_real">R$</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input wd-15 ht-15 js-metodoType" name="metodo" type="radio" id="metodo_porcent" value="porcent">
                                <label class="form-check-label" for="metodo_porcent">%</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 realPc">
                        <div class="form-group">
                            <label for="valor_metodo_porcent">Valor R$</label>
                            <input type="text" min="1" class="form-control js-valorMetodoPorcent" name="valor" data-type="real" id="input--valor_metodo_porcent" value="">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="valor_metodo_real">Valor a receber</label>
                            <input type="text" class="form-control" name="valor_receber" id="input--valor_receber" value="{{ old('text') ?? 'R$ 0,00' }}">
                        </div>
                    </div>

                    <div class="col-auto align-self-center">
                        <div class="mg-t-10">
                            <button type="button" disabled class="btn btn-dark btn-add-etapa-financeiro"><i class="fas fa-plus"></i> Adicionar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="box box-default box-solid mt-pag {{ $cadastro }}">
        <div class="col-md-12">
            <div class="box-header with-border">
                <h3 class="box-title">Histórico</h3>
            </div>
            <div class="box-body">
                <table class="table table-hover table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Nome</th>
                            <th>Método</th>
                            <th>Valor a Receber</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody id="row-table-historico"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="box box-default box-solid">
        <div class="col-md-12">
            <div class="box-header with-border">
                <h3 class="box-title">Financeiro</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <input type="hidden" id="financeiro_id" value="{{ $financeiro ? $financeiro['id'] : '' }}">


                    <style>
                        .form-group-money input {
                            border-top: 1px solid #ced4da;
                            border-bottom: 1px solid #ced4da;
                            border-right: 1px solid #ced4da;
                            border-left: none;
                        }

                        .input-group-text-cifr {
                            padding: 0.5rem 0.47rem 0px 0.5rem;
                            color: #505d69;
                            border-top: 1px solid #ced4da;
                            border-bottom: 1px solid #ced4da;
                            border-left: 1px solid #ced4da;
                            border-right: none;
                            border-radius: 0.25rem 0 0 0.25rem;
                        }

                        .form-control-money {
                            padding: 0px !important;
                        }

                    </style>

                    <div class="col-2">
                        <div class="form-group form-group-money">
                            <label for="input--price">Valor Custo</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text-cifr">R$</span>
                                </div>
                                <input type="text"
                                    name="valor_custo"
                                    class="form-control form-control-money money"
                                    id="input--valor_custo"
                                    value="{{ $financeiro && $financeiro['valor_custo_format'] ? $financeiro['valor_custo_format'] : '0,00' }}"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group form-group-money">
                            <label for="input--price">Valor Proposta</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text-cifr">R$</span>
                                </div>
                                <input type="text" name="valor_proposta" class="form-control money"
                                    id="input--valor_proposta"
                                    value="{{ $financeiro && $financeiro['valor_proposta_format'] ? $financeiro['valor_proposta_format'] : old('valor_proposta') }}"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="totalFaturar" value="{{ $totalFaturado }}">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="input--valor_desconto">Valor de Desconto</label>
                            <input type="text" name="valor_desconto" class="form-control money"
                                id="input--valor_desconto"
                                value="{{ $financeiro && $financeiro['valor_desconto_format'] ? $financeiro['valor_desconto_format'] : old('valor_desconto') }}"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group form-group-money">
                            <label for="input--price">Valor Negociado</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text-cifr">R$</span>
                                </div>
                                <input type="text" name="valor_negociado" class="form-control money"
                                    id="input--valor_negociado"
                                    value="{{ $financeiro && $financeiro['valor_negociado_format'] ? $financeiro['valor_negociado_format'] : old('valor_negociado') }}"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="input--envio_at">Data de Envio</label>
                            @if ($financeiro && $financeiro['envio_at'])
                                @php
                                    $value = \Carbon\Carbon::parse($financeiro['envio_at'])->format('d/m/Y');
                                @endphp
                            @elseif(old('envio_at'))
                                @php
                                    $value = old('envio_at');
                                @endphp
                            @else
                                @php
                                    $value = date('d/m/Y');
                                @endphp
                            @endif
                            <input type="text" name="envio_at" class="form-control @error('envio_at') is-invalid @enderror" id="input--envio_at" value="{{ $value }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="input--metodo_pagamento">Método Pagamento</label>
                            <select name='metodo_pagamento' class='form-control select2'>
                                @foreach (Config::get('constants.metodo_pagamento') as $metodo)
                                    <option {{ $financeiro && $financeiro['metodo_pagamento'] == $metodo ? 'selected' : '' }} value='{{ $metodo }}'>
                                        {{ ucfirst($metodo) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
