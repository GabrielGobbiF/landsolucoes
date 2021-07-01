@extends("app")

@section('title', 'Comercial - ' . ucfirst($comercial->razao_social))

@section('content')
    <div class="box">
        <div class='box-body pd-15'>
            @if ($financeiro)
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <ul class="nav nav-pills" id="v-tab" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-tab="comercial" id="v-dados-tab" data-toggle="tab" href="#v-dados" role="tab" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Dados da Proposta</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-tab="comercial" id="v-financeiro-tab" data-toggle="tab" href="#v-financeiro" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Métodos de Pagamento</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-tab="comercial" id="v-iso-tab" data-toggle="tab" href="#v-iso" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">ISO</span>
                            </a>
                        </li>
                    </ul>

                    <h3 class="box-title float-right">
                        <a class="btn btn-outline-primary mt-1 mr-1" id="btn-listaCompra" data-toggle="collapse" href="#lista_compra" aria-expanded="true" aria-controls="lista_compra">
                            Lista de Compra
                        </a>
                    </h3>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="v-dados" role="tabpanel" aria-labelledby="v-dados">
                        <form role="form-update-comercial" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('comercial.update', $comercial->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="comercial_id" value="{{ $comercial->id }}">
                            <div class="box box-default box-solid">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Dados</h3>
                                    </div>
                                    <div class="box-body">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="input--razao_social">Nome da Obra</label>
                                                    <input type="text" name="razao_social" class="form-control @error('razao_social') is-invalid @enderror" id="input--razao_social"
                                                        value="{{ $comercial->razao_social ?? old('razao_social') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="select--concessionaria" class="@error('concessionaria_id') is-invalid-label @enderror">Concessionária</label>
                                                    <input type="text" name="concessionaria_id" class="form-control" readonly disabled id="input--concessionaria_id"
                                                        value="{{ $comercial->concessionaria->name }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="select--service" class="@error('service_id') is-invalid-label @enderror">Tipo de Obra/Serviço</label>

                                                    <input type="text" name="service_id" class="form-control" readonly disabled id="input--service_id"
                                                        value="{{ $comercial->service->name }}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-default box-solid">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Descrição</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="select--client" class="@error('client_id') is-invalid-label @enderror">Cliente</label>
                                                    <input type="text" name="client-id" class="form-control" readonly disabled id="input--client-id"
                                                        value="{{ $comercial->client->company_name }}">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="build_at">Data</label>
                                                    <input type="text" class="form-control date @error('build_at') is-invalid @enderror" name="build_at" id="input--build_at"
                                                        value="{{ isset($comercial) ? dataLimpa($comercial->build_at) : date('d/m/Y') }} {{ old('build_at') ?? date('d/m/Y') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="build_at">Descrição da Obra</label>
                                                    <textarea name="description" id="textarea-description" cols="5" rows="2"
                                                        class="form-control @error('description') is-invalid @enderror">{{ $comercial->description ?? old('description') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12 d-none">
                                                <div class="form-group">
                                                    <label for="participantes">Participantes</label>
                                                    <input type="text" class="form-control @error('viabilizacao.participantes') is-invalid @enderror" name="viabilizacao[participantes]"
                                                        id="input--participantes"
                                                        value="{{ isset($comercial) && $comercial->viabilizacao->participantes ? $comercial->viabilizacao->participantes : old('viabilizacao.participantes') }}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                        </form>
                    </div>

                    <div class="tab-pane" id="v-financeiro" role="tabpanel" aria-labelledby="v-financeiro">
                        <form role="form-update-financeiro-comercial" action="{{ route('comercial.update.financeiro', $comercial->id) }}" method="POST">
                            @csrf
                            @include('pages.painel.obras.comercial.financeiro.index')
                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                        </form>
                    </div>

                    <div class="tab-pane" id="v-iso" role="tabpanel" aria-labelledby="v-iso">
                        <form id="form-update-comercial-viabilizacao" role="form" class="needs-validation" novalidate id="form-driver" autocomplete="off"
                            action="{{ route('comercial.update', $comercial->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="box box-default box-solid">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Questões Avaliadas</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Possui Todas as informações necessárias para Elaboração da Proposta?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" value="sim" name="viabilizacao[elaboracao]" id="elaboracao"
                                                            {{ isset($comercial) && $comercial->viabilizacao->elaboracao == 'sim' ? 'checked' : '' }}
                                                            {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="elaboracao">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input type="text" class="form-control" name="viabilizacao[elaboracao_comentario]" id="elaboracao_comentario"
                                                        value="{{ isset($comercial) ? $comercial->viabilizacao->elaboracao_comentario : old('viabilizacao.elaboracao_comentario.') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Atende os requisitos do sitema de Gestão de Qualidade?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" value="sim" name="viabilizacao[qualidade]" id="qualidade"
                                                            {{ isset($comercial) && $comercial->viabilizacao->qualidade == 'sim' ? 'checked' : '' }}
                                                            {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="qualidade">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input type="text" class="form-control" name="viabilizacao[qualidade_comentario]" id="qualidade_comentario"
                                                        value="{{ isset($comercial) ? $comercial->viabilizacao->qualidade_comentario : old('viabilizacao.qualidade_comentario') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Atende os requisitos do sitema de Gestão de Ambiental?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" value="sim" name="viabilizacao[ambiental]" id="ambiental"
                                                            {{ isset($comercial) && $comercial->viabilizacao->ambiental == 'sim' ? 'checked' : '' }}
                                                            {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="ambiental">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input type="text" class="form-control" name="viabilizacao[ambiental_comentario]" id="ambiental_comentario"
                                                        value="{{ isset($comercial) ? $comercial->viabilizacao->ambiental_comentario : old('viabilizacao.ambiental_comentario') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Atende os requisitos de Saúde e Segurança?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" value="sim" name="viabilizacao[seguranca_via]" id="seguranca_via"
                                                            {{ isset($comercial) && $comercial->viabilizacao->seguranca_via == 'sim' ? 'checked' : '' }}
                                                            {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="seguranca_via">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input type="text" class="form-control" name="viabilizacao[seguranca_comentario]" id="seguranca_comentario"
                                                        value="{{ isset($comercial) ? $comercial->viabilizacao->seguranca_comentario : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-default box-solid">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Status Final</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Responsável</label>
                                                    <input type="text" class="form-control" name="viabilizacao[responsavel]" id="responsavel"
                                                        value="{{ isset($comercial) ? $comercial->viabilizacao->responsavel : old('viabilizacao.responsavel') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6 align-self-center">
                                                @foreach (Config::get('constants.status_final_comercial') as $status)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="viabilizacao[viavel]" id="{{ $status['id'] }}" value="{{ $status['id'] }}"
                                                            {{ isset($comercial) && $comercial->viabilizacao->viavel == $status['id'] ? 'checked' : '' }}
                                                            {{ !isset($comercial) && $status['id'] == 'viavel' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{ $status['id'] }}">{{ $status['name'] }}</label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Observações</label>
                                                    <textarea type="text" class="form-control" name="viabilizacao[observacoes]"
                                                        id="observacoes">{{ isset($comercial) ? $comercial->viabilizacao->observacoes : old('viabilizacao.observacoes') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 align-self-center">
                        <h4 class="text-center my-3">Atualize o Financeiro</h4>
                    </div>
                    <form role="form-update-financeiro-comercial" action="{{ route('comercial.update.financeiro', $comercial->id) }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            @include('pages.painel.obras.comercial.financeiro.index', ['type' => 'cadastro'])
                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@section('scripts')
    <script src="{{ asset('panel/js/pages/comercial.js') }}"></script>

    <script>
        (function($) {

            'use strict';

            init();

            function init() {
                if ($('#financeiro_id').val() == '') {
                    updateValorCusto();
                }
            }

            function updateValorCusto() {
                var total = 0;
                var totalFormat = 0;

                $(".sub-total").each(function() {
                    var subTotal = $(this).attr('data-value').replace(',', '.');
                    if (!isNaN(subTotal)) {
                        total = parseFloat(total) + parseFloat(subTotal);
                    }
                });

                totalFormat = numberFormat(total)

                $('#input--valor_custo').val(totalFormat)
                $('#input--valor_proposta').val(totalFormat)
            }

            $('#input--valor_proposta, #input--valor_desconto').on('keyup blur', function() {
                updateValorNegociado();
            })

            function updateValorNegociado() {
                var total = 0;
                var valorProposta = clearNumber($('#input--valor_proposta').val());
                var valorDesconto = clearNumber($('#input--valor_desconto').val());

                total = (parseFloat(valorProposta) - parseFloat(valorDesconto));

                total = new Intl.NumberFormat('pt-BR', {
                    style: 'currency',
                    currency: 'BRL',
                }).format(total);

                $('#input--valor_negociado').val(total);
            }


            $('.js-metodoType').on('click', function() {
                resetValorNegociado();

                var valorNegociado = $('#input--valor_negociado').attr('data-value');

                /**
                 * Limpar CAMPOS
                 */
                $('#input--valor_receber').val('')
                $('#input--valor_metodo_porcent').val('')

                if ($(this).val() == 'real') {
                    $('.realPc').find('label').html('Valor R$');
                    $('.realPc').find('input').attr('data-type', 'real');
                } else {
                    $('.realPc').find('label').html('Porcentagem %');
                    $('.realPc').find('input').attr('data-type', 'porcent');
                }

                $('.btn-add-etapa-financeiro').attr('disabled', true);

            })

            $('.js-qntEtapa').on('change keyup', function() {
                var $input = $(this);
                var $idEtapa = $input.attr('data-id');
                var $price = $input.attr('data-price');
                var $tr = $('#' + $idEtapa);
                var qnt = $input.val();
                if (qnt < 0) {
                    $input.val('1');
                } else {
                    var total = qnt * $price;
                    $tr.find('.sub-total').html('R$ ' + total)
                    $tr.find('.sub-total').attr('data-value', total)
                    updateValorCusto();
                    updateValorNegociado();
                }
            })

            $('#input--valor_metodo_porcent').on('keyup change', function() {

                $('.btn-add-etapa-financeiro').attr('disabled', true);

                var valorNegociado = clearNumber($('#input--valor_negociado').attr('data-value'));
                var valorCalcular = $(this).val();
                var type = $(this).attr('data-type');

                var typeResultado = type == 'real' ? (valorCalcular) : ((valorNegociado * valorCalcular) / 100)
                var totalFaturar = $('#totalFaturar').val();
                var result = (valorNegociado - clearNumber(typeResultado)) - clearNumber(totalFaturar);

                var resultFormat = new Intl.NumberFormat('pt-BR', {
                    style: 'currency',
                    currency: 'BRL',
                }).format(result);

                if (valorCalcular == '' || valorCalcular == '0') {
                    $('#input--valor_receber').val('R$ 0,00')
                    $('.js-spanValorNegociado').html(resultFormat);
                    return;
                }

                if (parseFloat(typeResultado) > parseFloat(valorNegociado) || typeResultado < 0) {
                    toastr.error('Valor a receber não pode ser maior que negociado');
                    resetValorNegociado();
                    $(this).val('');
                    return;
                }

                $('#input--valor_receber').val(numberFormat(typeResultado))
                $('.js-spanValorNegociado').html(resultFormat);
                $('.btn-add-etapa-financeiro').attr('disabled', false);
            })


        })(jQuery)


        function numberFormat(number) {
            if (typeof number == 'string') {
                var number = clearNumber(number);
            }
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL',
            }).format(number);
        }

        function clearNumber(number) {
            number = number.toString().replace("R$", "").replace(" ", "");
            return number != '' ? numeral(number).value() : 0;
        }

        function resetValorNegociado() {
            $('.btn-add-etapa-financeiro').attr('disabled', true);
            $('#input--valor_receber').val('R$ 0,00');
            var valorNegociado = numeral(clearNumber($('#input--valor_negociado').val()));
            var valorNegociado = valorNegociado.subtract(clearNumber($('#totalFaturar').val()));

            $('.js-spanValorNegociado').html(numberFormat(valorNegociado.value()));
        }
    </script>

@endsection
@stop
