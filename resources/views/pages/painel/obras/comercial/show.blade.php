@extends('app')

@section('title', 'Comercial - ' . ucfirst($comercial->razao_social))

@section('content')

    <div class="d-flex justify-content-between">
        <a href="{{ route('obras.show', $comercial->id) }}" class="btn btn-box-tool tx-20-f btn-lg"> <i
               class="fa fa-long-arrow-alt-left"></i> Obra </a>
        <a href="{{ route('obras.finance', $comercial->id) }}" class="btn btn-box-tool tx-20-f btn-lg"> Financeiro <i
               class="fa fa-long-arrow-alt-right"></i> </a>
    </div>
    <div class="box">
        <div class='box-body pd-15'>
            @if ($financeiro)
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <ul id="v-tab" class="nav nav-pills" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a id="v-dados-tab" class="nav-link active" data-tab="comercial" data-toggle="tab" href="#v-dados" role="tab" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Dados da Proposta</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a id="v-financeiro-tab" class="nav-link" data-tab="comercial" data-toggle="tab" href="#v-financeiro" role="tab"
                               aria-selected="false">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Métodos de Pagamento</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a id="v-iso-tab" class="nav-link" data-tab="comercial" data-toggle="tab" href="#v-iso" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">ISO</span>
                            </a>
                        </li>
                    </ul>

                    <h3 class="box-title float-right">
                        <a id="btn-listaCompra" class="btn btn-outline-primary mt-1 mr-1" data-toggle="collapse" href="#lista_compra" aria-expanded="true"
                           aria-controls="lista_compra">
                            Lista de Compra
                        </a>
                    </h3>
                </div>

                <div class="tab-content">
                    <div id="v-dados" class="tab-pane active" role="tabpanel" aria-labelledby="v-dados">
                        <form id="form-driver" role="form-update-comercial" class="needs-validation" novalidate autocomplete="off"
                              action="{{ route('comercial.update', $comercial->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input id="comercial_id" type="hidden" value="{{ $comercial->id }}">
                            <div class="box box-default box-solid">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Dados</h3>
                                        @if ($comercial->status->value == 'elaboração')
                                            <a href="{{ route('comercial.edit-data', $comercial->id) }}" class="btn btn-primary float-right">
                                                Atualizar Dados
                                            </a>
                                        @endif
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="input--razao_social">Nome da Obra</label>
                                                    <input id="input--razao_social" type="text" name="razao_social"
                                                           class="form-control @error('razao_social') is-invalid @enderror"
                                                           value="{{ $comercial->razao_social ?? old('razao_social') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="select--concessionaria"
                                                           class="@error('concessionaria_id') is-invalid-label @enderror">Concessionária</label>
                                                    <input id="input--concessionaria_id" type="text" name="concessionaria_id" class="form-control" readonly
                                                           disabled value="{{ $comercial->concessionaria->name }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="select--service" class="@error('service_id') is-invalid-label @enderror">Tipo de
                                                        Obra/Serviço</label>

                                                    <input id="input--service_id" type="text" name="service_id" class="form-control" readonly disabled
                                                           value="{{ $comercial->service->name }}">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="input--requester">Solicitante</label>
                                                    <input id="input--requester" type="text" name="requester"
                                                           class="form-control @error('requester') is-invalid @enderror"
                                                           value="{{ $comercial->requester ?? old('requester') }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="input--requester_email">Email</label>
                                                    <input id="input--requester_email" type="text" name="requester_email"
                                                           class="form-control @error('requester_email') is-invalid @enderror"
                                                           value="{{ $comercial->requester_email ?? old('requester_email') }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="input--requester_phone">Telefone</label>
                                                    <input id="input--requester_phone" type="text" name="requester_phone"
                                                           class="form-control @error('requester_phone') is-invalid @enderror"
                                                           value="{{ $comercial->requester_phone ?? old('requester_phone') }}" required>
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
                                                    <input id="input--client-id" type="text" name="client-id" class="form-control" readonly disabled
                                                           value="{{ $comercial->client->company_name }}">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="build_at">Data</label>
                                                    <input id="input--build_at" type="text" class="form-control date @error('build_at') is-invalid @enderror"
                                                           name="build_at"
                                                           value="{{ isset($comercial) ? dataLimpa($comercial->build_at) : date('d/m/Y') }} {{ old('build_at') ?? date('d/m/Y') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="build_at">Descrição da Obra</label>
                                                    <textarea id="textarea-description" name="description" cols="5" rows="2" class="form-control @error('description') is-invalid @enderror">{{ $comercial->description ?? old('description') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label for="select-diretoria">Diretoria</label>
                                                        <select id="select-diretoria" class="form-control select2" name="diretoria">
                                                            <option {{ isset($comercial) && $comercial->diretoria == 'PM' ? 'selected' : '' }} selected>PM</option>
                                                            <option {{ isset($comercial) && $comercial->diretoria == 'HV' ? 'selected' : '' }}>HV</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 d-none">
                                                <div class="form-group">
                                                    <label for="participantes">Participantes</label>
                                                    <input id="input--participantes" type="text"
                                                           class="form-control @error('viabilizacao.participantes') is-invalid @enderror"
                                                           name="viabilizacao[participantes]"
                                                           value="{{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->participantes ? $comercial->viabilizacao->participantes : old('viabilizacao.participantes') }}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">

                                <button type="button" onclick="btn_delete(this)" data-route="{{ route('comercial.duplicate', $comercial->id) }}"
                                        data-action="put" data-text="Duplicar" class="btn btn-outline-primary">
                                    Duplicar
                                </button>

                                <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                            </div>
                        </form>
                    </div>

                    <div id="v-financeiro" class="tab-pane" role="tabpanel" aria-labelledby="v-financeiro">
                        <form role="form-update-financeiro-comercial" action="{{ route('comercial.update.financeiro', $comercial->id) }}" method="POST">
                            @csrf
                            @include('pages.painel.obras.comercial.financeiro.index')
                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                        </form>
                    </div>

                    <div id="v-iso" class="tab-pane" role="tabpanel" aria-labelledby="v-iso">
                        <form id="form-update-comercial-viabilizacao" id="form-driver" role="form" class="needs-validation" novalidate autocomplete="off"
                              action="{{ route('comercial.update', $comercial->id) }}" method="POST">
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
                                                    <label>Possui Todas as informações necessárias para Elaboração da
                                                        Proposta?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input id="elaboracao" type="checkbox" class="custom-control-input" value="sim"
                                                               name="viabilizacao[elaboracao]"
                                                               {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->elaboracao == 'sim' ? 'checked' : '' }}
                                                               {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="elaboracao">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input id="elaboracao_comentario" type="text" class="form-control"
                                                           name="viabilizacao[elaboracao_comentario]"
                                                           value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->elaboracao_comentario : old('viabilizacao.elaboracao_comentario.') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Atende os requisitos do sitema de Gestão de Qualidade?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input id="qualidade" type="checkbox" class="custom-control-input" value="sim"
                                                               name="viabilizacao[qualidade]"
                                                               {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->qualidade == 'sim' ? 'checked' : '' }}
                                                               {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="qualidade">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input id="qualidade_comentario" type="text" class="form-control"
                                                           name="viabilizacao[qualidade_comentario]"
                                                           value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->qualidade_comentario : old('viabilizacao.qualidade_comentario') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Atende os requisitos do sitema de Gestão de Ambiental?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input id="ambiental" type="checkbox" class="custom-control-input" value="sim"
                                                               name="viabilizacao[ambiental]"
                                                               {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->ambiental == 'sim' ? 'checked' : '' }}
                                                               {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="ambiental">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input id="ambiental_comentario" type="text" class="form-control"
                                                           name="viabilizacao[ambiental_comentario]"
                                                           value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->ambiental_comentario : old('viabilizacao.ambiental_comentario') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Atende os requisitos de Saúde e Segurança?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input id="seguranca_via" type="checkbox" class="custom-control-input" value="sim"
                                                               name="viabilizacao[seguranca_via]"
                                                               {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->seguranca_via == 'sim' ? 'checked' : '' }}
                                                               {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="seguranca_via">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input id="seguranca_comentario" type="text" class="form-control"
                                                           name="viabilizacao[seguranca_comentario]"
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
                                                    <input id="responsavel" type="hidden" class="form-control" name="viabilizacao[responsavel]"
                                                           value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->responsavel : old('viabilizacao.responsavel') }}">

                                                    <select id="select--reponsavel_id" name="viabilizacao[responsavel_id]"
                                                            class="form-control select2 select--reponsavel_id @error('reponsavel_id') is-invalid @enderror">
                                                        <option value="" selected>Selecione</option>
                                                        @foreach (users() as $user)
                                                            <option {{ isset($comercial) && $comercial->viabilizacao?->responsavel_id == $user->id ? 'selected' : '' }}
                                                                    {{ old('viabilizacao[reponsavel_id]') == $user->id ? 'selected' : '' }}
                                                                    {{ Request::input('viabilizacao[reponsavel_id]') == $user->id ? 'selected' : '' }}
                                                                    value="{{ $user->id }}"> {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 align-self-center">
                                                @foreach (Config::get('constants.status_final_comercial') as $status)
                                                    <div class="form-check form-check-inline">
                                                        <input id="{{ $status['id'] }}" class="form-check-input" type="radio" name="viabilizacao[viavel]"
                                                               value="{{ $status['id'] }}"
                                                               {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->viavel == $status['id'] ? 'checked' : '' }}
                                                               {{ !isset($comercial) && $status['id'] == 'viavel' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{ $status['id'] }}">{{ $status['name'] }}</label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Observações</label>
                                                    <textarea id="observacoes" type="text" class="form-control" name="viabilizacao[observacoes]">{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->observacoes : old('viabilizacao.observacoes') }}</textarea>
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
                            @include('pages.painel.obras.comercial.financeiro.index', [
                                'type' => 'cadastro',
                            ])
                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>


    <div class="box">
        <div class="box-body">
            <div class="mt-3 col-12 col-md-12 ">
                <div class="row">
                    <x-cards.card-history-log :logs="$comercial->logs()" />

                    <div class="col-12 col-md-8">
                        <div class="row">
                            <div class="col-12">
                                <div class="media mb-4">
                                    <div class="avatar-sm font-weight-bold d-inline-block">
                                        <span class="avatar-title rounded-circle bg-soft-purple ">
                                            GA
                                        </span>
                                    </div>
                                    <div class="media-body align-self-center ml-2">
                                        <div id="activity-div" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                                            <div class="wd-100p d-none">
                                                <p contenteditable="true" style="height: auto !important;" class="form-control js-new-activity"></p>
                                            </div>
                                            <input id="input-new-activity" type="text" class="form-control" name="obs_texto">
                                            <button type="submit" data-js="btn-new-activity" class="btn btn-primary align-self-start">Enviar </button>
                                        </div>
                                    </div>
                                </div>
                                <div data-js-table="activities" class="comercial-activities"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script class="">
        //New Activity
        const buttonNewActivity = document.querySelector('[data-js=btn-new-activity]');

        buttonNewActivity.addEventListener('click', () => {
            newActivity();
        });

        const newActivity = async () => {
            let inputText = document.querySelector('#input-new-activity');

            if (inputText.value == '') {
                return toastr.warning('Digite um valor no texto');
            }

            axios.post(`${base_url}/api/v1/comercial/${comercialId}/activities`, {
                    text: inputText.value,
                    _method: 'POST'
                })
                .then(function(response) {
                    inputText.value = '';
                    inputText.focus();
                    initItensTable();
                })
                .catch(function(error) {
                    const errors = error.response.data.errors;
                    if (errors) {
                        Object.keys(errors).forEach((field) => {
                            errors[field].forEach((errorMessage) => {
                                toastr.error(`${errorMessage}`);
                            });
                        });
                    } else {
                        toastr.error(`${error}`);
                    }
                });
        }
    </script>

    <script>
        //TableActivy
        const comercialId = document.getElementById('comercial_id').value;
        const tableItens = document.querySelector('[data-js-table=activities]');
        //const tableTbody = tableItens.querySelector('tbody');
        //const inputSearch = tableItens.querySelector('[name=search]');
        //const inputIdSearch = tableItens.querySelector('[name=id]');

        const initItensTable = async () => {
            tableItens.innerHTML = '';
            setItensInTheTable();
        }

        const setItensInTheTable = async () => {
            const activitiesData = await getActivitiesByComercial();
            tableItens.innerHTML += activitiesData.data.map((activity) =>
                `<div class="media mt-4">
                    <div class="avatar-sm font-weight-bold d-inline-block"> <span
                            class="avatar-title rounded-circle bg-soft-purple tx-14">${activity.user_title}
                        </span></div>
                    <div class="media-body overflow-hidden ml-2">
                        <h5 class="tx-black text-truncate mb-1 tx-14 ">${activity.user}</h5>
                        <div class="direct-chat-text">
                            <span style="word-break: break-all">
                                ${activity.text}
                            </span>
                        </div>
                    </div>
                    <div class="font-size-11">${activity.created_at}</div>
                </div> `
            ).join(' ')

            tableItens.classList.remove('d-none');
            // document.querySelector('#preload-activities').remove();
        }

        const getActivitiesByComercial = async () => {
            return await axios.get(`${base_url}/api/v1/comercial/${comercialId}/activities`, {
                    params: {}
                })
                .then(function(response) {
                    return response.data;
                })
                .catch(function(error) {
                    toastr.error(error.response.data.message);
                });
        }

        initItensTable();
    </script>

    <script src="{{ asset('panel/js/pages/comercial.js') }}"></script>

    <script>
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
                                options += '    <td>' + value.metodo_pagamento + '</td>';
                                options += '    <td>R$ ' + value.valor_receber + '</td>';
                                options += '    <td>';
                                options += '        <a href="javascript:void(0)" data-route="' +
                                    BASE_URL + '/l/comercial/etapasFinanceiro/' + value.id +
                                    '/destroy"';
                                options +=
                                    '            class="btn btn-xs btn-danger btn-delete" data-action="delete" data-btnText="Deletar" onclick="btn_delete(this)">';
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
@append
