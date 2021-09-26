@extends("app")

@section('title', 'Comercial - ' . ucfirst($comercial->razao_social))

@section('content')
    <div class="d-flex justify-content-between">
        <a href="{{ route('obras.show', $comercial->id) }}" class="btn btn-box-tool tx-20-f btn-lg"> <i class="fa fa-long-arrow-alt-left"></i> Obra </a>
        <a href="{{ route('obras.finance', $comercial->id) }}" class="btn btn-box-tool tx-20-f btn-lg"> Financeiro <i class="fa fa-long-arrow-alt-right"></i> </a>
    </div>
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
                                                        value="{{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->participantes ? $comercial->viabilizacao->participantes : old('viabilizacao.participantes') }}">
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
                                                            {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->elaboracao == 'sim' ? 'checked' : '' }}
                                                            {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="elaboracao">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input type="text" class="form-control" name="viabilizacao[elaboracao_comentario]" id="elaboracao_comentario"
                                                        value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->elaboracao_comentario : old('viabilizacao.elaboracao_comentario.') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Atende os requisitos do sitema de Gestão de Qualidade?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" value="sim" name="viabilizacao[qualidade]" id="qualidade"
                                                            {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->qualidade == 'sim' ? 'checked' : '' }}
                                                            {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="qualidade">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input type="text" class="form-control" name="viabilizacao[qualidade_comentario]" id="qualidade_comentario"
                                                        value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->qualidade_comentario : old('viabilizacao.qualidade_comentario') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Atende os requisitos do sitema de Gestão de Ambiental?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" value="sim" name="viabilizacao[ambiental]" id="ambiental"
                                                            {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->ambiental == 'sim' ? 'checked' : '' }}
                                                            {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="ambiental">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input type="text" class="form-control" name="viabilizacao[ambiental_comentario]" id="ambiental_comentario"
                                                        value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->ambiental_comentario : old('viabilizacao.ambiental_comentario') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Atende os requisitos de Saúde e Segurança?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" value="sim" name="viabilizacao[seguranca_via]" id="seguranca_via"
                                                            {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->seguranca_via == 'sim' ? 'checked' : '' }}
                                                            {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="seguranca_via">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input type="text" class="form-control" name="viabilizacao[seguranca_comentario]" id="seguranca_comentario"
                                                        value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->seguranca_comentario : '' }}">
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
                                                        value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->responsavel : old('viabilizacao.responsavel') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6 align-self-center">
                                                @foreach (Config::get('constants.status_final_comercial') as $status)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="viabilizacao[viavel]" id="{{ $status['id'] }}" value="{{ $status['id'] }}"
                                                            {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->viavel == $status['id'] ? 'checked' : '' }}
                                                            {{ !isset($comercial) && $status['id'] == 'viavel' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{ $status['id'] }}">{{ $status['name'] }}</label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Observações</label>
                                                    <textarea type="text" class="form-control" name="viabilizacao[observacoes]"
                                                        id="observacoes">{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->observacoes : old('viabilizacao.observacoes') }}</textarea>
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

    <script class="">
        $(function() {
            'use strict'

            const comercial_id = $('#comercial_id').val();
            const BASE_URL_API = $('meta[name="js-base_url_api"]').attr('content');
            const BASE_URL = $('meta[name="js-base_url"]').attr('content');
            const URL = $('meta[name="url"]').attr('content');

            var tab = localStorage.getItem('nav-tabs_comercial')
            $('#v-tab a#' + tab).tab('show')

            $('#btn-listaCompra').on('click', function() {

                $('#v-tab a#v-financeiro-tab').tab('show')
                $('.mt-pag').hasClass('d-none') ?
                    $('.mt-pag').removeClass('d-none') + $(this).html('Lista de Compra') :
                    $('.mt-pag').addClass('d-none') + $(this).html('Método Pagamento');
            })

            getHistorico();

            $('.btn-add-etapa-financeiro').on('click', function(e) {

                var metodo_pagamento = $('#metodo_real').is(':checked') ? 'R$' : '%';
                var valor = $('#input--valor_metodo_porcent').val();
                var valor_receber = $('#input--valor_receber').val();
                var etapa_id = $('#select--etapa').val() ?? '';

                if (etapa_id == '') {
                    e.preventDefault();
                    $('.select-etapa').addClass('is-invalid');
                    toastr.error('Selecione uma Etapa');
                    return;
                }

                if (valor == '') {
                    e.preventDefault();
                    $('#input--valor_metodo_porcent').addClass('is-invalid');
                    toastr.error('Digite um valor');
                    return;
                }

                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: BASE_URL_API + "comercial/" + comercial_id + "/etapasFinanceiro/store",
                    type: 'POST',
                    ajax: true,
                    dataType: "JSON",
                    data: {
                        metodo_pagamento: metodo_pagamento,
                        valor: valor,
                        valor_receber: valor_receber,
                        etapa_id: etapa_id,
                    }
                }).done(function() {
                    var valorAntigo = $('.spanValorNegociado').attr('data-valor-antigo');
                    $("#select--etapa option[value='" + etapa_id + "']").remove();
                    $('#input--valor_metodo_porcent').val('')
                    $('#input--valor_receber').val('');
                    $('.spanValorNegociado').attr('data-valor', valorAntigo);
                    if (valorAntigo == '0') {
                        $('.btn-add-etapa-financeiro').attr('disabled', true);
                    }
                    getHistorico();
                });
            })

            function getHistorico() {
                $.ajax({
                    url: BASE_URL_API + "comercial/" + comercial_id + "/etapasFinanceiro",
                    type: 'GET',
                    ajax: true,
                    dataType: "JSON",
                    success: function(j) {
                        var options = '';
                        $.each(j, function(index, value) {
                            if (index != 'totalFaturar') {
                                options += '<tr>';
                                options += '    <td>' + value.nome_etapa + '</td>';
                                options += '    <td>' + value.metodo_pagamento + ' ' + value.valor + '</td>';
                                options += '    <td>R$ ' + value.valor_receber + '</td>';
                                options += '    <td>';
                                options += '        <a href="javascript:void(0)" data-href="' + BASE_URL + '/l/comercial/etapasFinanceiro/' + value.id + '/destroy"';
                                options += '            class="btn btn-xs btn-danger btn-delete" onclick="btn_delete(this)">';
                                options += '            <i class="fa fa-times"></i>';
                                options += '        </a>';
                                options += '    </td>';
                                options += '</tr>';
                            }

                        });
                        if (j.totalFaturar && j.totalFaturar != 0) {
                            $('#totalFaturar').val(j.totalFaturar)
                        }
                        $('#row-table-historico').html(options);
                    },
                });
            }

        });
    </script>
@endsection
@stop
