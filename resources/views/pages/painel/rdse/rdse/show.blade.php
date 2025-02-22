@extends('app')

@section('title', 'Editar - ' . ucfirst($rdse->n_order) . ' - ' . ucfirst($rdse->description))

@section('content-max-fluid')

    <style>
        .form-group {
            margin-right: 8px;
        }

        table * a[type=button] {
            vertical-align: -webkit-baseline-middle
        }

        table * input.description_sap {
            text-transform: uppercase;
        }

        table tr.active {
            background: #4caf50ad;
        }

        #rdse-services_tab .select2-selection__rendered {
            line-height: 27px !important;
        }

        #rdse-services_tab .select2-container .select2-selection--single {
            height: 1.8rem !important
        }

        #rdse-services_tab .select2-selection__arrow {
            height: 1.8rem !important
        }

        #rdse-services_tab .form-group {
            margin-bottom: 0rem !important;
        }

        #rdse-services_tab .table th,
        #rdse-services_tab .table td {
            padding: 0.2rem !important;
            padding-top: 0.3rem !important;
            padding-bottom: 0.3rem !important;
        }

        .nav-item {
            flex-basis: auto !important;
        }

        .tox-checklist>li:not(.tox-checklist--hidden) {
            list-style: none;
            margin: 0.25em 0;
            position: relative;
        }

        .tox-checklist>li:not(.tox-checklist--hidden)::before {
            content: url("data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2016%2016%22%3E%3Cg%20id%3D%22checklist-unchecked%22%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Crect%20id%3D%22Rectangle%22%20width%3D%2215%22%20height%3D%2215%22%20x%3D%22.5%22%20y%3D%22.5%22%20fill-rule%3D%22nonzero%22%20stroke%3D%22%234C4C4C%22%20rx%3D%222%22%2F%3E%3C%2Fg%3E%3C%2Fsvg%3E%0A");
            cursor: pointer;
            height: 1em;
            margin-left: -1.5em;
            margin-top: 0.125em;
            position: absolute;
            width: 1em;
        }

        .tox-checklist li:not(.tox-checklist--hidden).tox-checklist--checked::before {
            content: url("data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2216%22%20height%3D%2216%22%20viewBox%3D%220%200%2016%2016%22%3E%3Cg%20id%3D%22checklist-checked%22%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Crect%20id%3D%22Rectangle%22%20width%3D%2216%22%20height%3D%2216%22%20fill%3D%22%234099FF%22%20fill-rule%3D%22nonzero%22%20rx%3D%222%22%2F%3E%3Cpath%20id%3D%22Path%22%20fill%3D%22%23FFF%22%20fill-rule%3D%22nonzero%22%20d%3D%22M11.5703186%2C3.14417309%20C11.8516238%2C2.73724603%2012.4164781%2C2.62829933%2012.83558%2C2.89774797%20C13.260121%2C3.17069355%2013.3759736%2C3.72932262%2013.0909105%2C4.14168582%20L7.7580587%2C11.8560195%20C7.43776896%2C12.3193404%206.76483983%2C12.3852142%206.35607322%2C11.9948725%20L3.02491697%2C8.8138662%20C2.66090143%2C8.46625845%202.65798871%2C7.89594698%203.01850234%2C7.54483354%20C3.373942%2C7.19866177%203.94940006%2C7.19592841%204.30829608%2C7.5386474%20L6.85276923%2C9.9684299%20L11.5703186%2C3.14417309%20Z%22%2F%3E%3C%2Fg%3E%3C%2Fsvg%3E%0A");
        }

        .d-grid {
            display: grid;
        }

        @media print {

            #button_modal-rdse-codigo,
            #nav-links-rdse {
                display: none;
            }

            .input-group {
                width: 49%;
            }

        }
    </style>

    <!-- Nav tabs -->
    <div class="container">
        <div class="d-flex ">
            <ul id="nav-links-rdse" class="nav nav-pills nav-justified" role="tablist">
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-toggle="tab" href="#rdse-dados_tab" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block">Dados</span>
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link active" data-toggle="tab" href="#rdse-services_tab" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Serviços</span>
                    </a>
                </li>

                @if (!empty($rdse->obra_id))
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-save="false" href="{{ route('obras.show', $rdse->obra_id) }}">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Obra</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link " data-toggle="tab" href="#rdse-history_tab" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Histórico</span>
                    </a>
                </li>

                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link " data-toggle="tab" href="#rdse-activities_tab" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Atividades</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content pt-4 text-muted">

        <div id="rdse-dados_tab" class="tab-pane" role="tabpanel">
            <div class="container">
                <div class='card'>
                    <div class='card-body'>
                        <form id="form-rdse" role="form" class="needs-validation" novalidate autocomplete="off" action="{{ route('rdse.update', $rdse->id) }}"
                              method="POST">
                            @csrf
                            @method('put')
                            @include('pages.painel._partials.forms.form-rdse')

                            <div class="card text-start">
                                <div class="card-body">
                                    <h4 class="card-title">Status</h4>
                                    <div class="row">
                                        <div class="col-12 col-md-auto mb-2" style="min-width: 180px">
                                            <label>Status de Medição</label>
                                            <select id="rdse-select_status" name="status" class="form-control select2 search-input-rdse">
                                                @foreach (trans('rdses.status_label') as $status => $text)
                                                    <option value='{{ $status }}' {{ $rdse->status == $status ? 'selected="selected"' : null }}>
                                                        {{ __trans('rdses.status_label.' . $status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{--
                                        <div class="col-12 col-md-auto" style="min-width: 180px">
                                            <label>Status de Programação</label>
                                            <select id="rdse-select_status_execution" name="status_execution" class="form-control select2 search-input-rdse">
                                                @foreach (trans('rdses.status_execution') as $status_execution)
                                                    <option value='{{ $status_execution }}'
                                                            {{ $rdse->status_execution == $status_execution ? 'selected="selected"' : null }}>
                                                        {{ $status_execution }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
--}}
                                        <div class="col-12 col-md-auto" style="min-width: 180px">
                                            <label>Status de Encerramento</label>
                                            <select id="rdse-select_status_closing" name="status_closing" class="form-control select2 search-input-rdse">
                                                @foreach (\App\Supports\Enums\Rdse\RdseClosingStatus::options() as $status_closing)
                                                    <option
                                                            {{ $rdse->status_closing->value == $status_closing['value'] ? 'selected="selected"' : null }}
                                                            value='{{ $status_closing['value'] }}'>
                                                        {{ $status_closing['label_translate'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                            <button type="button" class="btn btn-primary js-btn-delete float-left" data-text="Excluir RDSE"
                                    data-href="{{ route('rdse.destroy', $rdse->id) }}"><i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="rdse-services_tab" class="tab-pane  active show" role="tabpanel">
            <div class='card'>
                <div class='card-body' style="padding: 1rem 1rem 0 1rem;">

                    <div class="row">
                        <div class="col-12 col-md-2">
                            <div class="card text-start">
                                <div class="card-body">
                                    <div>
                                        <h5 class="font-size-12"><i class="mdi mdi-location"></i> Croqui Atualizado Sigeo</h5>
                                        <div class="d-flex flex-wrap">
                                            <div class="input-group mb-3 w-auto">
                                                <input type="text" class="form-control form-control-sm input-update date" name="croqui_atualizado_data"
                                                       placeholder="Data"
                                                       value="{{ !empty($rdse->croqui_atualizado_data) ? return_format_date($rdse->croqui_atualizado_data, 'pt') : '' }}">
                                            </div>
                                            <div class="input-group mb-3 w-auto">
                                                <input type="text" class="form-control form-control-sm input-update" name="croqui_atualizado_responsavel"
                                                       placeholder="Responsável"
                                                       value="{{ !empty($rdse->croqui_atualizado_responsavel) ? $rdse->croqui_atualizado_responsavel : '' }}">
                                            </div>

                                            <div class="">
                                                <a href="{{ route('rdse.rsbe', [$rdse->id, 'type' => 'enel']) }}" class="btn btn-outline-danger btn-sm">
                                                    RSBE Enel
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="card text-start">
                                <div class="card-body">
                                    <div>
                                        <h5 class="font-size-12"><i class="mdi mdi-location"></i> Croqui Validado</h5>
                                        <div class="d-flex flex-wrap">
                                            <div class="input-group mb-3 w-auto">
                                                <input type="text" class="form-control form-control-sm input-update date" name="croqui_validado_data"
                                                       placeholder="Data"
                                                       value="{{ !empty($rdse->croqui_validado_data) ? return_format_date($rdse->croqui_validado_data, 'pt') : '' }}">
                                            </div>
                                            <div class="input-group mb-3 w-auto">
                                                <input type="text" class="form-control form-control-sm input-update" name="croqui_validado_responsavel"
                                                       placeholder="Responsável"
                                                       value="{{ !empty($rdse->croqui_validado_responsavel) ? $rdse->croqui_validado_responsavel : '' }}">
                                            </div>

                                            @if ($itensResb->isNotEmpty())
                                                <div class="">
                                                    <a href="{{ route('rdse.rsbe', [$rdse->id, 'type' => 'viabilidade']) }}"
                                                       class="btn btn-outline-danger btn-sm">
                                                        RSBE Viabilidade
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="card text-start">
                                <div class="card-body">
                                    <div>
                                        <h5 class="font-size-12"><i class="mdi mdi-location"></i> Obra Finalizada</h5>
                                        <div class="d-flex flex-wrap">
                                            <div class="input-group mb-3 w-auto">
                                                <input type="text" class="form-control form-control-sm input-update date" name="croqui_finalizado_data"
                                                       placeholder="Data"
                                                       value="{{ !empty($rdse->croqui_finalizado_data) ? return_format_date($rdse->croqui_finalizado_data, 'pt') : '' }}">
                                            </div>
                                            <div class="input-group mb-3 w-auto">
                                                <input type="text" class="form-control form-control-sm input-update" name="croqui_finalizado_responsavel"
                                                       placeholder="Responsável"
                                                       value="{{ !empty($rdse->croqui_finalizado_responsavel) ? $rdse->croqui_finalizado_responsavel : '' }}">
                                            </div>

                                            @if ($itensResb->isNotEmpty())
                                                <div class="">
                                                    <a href="{{ route('rdse.rsbe', [$rdse->id, 'type' => 'executada']) }}" class="btn btn-outline-danger btn-sm">
                                                        RSBE Executada
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="card text-start">
                                <div class="card-body">
                                    <div>
                                        <h5 class="font-size-12"><i class="mdi mdi-location"></i> Status APR </h5>
                                        <div class="d-flex flex-wrap">
                                            <div class="input-group mb-3 w-auto">
                                                <input type="text" class="form-control form-control-sm input-update date" name="apr_at"
                                                       placeholder="Data da APR"
                                                       value="{{ !empty($rdse->apr_at) ? return_format_date($rdse->apr_at, 'pt') : '' }}">
                                            </div>
                                            <div class="input-group mb-3 w-auto">
                                                <input type="text" class="form-control form-control-sm input-update" name="apr_id" placeholder="APR ID"
                                                       value="{{ !empty($rdse->apr_id) ? $rdse->apr_id : '' }}">
                                            </div>

                                            <span>

                                                <div class='badge badge-soft-{{ $rdse->StatusAPR['badge'] }} font-size-18'>
                                                    {{ $rdse->StatusAPR['status'] }}
                                                </div>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-2">
                            <div class="card text-start">
                                <div class="card-body">
                                    <div>
                                        <h5 class="font-size-12"><i class="mdi mdi-location"></i> Entrega Programada Obra </h5>
                                        <div class="d-flex flex-wrap align-items-center">


                                            <div class="mb-3">
                                                <label class="form-label">Data Limite ENEL</label>
                                                <input type="text" class="form-control form-control-sm input-update date" name="enel_deadline"
                                                       value="{{ !empty($rdse->enel_deadline) ? return_format_date($rdse->enel_deadline, 'pt') : '' }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Data Execução Viabilidade</label>
                                                <input type="text" class="form-control form-control-sm input-update date" name="viability_execution_date"
                                                       value="{{ !empty($rdse->viability_execution_date) ? return_format_date($rdse->viability_execution_date, 'pt') : '' }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Programada Início</label>
                                                <input type="text" class="form-control form-control-sm input-update date" name="work_start_date"
                                                       value="{{ !empty($rdse->work_start_date) ? return_format_date($rdse->work_start_date, 'pt') : '' }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Data Final</label>
                                                <input type="text" class="form-control form-control-sm input-update date" name="work_end_date"
                                                       value="{{ !empty($rdse->work_end_date) ? return_format_date($rdse->work_end_date, 'pt') : '' }}">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 col-md-2">
                            <div class="card text-start">
                                <div class="card-body">
                                    <div>
                                        <h5 class="font-size-12"><i class="mdi mdi-location"></i> Inventário </h5>
                                        <div class="d-flex flex-wrap">

                                            <div class="mb-3">
                                                <label class="form-label">Enviado Enel</label>
                                                <input type="text" class="form-control form-control-sm input-update date" name="enviado_enel"
                                                       value="{{ !empty($rdse->enviado_enel) ? return_format_date($rdse->enviado_enel, 'pt') : '' }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Aprovado Enel</label>
                                                <input type="text" class="form-control form-control-sm input-update date" name="aprovado_enel"
                                                       value="{{ !empty($rdse->aprovado_enel) ? return_format_date($rdse->aprovado_enel, 'pt') : '' }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Fiscalizado Satel</label>
                                                <input type="text" class="form-control form-control-sm input-update date" name="fiscalizado_satel"
                                                       value="{{ !empty($rdse->fiscalizado_satel) ? return_format_date($rdse->fiscalizado_satel, 'pt') : '' }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Liberado Medição</label>
                                                <input type="text" class="form-control form-control-sm input-update date" name="liberado_medicao"
                                                       value="{{ !empty($rdse->liberado_medicao) ? return_format_date($rdse->liberado_medicao, 'pt') : '' }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Data de Pagamento Projeto</label>
                                                <input type="text" class="form-control form-control-sm input-update date" name="data_pagamento_projeto"
                                                       value="{{ !empty($rdse->data_pagamento_projeto) ? return_format_date($rdse->data_pagamento_projeto, 'pt') : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between" style="align-items: end;">
                        <div class="d-grid float-right mb-2" style="display: grid">
                            <div>
                                <div class='badge badge-soft-{{ $rdse->StatusLabel }} font-size-18'>
                                    {{ __trans('rdses.status_label.' . $rdse->status) }}
                                </div>
                            </div>
                            <div>
                                @if ($rdse->status == 'invoice')
                                    <a class="mr-3" href="{{ route('rdse.service.partial.store', $rdse->id) }}">Adicionar Parcial</a>
                                @endif
                                @if ($rdse->parcial_1 == 1)
                                    <a href="{{ route('rdse.service.partial.destroy', $rdse->id) }}">Deletar Ultima Parcial</a>
                                @endif
                            </div>
                        </div>

                        <div class="float-right mb-2">
                            <div>
                                <h5 class="mt-1 mb-3">{{ $codigoType }} - {{ $rdse->type }} - {{ $priceUps }}</h5>
                            </div>
                        </div>
                    </div>

                    <form id='form-update-services-rdse' role='form' class='needs-validation' method='POST'>
                        <div id="services">
                            <table class="table table-sm">
                                <thead class="thead-light">
                                    @if ($rdse->parcial_1)
                                        <tr>
                                            <th colspan="2"></th>
                                            <th colspan="2" class="text-center">
                                                <div class=" d-grid">
                                                    <span>Parcial 1</span>
                                                    <span>{{ !empty($rdse->parcial_1_at) ? formatDateAndTime($rdse->parcial_1_at) : 'Sem Data' }}</span>
                                                </div>
                                            </th>
                                            @if ($rdse->parcial_1)
                                                <th colspan="2" class="text-center">
                                                    <div class=" d-grid">
                                                        <span>Parcial 2</span>
                                                        <span>{{ !empty($rdse->parcial_2_at) ? formatDateAndTime($rdse->parcial_2_at) : 'Sem Data' }}</span>
                                                    </div>
                                                </th>
                                            @endif

                                            @if ($rdse->parcial_2)
                                                <th colspan="2" class="text-center">
                                                    <div class=" d-grid">
                                                        <span>Parcial 3</span>
                                                        <span>{{ !empty($rdse->parcial_3_at) ? formatDateAndTime($rdse->parcial_3_at) : 'Sem Data' }}</span>
                                                    </div>
                                                </th>
                                            @endif

                                            @if ($rdse->parcial_3)
                                                <th colspan="2" class="text-center">
                                                    <div class=" d-grid">
                                                        <span>Parcial 4</span>
                                                        <span>{{ !empty($rdse->parcial_4_at) ? formatDateAndTime($rdse->parcial_4_at) : 'Sem Data' }}</span>
                                                    </div>
                                                </th>
                                            @endif

                                            @if ($rdse->parcial_4)
                                                <th colspan="2" class="text-center">
                                                    <div class=" d-grid">
                                                        <span>Parcial 5</span>
                                                        <span>{{ !empty($rdse->parcial_5_at) ? formatDateAndTime($rdse->parcial_5_at) : 'Sem Data' }}</span>
                                                    </div>
                                                </th>
                                            @endif

                                            @if ($rdse->parcial_5)
                                                <th colspan="2" class="text-center">
                                                    <div class=" d-grid">
                                                        <span>Parcial 6</span>
                                                        <span>{{ !empty($rdse->parcial_6_at) ? formatDateAndTime($rdse->parcial_6_at) : 'Sem Data' }}</span>
                                                    </div>
                                                </th>
                                            @endif

                                            @if ($rdse->parcial_6)
                                                <th colspan="2" class="text-center">
                                                    <div class=" d-grid">
                                                        <span>Parcial 7</span>
                                                        <span>{{ !empty($rdse->parcial_7_at) ? formatDateAndTime($rdse->parcial_7_at) : 'Sem Data' }}</span>
                                                    </div>
                                                </th>
                                            @endif

                                        </tr>
                                    @endif
                                    <tr>
                                        <th class="d-none"></th>

                                        <th style="width: 10%">SAP</th>
                                        <th>Descrição</th>
                                        <th style="width: 6%">Horas / <br>Qnt Atividade</th>
                                        <th style="width: 8%">Preço</th>

                                        @if ($rdse->parcial_1)
                                            <th style="width: 6%">P Qnt 2</th>
                                            <th style="width: 8%">P Preço 2</th>
                                        @endif

                                        @if ($rdse->parcial_2)
                                            <th style="width: 6%">P Qnt 3</th>
                                            <th style="width: 8%">P Preço 3</th>
                                        @endif

                                        @if ($rdse->parcial_3)
                                            <th style="width: 6%">P Qnt 4</th>
                                            <th style="width: 8%">P Preço 4</th>
                                        @endif

                                        @if ($rdse->parcial_4)
                                            <th style="width: 6%">P Qnt 5</th>
                                            <th style="width: 8%">P Preço 5</th>
                                        @endif

                                        @if ($rdse->parcial_5)
                                            <th style="width: 6%">P Qnt 6</th>
                                            <th style="width: 8%">P Preço 6</th>
                                        @endif

                                        @if ($rdse->parcial_6)
                                            <th style="width: 6%">P Qnt 7</th>
                                            <th style="width: 8%">P Preço 7</th>
                                        @endif

                                        @if ($rdse->status == 'pending' || $rdse->status == 'approval')
                                            <th style="width: 1%"></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="services-row">
                                    @foreach ($rdseServices as $service)
                                        <tr id="services_{{ $service->id }}" class="service-row" data-id="{{ $service->id }}">
                                            <th class="d-none">
                                                <input type="hidden" name="serviceId[]" value="{{ $service->id }}">
                                            </th>


                                            <th>
                                                <select name="codigo_sap[]" class="form-control form-control-sm select2 codigo_sap" placeholder="Código SAP"
                                                        data-id="{{ $service->id }}">
                                                    @if (!empty($service->codigo_sap))
                                                        <option value="{{ $service->codigo_sap }}">
                                                            {{ !empty($service->handswork) ? $service->handswork->code : '' }}
                                                        </option>
                                                    @else
                                                        <option value="" selected> Selecione </option>
                                                    @endif
                                                </select>
                                            </th>

                                            <th>
                                                <input id="description_sap_{{ $service->id }}" class="form-control form-control-sm description_sap"
                                                       name="description[]"
                                                       value="{{ !empty($service->description) ? $service->description : (!empty($service->handswork) ? $service->handswork->description : '') }}" />
                                            </th>

                                            <th>
                                                <input id="price_ups_{{ $service->id }}" type="hidden"
                                                       value="{{ !empty($service->handswork) ? $service->handswork->price_ups : '0' }}">
                                                <input
                                                       id="conversion_{{ $service->id }}" min="0" type="number"
                                                       class="form-control form-control-sm conversion" name="qnt_atividade[]" data-id="{{ $service->id }}"
                                                       value="{{ !empty($service->qnt_atividade) ? $service->qnt_atividade : '0' }}" />
                                            </th>
                                            <th>
                                                <input id="price_total_hours_{{ $service->id }}" class="form-control form-control-sm price_total_hours money"
                                                       name="preco[]" data-toggle="tooltip" data-placement="top"
                                                       title="{{ !empty($service->handswork) ? 'UPS: ' . $service->handswork->price_ups * $service->qnt_atividade : '' }}"
                                                       value="{{ !empty($service->preco) ? $service->preco : '0' }}" />

                                            </th>

                                            @if ($rdse->parcial_1)
                                                <th>
                                                    <input
                                                           id="p_quantidade1_{{ $service->id }}" min="0" type="number"
                                                           class="form-control form-control-sm quantidade_parcial" name="p_quantidade1[]"
                                                           data-id="{{ $service->id }}" data-parcial="1"
                                                           value="{{ !empty($service->p_quantidade1) ? $service->p_quantidade1 : '0' }}" />
                                                </th>
                                                <th>
                                                    <input id="price_total_parcial1_{{ $service->id }}"
                                                           class="form-control form-control-sm price_parcial price_parcial1 money" name="p_preco1[]"
                                                           data-parcial="1" data-id="{{ $service->id }}" data-toggle="tooltip" data-placement="top"
                                                           title="{{ !empty($service->handswork) ? 'UPS: ' . $service->handswork->price_ups * $service->p_quantidade1 : '' }}"
                                                           value="{{ !empty($service->p_preco1) ? $service->p_preco1 : '0' }}" />


                                                </th>
                                            @endif

                                            @if ($rdse->parcial_2)
                                                <th>
                                                    <input
                                                           id="p_quantidade2_{{ $service->id }}" min="0" type="number"
                                                           class="form-control form-control-sm quantidade_parcial" name="p_quantidade2[]"
                                                           data-id="{{ $service->id }}" data-parcial="2"
                                                           value="{{ !empty($service->p_quantidade2) ? $service->p_quantidade2 : '0' }}" />
                                                </th>
                                                <th>
                                                    <input id="price_total_parcial2_{{ $service->id }}"
                                                           class="form-control form-control-sm price_parcial price_parcial2 money" name="p_preco2[]"
                                                           data-parcial="2" data-id="{{ $service->id }}"
                                                           value="{{ !empty($service->p_preco2) ? $service->p_preco2 : '0' }}" data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="{{ !empty($service->handswork) ? 'UPS: ' . $service->handswork->price_ups * $service->p_quantidade2 : '' }}" />
                                                </th>
                                            @endif

                                            @if ($rdse->parcial_3)
                                                <th>
                                                    <input
                                                           id="p_quantidade3_{{ $service->id }}" min="0" type="number"
                                                           class="form-control form-control-sm quantidade_parcial" name="p_quantidade3[]"
                                                           data-id="{{ $service->id }}" data-parcial="3"
                                                           value="{{ !empty($service->p_quantidade3) ? $service->p_quantidade3 : '0' }}" />
                                                </th>
                                                <th>
                                                    <input id="price_total_parcial3_{{ $service->id }}"
                                                           class="form-control form-control-sm price_parcial price_parcial3 money" name="p_preco3[]"
                                                           data-id="{{ $service->id }}" data-parcial="3"
                                                           value="{{ !empty($service->p_preco3) ? $service->p_preco3 : '0' }}" data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="{{ !empty($service->handswork) ? 'UPS: ' . $service->handswork->price_ups * $service->p_quantidade3 : '' }}" />
                                                </th>
                                            @endif

                                            @if ($rdse->parcial_4)
                                                <th>
                                                    <input
                                                           id="p_quantidade4_{{ $service->id }}" min="0" type="number"
                                                           class="form-control form-control-sm quantidade_parcial" name="p_quantidade4[]"
                                                           data-id="{{ $service->id }}" data-parcial="4"
                                                           value="{{ !empty($service->p_quantidade4) ? $service->p_quantidade4 : '0' }}" />
                                                </th>
                                                <th>
                                                    <input id="price_total_parcial4_{{ $service->id }}"
                                                           class="form-control form-control-sm price_parcial price_parcial4 money" name="p_preco4[]"
                                                           data-id="{{ $service->id }}" data-parcial="4"
                                                           value="{{ !empty($service->p_preco4) ? $service->p_preco4 : '0' }}" data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="{{ !empty($service->handswork) ? 'UPS: ' . $service->handswork->price_ups * $service->p_quantidade4 : '' }}" />
                                                </th>
                                            @endif


                                            @if ($rdse->parcial_5)
                                                <th>
                                                    <input
                                                           id="p_quantidade5_{{ $service->id }}" min="0" type="number"
                                                           class="form-control form-control-sm quantidade_parcial" name="p_quantidade5[]"
                                                           data-id="{{ $service->id }}" data-parcial="5"
                                                           value="{{ !empty($service->p_quantidade5) ? $service->p_quantidade5 : '0' }}" />
                                                </th>
                                                <th>
                                                    <input id="price_total_parcial5_{{ $service->id }}"
                                                           class="form-control form-control-sm price_parcial price_parcial5 money" name="p_preco5[]"
                                                           data-id="{{ $service->id }}" data-parcial="5"
                                                           value="{{ !empty($service->p_preco5) ? $service->p_preco5 : '0' }}" data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="{{ !empty($service->handswork) ? 'UPS: ' . $service->handswork->price_ups * $service->p_quantidade5 : '' }}" />
                                                </th>
                                            @endif

                                            @if ($rdse->parcial_6)
                                                <th>
                                                    <input
                                                           id="p_quantidade6_{{ $service->id }}" min="0" type="number"
                                                           class="form-control form-control-sm quantidade_parcial" name="p_quantidade6[]"
                                                           data-id="{{ $service->id }}" data-parcial="6"
                                                           value="{{ !empty($service->p_quantidade6) ? $service->p_quantidade6 : '0' }}" />
                                                </th>
                                                <th>
                                                    <input id="price_total_parcial6_{{ $service->id }}"
                                                           class="form-control form-control-sm price_parcial price_parcial6 money" name="p_preco6[]"
                                                           data-id="{{ $service->id }}" data-parcial="6"
                                                           value="{{ !empty($service->p_preco6) ? $service->p_preco6 : '0' }}" data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="{{ !empty($service->handswork) ? 'UPS: ' . $service->handswork->price_ups * $service->p_quantidade6 : '' }}" />
                                                </th>
                                            @endif

                                            @if ($rdse->status == 'pending' || $rdse->status == 'approval')
                                                <th>
                                                    <a type="button" href="javascript:void(0)" onclick="deleteService(`{{ $service->id }}`)" class=""
                                                       tabindex="-1">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </th>
                                            @endif

                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Parcial 1</td>
                                        <td class="total"></td>
                                        @if ($rdse->parcial_1)
                                            <td>Parcial 2</td>
                                            <td class="total_p1"></td>
                                        @endif
                                        @if ($rdse->parcial_2)
                                            <td>Parcial 3</td>
                                            <td class="total_p2"></td>
                                        @endif
                                        @if ($rdse->parcial_3)
                                            <td>Parcial 4</td>
                                            <td class="total_p3"></td>
                                        @endif
                                        @if ($rdse->parcial_4)
                                            <td>Parcial 5</td>
                                            <td class="total_p4"></td>
                                        @endif
                                        @if ($rdse->parcial_5)
                                            <td>Parcial 6</td>
                                            <td class="total_p5"></td>
                                        @endif
                                        @if ($rdse->parcial_6)
                                            <td>Parcial 7</td>
                                            <td class="total_p6"></td>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="totais my-5">
                                <dl class="row mb-5">
                                    <div class="col-8">


                                        <ul class="nav nav-pills" role="tablist">
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link active" data-toggle="tab" href="#observations-1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-observations"></i></span>
                                                    <span class="d-none d-sm-block">Observações</span>
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-toggle="tab" href="#observations_execution-1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Documentos Execução</span>
                                                </a>
                                            </li>

                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-toggle="tab" href="#observations_viabilidade-1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Viabilidade</span>
                                                </a>
                                            </li>

                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-toggle="tab" href="#observations_programacao-1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Relatório de Execução</span>
                                                </a>
                                            </li>

                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-toggle="tab" href="#observations_adicionais-1" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Adicionais</span>
                                                </a>
                                            </li>
                                        </ul>


                                        <!-- Tab panes -->
                                        <div class="tab-content mt-2 text-muted">
                                            <div id="observations-1" class="tab-pane active" role="tabpanel">
                                                <a type="button" class="mb-2" data-toggle="modal" data-target="#editorModal" data-editor="observations">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <span id="spanObservations">{!! $rdse->observations !!}</span>
                                            </div>
                                            <div id="observations_execution-1" class="tab-pane" role="tabpanel">
                                                <a type="button" class="mb-2" data-toggle="modal" data-target="#editorModal"
                                                   data-editor="observations_execution">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <span id="spanObservationsExecution">{!! $rdse->observations_execution !!}</span>
                                            </div>
                                            <div id="observations_viabilidade-1" class="tab-pane" role="tabpanel">
                                                <a type="button" class="mb-2" data-toggle="modal" data-target="#editorModal"
                                                   data-editor="observations_viabilidade">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <span id="spanObservationsViabilidade">{!! $rdse->observations_viabilidade !!}</span>
                                            </div>
                                            <div id="observations_programacao-1" class="tab-pane" role="tabpanel">
                                                {{--
                                                <a type="button" class="mb-2" data-toggle="modal" data-target="#editorModal"
                                                   data-editor="observations_programacao">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <span id="spanObservationsProgramacao">{!! $rdse->observations_programacao !!}</span>
                                                --}}

                                                @include('pages.painel.rdse.rdse.progamacao-atividades')

                                            </div>
                                            <div id="observations_adicionais-1" class="tab-pane" role="tabpanel">
                                                <a type="button" class="mb-2" data-toggle="modal" data-target="#editorModal"
                                                   data-editor="observations_adicionais">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <span id="spanObservationsAdicionais">{!! $rdse->observations_adicionais !!}</span>
                                            </div>
                                        </div>
                                        @include('pages.painel.rdse._partials.modal')
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div id="v-pills-tab_totais" class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                                                    <a id="v-pills-total-tab" class="nav-link mb-2 active" data-toggle="pill" href="#v-pills-total"
                                                       role="tab" aria-controls="v-pills-total" aria-selected="true">Total</a>

                                                    @if ($rdse->parcial_1 == 1)
                                                        <a id="v-pills-parcial_1-tab" class="nav-link mb-2" data-toggle="pill" href="#v-pills-parcial_1"
                                                           role="tab" aria-controls="v-pills-parcial_1" aria-selected="false">Parcial 2
                                                        </a>
                                                    @endif

                                                    @if ($rdse->parcial_2 == 1)
                                                        <a id="v-pills-parcial_2-tab" class="nav-link mb-2" data-toggle="pill" href="#v-pills-parcial_2"
                                                           role="tab" aria-controls="v-pills-parcial_2" aria-selected="false">Parcial 3
                                                        </a>
                                                    @endif

                                                    @if ($rdse->parcial_3 == 1)
                                                        <a id="v-pills-parcial_3-tab" class="nav-link" data-toggle="pill" href="#v-pills-parcial_3"
                                                           role="tab" aria-controls="v-pills-parcial_3" aria-selected="false">Parcial 4
                                                        </a>
                                                    @endif

                                                    @if ($rdse->parcial_4 == 1)
                                                        <a id="v-pills-parcial_4-tab" class="nav-link" data-toggle="pill" href="#v-pills-parcial_4"
                                                           role="tab" aria-controls="v-pills-parcial_4" aria-selected="false">Parcial 5
                                                        </a>
                                                    @endif

                                                    @if ($rdse->parcial_5 == 1)
                                                        <a id="v-pills-parcial_5-tab" class="nav-link" data-toggle="pill" href="#v-pills-parcial_5"
                                                           role="tab" aria-controls="v-pills-parcial_5" aria-selected="false">Parcial 6
                                                        </a>
                                                    @endif

                                                    @if ($rdse->parcial_6 == 1)
                                                        <a id="v-pills-parcial_6-tab" class="nav-link" data-toggle="pill" href="#v-pills-parcial_6"
                                                           role="tab" aria-controls="v-pills-parcial_6" aria-selected="false">Parcial 7
                                                        </a>
                                                    @endif



                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div id="v-pills-tabContent" class="tab-content text-muted mt-4 mt-md-0">
                                                    <div id="v-pills-total" class="tab-pane fade show active" role="tabpanel"
                                                         aria-labelledby="v-pills-total-tab">

                                                        <div class="row row-xs no-gutters">
                                                            <dt class="col-sm-6">Total Espera</dt>
                                                            <dd class="col-sm-6 total_espera" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total Serviços</dt>
                                                            <dd class="col-sm-6 total_servico" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total R$</dt>
                                                            <dd class="col-sm-6 total" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6 text-truncate">Total UPS</dt>
                                                            <dd class="col-sm-6 total_ups" style="text-align: end;"></dd>
                                                        </div>

                                                    </div>
                                                    <div id="v-pills-parcial_1" class="tab-pane fade" role="tabpanel" aria-labelledby="v-pills-parcial_1-tab">
                                                        <div id="row-total_parcial_1" class="row row-xs no-gutters">
                                                            <dt class="col-sm-6">Total Espera</dt>
                                                            <dd class="col-sm-6 p_total_espera" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total Serviços</dt>
                                                            <dd class="col-sm-6 p_total_servico" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total R$</dt>
                                                            <dd class="col-sm-6 p_total" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6 text-truncate">Total UPS</dt>
                                                            <dd class="col-sm-6 p_total_ups" style="text-align: end;"></dd>
                                                        </div>
                                                    </div>
                                                    <div id="v-pills-parcial_2" class="tab-pane fade" role="tabpanel" aria-labelledby="v-pills-parcial_2-tab">
                                                        <div id="row-total_parcial_2" class="row row-xs no-gutters">
                                                            <dt class="col-sm-6">Total Espera</dt>
                                                            <dd class="col-sm-6 p_total_espera" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total Serviços</dt>
                                                            <dd class="col-sm-6 p_total_servico" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total R$</dt>
                                                            <dd class="col-sm-6 p_total" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6 text-truncate">Total UPS</dt>
                                                            <dd class="col-sm-6 p_total_ups" style="text-align: end;"></dd>
                                                        </div>
                                                    </div>
                                                    <div id="v-pills-parcial_3" class="tab-pane fade" role="tabpanel" aria-labelledby="v-pills-parcial_3-tab">
                                                        <div id="row-total_parcial_3" class="row row-xs no-gutters">
                                                            <dt class="col-sm-6">Total Espera</dt>
                                                            <dd class="col-sm-6 p_total_espera" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total Serviços</dt>
                                                            <dd class="col-sm-6 p_total_servico" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total R$</dt>
                                                            <dd class="col-sm-6 p_total" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6 text-truncate">Total UPS</dt>
                                                            <dd class="col-sm-6 p_total_ups" style="text-align: end;"></dd>
                                                        </div>
                                                    </div>

                                                    <div id="v-pills-parcial_4" class="tab-pane fade" role="tabpanel" aria-labelledby="v-pills-parcial_4-tab">
                                                        <div id="row-total_parcial_4" class="row row-xs no-gutters">
                                                            <dt class="col-sm-6">Total Espera</dt>
                                                            <dd class="col-sm-6 p_total_espera" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total Serviços</dt>
                                                            <dd class="col-sm-6 p_total_servico" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total R$</dt>
                                                            <dd class="col-sm-6 p_total" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6 text-truncate">Total UPS</dt>
                                                            <dd class="col-sm-6 p_total_ups" style="text-align: end;"></dd>
                                                        </div>
                                                    </div>

                                                    <div id="v-pills-parcial_5" class="tab-pane fade" role="tabpanel" aria-labelledby="v-pills-parcial_5-tab">
                                                        <div id="row-total_parcial_5" class="row row-xs no-gutters">
                                                            <dt class="col-sm-6">Total Espera</dt>
                                                            <dd class="col-sm-6 p_total_espera" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total Serviços</dt>
                                                            <dd class="col-sm-6 p_total_servico" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total R$</dt>
                                                            <dd class="col-sm-6 p_total" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6 text-truncate">Total UPS</dt>
                                                            <dd class="col-sm-6 p_total_ups" style="text-align: end;"></dd>
                                                        </div>
                                                    </div>

                                                    <div id="v-pills-parcial_6" class="tab-pane fade" role="tabpanel" aria-labelledby="v-pills-parcial_6-tab">
                                                        <div id="row-total_parcial_6" class="row row-xs no-gutters">
                                                            <dt class="col-sm-6">Total Espera</dt>
                                                            <dd class="col-sm-6 p_total_espera" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total Serviços</dt>
                                                            <dd class="col-sm-6 p_total_servico" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6">Total R$</dt>
                                                            <dd class="col-sm-6 p_total" style="text-align: end;"></dd>

                                                            <dt class="col-sm-6 text-truncate">Total UPS</dt>
                                                            <dd class="col-sm-6 p_total_ups" style="text-align: end;"></dd>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row row-xs no-gutters d-none">
                                            <dt class="col-sm-6">Total Espera</dt>
                                            <dd class="col-sm-6 total_espera" style="text-align: end;"></dd>

                                            <dt class="col-sm-6">Total Serviços</dt>
                                            <dd class="col-sm-6 total_servico" style="text-align: end;"></dd>

                                            <dt class="col-sm-6">Total R$</dt>
                                            <dd class="col-sm-6 total" style="text-align: end;"></dd>

                                            <dt class="col-sm-6 text-truncate">Total UPS</dt>
                                            <dd class="col-sm-6 total_ups" style="text-align: end;"></dd>
                                        </div>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </form>

                    <div class="mb-2">
                        <button id="button_modal-rdse-codigo" type="button" class="btn btn-primary">
                            Visualizar Códigos
                        </button>

                        <a type="button" class="btn btn-dark" target="_blank" href="{{ route('rdse.pdf', $rdse->id) }}">
                            <i class="fas fa-pdf"></i> Visualizar PDF
                        </a>

                        <a type="button" class="btn btn-outline-success" target="_blank" href="{{ route('rdse.excel', $rdse->id) }}">
                            <i class="fa fa-file-excel"></i>
                            Exportar Excel
                        </a>

                        @if ($rdse->status != 'invoice')
                            <a href="{{ route('rdse.duplicate', $rdse->id) }}" type="button" class="btn btn-info btn-confirm">
                                Duplicar RDSE
                            </a>
                        @endif

                        @if ($rdse->status == 'pending')
                            <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addServicesByModel'>
                                Adicionar Serviços de Modelo
                            </button>

                            <div id='addServicesByModel' class='modal' tabindex='-1' role='dialog'>
                                <div class='modal-dialog' role='document'>
                                    <form id='form-add-services-byModel' role='form' class='needs-validation'
                                          action='{{ route('rdse.add.service.by.model', $rdse->id) }}' method='POST'>
                                        @csrf
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title'>Selecione o modelo</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                                <select name='modelo' class='form-control t-select' data-request="modelos-rdses"></select>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-primary btn-submit'>Salvar</button>
                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif

                        @if (auth()->user()->id == 8 || auth()->user()->id == 1)
                            <a class="btn btn-info btn-confirm" href="#"
                               onclick="event.preventDefault();document.getElementById('form-attServices').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                Atualizar Todos os Valores
                                <form id="form-attServices" onSubmit="if(!confirm('Tem certeza que deseja atualizar os valores?')){return false;}"
                                      action="{{ route('rdse.att.services', $rdse->id) }}" method="POST" class="d-none">
                                    @method('PUT')
                                    @csrf
                                </form>
                            </a>
                        @endif

                    </div>

                    <div id="modal-rdse-codigo" class="modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Códigos</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row row-sm no-gutters">
                                        <div class="col-md-6">
                                            <table id="table-codigos-rdse" class="table table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-6">
                                            <table id="table-qnt-rdse" class="table table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Qnt</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="rdse-history_tab" class="tab-pane" role="tabpanel">
            <div class="container">
                <div class='card'>
                    <div class='card-body'>
                        @include('pages.painel.rdse._partials.rdse_history')
                    </div>
                </div>
            </div>
        </div>

        <div id="rdse-activities_tab" class="tab-pane " role="tabpanel">
            <div class="container">
                <div class='card'>
                    <div class='card-body'>
                        @include('pages.painel.rdse._partials.rdse_activities')
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script>
        const rdseId = $('#rdse_id').val();
        const priceUps = $('#price_ups').val();
        const formIdentifier = `services_rdse_${rdseId}`;
        const div = $("#services");
        let formRdse = document.querySelector(`#form-update-services-rdse`);
        let unsaved = true;

        window.addEventListener('load', () => {

            initInputs();

            setInterval("updateServices()", 5000);

            if ($('#parcial_1').val() == 1) {
                attTotalParciais(1);
            } else {
                attTotal();
            }

            if ($('#parcial_2').val() == 1) {
                attTotalParciais(2);
            }
            if ($('#parcial_3').val() == 1) {
                attTotalParciais(3);
            }

            if ($('#parcial_4').val() == 1) {
                attTotalParciais(4);
            }

            if ($('#parcial_5').val() == 1) {
                attTotalParciais(5);
            }

            if ($('#parcial_6').val() == 1) {
                attTotalParciais(6);
            }
        });

        $('#button_modal-rdse-codigo').on('click', () => {

            var htmlCodigo = '';
            var htmlQntAtividade = '';
            let tableCodigo = $('#table-codigos-rdse');
            let bodyCodigo = tableCodigo.find('tbody');

            let tableQntAtividade = $('#table-qnt-rdse');
            let bodyQntAtividade = tableQntAtividade.find('tbody');

            bodyCodigo.html('');
            bodyQntAtividade.html('');

            $('.codigo_sap').each(function() {
                var data = $(this).select2('data')
                if (data[0].text != ' Selecione ') {
                    htmlCodigo += `<tr>
                  <th>${data[0].text}</th>
                </tr>`;
                }
            })

            $('.conversion').each(function() {
                var data = $(this).val();
                htmlQntAtividade += `<tr>
                  <th>${data}</th>
                </tr>`;
            })
            bodyCodigo.append(htmlCodigo)
            bodyQntAtividade.append(htmlQntAtividade)
            $('#modal-rdse-codigo').modal('show');
        })

        $(function() {
            $("#services-row").sortable({
                update: function() {
                    axios.post(`${base_url}/api/v1/rdse/${rdseId}/services/reorder`, {
                            itens: $(this).sortable("toArray")
                        })
                        .then(response => {
                            attLines();
                            unsaved = false;
                        })
                        .catch((error) => {
                            toastr.error(error);
                        });
                }
            });
        })

        $('body').on('click', function() {
            window.onbeforeunload = function() {
                if (!unsaved)
                    return 'Os dados do formulário não foram salvos, deseja permanecer nesta página?';
            };
        });

        $('body').on('keydown', debounce(function(e) {
            e.preventDefault();
            e.stopPropagation();
            let eClick = true;
            if (e.which === 9 && !$(".select2-search__field").is(":focus") && eClick) {
                let option = true;
                $('.qnt_minutos').each(function() {
                    if ($(this).val() == '0' || $(this).val() == '') {
                        option = false;
                    }
                })
                if (option) {
                    eClick = false;
                    eClick = addRow();
                }
            }
        }, 100));

        const initInputs = () => {
            /**
             * Toda alteração de conteudo irá mandar o post para salvar
                $('input, select').on('change', debounce(function(e) {
                    updateServices();
                }, 2000));
            */

            div.find('input, select').on('keyup change focus, click', function(e) {
                unsaved = false;
            });

            $('.qnt_minutos, .conversion, .quantidade_parcial').on('focusin', function() {
                $(this).val() == '0' ? $(this).val('') : ''
            }).on('focusout', function() {
                $(this).val() == '' ? $(this).val('0') : ''
            })

            $('.chegada_obra, .qnt_minutos').on('keyup change', function() {
                attLines();
                attTotal();
            })

            $(`.select2.codigo_sap`).select2(optionsSelectSap);

            $(document).on('focus', '.select2', function(e) {
                $(this).siblings('select').select2('open');
            });

            $('select').on('select2:open', (e) => {
                if (!e.target.multiple) {
                    document.querySelector('.select2-search__field').focus();
                }
                $('.select2-dropdown--below').css('width', '300px !important');
            });

            $('.select2.codigo_sap').on('select2:select', function(e) {
                let id = $(this).attr('data-id');
                let price_ups = e.params.data.price_ups
                $(`#price_ups_${id}`).val(price_ups);
                $(`#description_sap_${id}`).val(e.params.data.description);
                updateHorasAtividades(id);
                attTotal();
            });

            $('.conversion').on('keyup change', function() {
                updateHorasAtividades($(this).attr('data-id'));
            })

            $('.price_total_hours, .conversion').on('keyup change', function() {
                attTotal();
            })

            $('.price_parcial, .quantidade_parcial').on('keyup change', function() {
                let serviceId = $(this).attr('data-id');
                let parcial = $(this).attr('data-parcial');
                attParciais(serviceId, parcial);
                attTotalParciais(parcial);
            })

            if ($('#rdse-status').val() == 'invoice' || $('#rdse-status').val() == 'approved') {
                $('.conversion').attr('readonly', true)
                $('.price_total_hours').attr('readonly', true)
                $('.qnt_minutos').attr('readonly', true)
                $('.codigo_sap ').attr('readonly', true)
                $('.qnt_atividade').attr('readonly', true)
            } else {
                $('.conversion').attr('readonly', false)
                $('.price_total_hours').attr('readonly', false)
                $('.qnt_minutos').attr('readonly', false)
                $('.codigo_sap ').attr('readonly', false)
                $('.qnt_atividade').attr('readonly', false)
            }
        }

        function attTotalParciais(parcial) {

            let total_espera = 0;
            let total_servico = 0;
            let total = 0;
            let total_ups = 0;
            let rowParcial = $(`#row-total_parcial_${parcial}`)

            $(".service-row").each(function() {
                const selectSap = $(this).find(`select.codigo_sap`).select2('data');
                if (selectSap.length > 0 && selectSap[0].id == '212') {
                    total_espera += clearNumber($(this).find(`.price_parcial${parcial}`).val());
                }
                total += clearNumber($(this).find(`.price_parcial${parcial}`).val());
            })

            total_ups = numberFormat(total / priceUps);
            total_servico = numberFormat(total - total_espera);

            total = numberFormat(total);
            total_espera = numberFormat(total_espera);

            rowParcial.find('.p_total_espera').html(`R$ ${total_espera}`)
            rowParcial.find('.p_total').html(`R$ ${total}`)
            rowParcial.find('.p_total_servico').html(`R$ ${total_servico}`)
            rowParcial.find('.p_total_ups').html(`${total_ups}`);
            $(`.total_p${parcial}`).html(`R$ ${total}`);

            attTotal();
        }

        function attLines() {
            $(".service-row").each(function() {
                let id = $(this).attr("data-id");
                let line = $(this).next('.service-row').attr('data-id');

                let saida_obra = $(this).find(`.saida_obra`);
                let chegada_obra = $(this).find(`.chegada_obra`).val();
                let minute = $(this).find(`.qnt_minutos`).val();
                let chegada_obra_line = $(`#chegada_obra_${line}`);
                let hours = $(this).find(`.hours`);

                //add minutes
                var chegada_obra_date = moment(chegada_obra, "HH:mm:ss")
                var saida_obra_date = chegada_obra_date.add(minute, 'minutes');

                if (chegada_obra_date.isValid() && saida_obra_date.isValid()) {
                    saida_obra.val(saida_obra_date.format('HH:mm:ss'));
                    chegada_obra_line.val(saida_obra_date.format('HH:mm:ss'));

                    var now = saida_obra.val();
                    let then = chegada_obra;

                    hours.val(moment.utc(moment(now, "HH:mm:ss").diff(moment(then, "HH:mm:ss"))).format("HH:mm:ss"));
                    updateHorasAtividades(id);
                }
            })
        }

        function attTotal() {
            let total_espera = 0;
            let total_servico = 0;
            let total = 0;
            let total_ups = 0;
            let totalP1 = 0;
            $(".service-row").each(function() {
                const selectSap = $(this).find(`select.codigo_sap`).select2('data');
                let priceParcial = 0;

                $(this).find('.price_parcial').each(function() {
                    priceParcial += clearNumber($(this).val());
                })

                if (selectSap.length > 0 && selectSap[0].id == '212') {
                    total_espera += clearNumber($(this).find(`.price_total_hours`).val());
                }

                total += clearNumber($(this).find(`.price_total_hours`).val()) + priceParcial;
                totalP1 += clearNumber($(this).find(`.price_total_hours `).val());
            })

            total_ups = numberFormat(total / priceUps);
            total_servico = numberFormat(total - total_espera);

            total = numberFormat(total);
            total_espera = numberFormat(total_espera);

            $('.total_espera').html(`R$ ${total_espera}`)
            $('.total').html(`R$ ${total}`)
            $('.total_servico').html(`R$ ${total_servico}`)
            $('.total_ups').html(`${total_ups}`)
            $(`.total`).html(`R$ ${numberFormat(totalP1)}`);

        }

        function updateHorasAtividades(serviceId) {
            let serviceDiv = $(`#services_${serviceId}`);
            let selectSap = serviceDiv.find(`select.codigo_sap`).select2('data');
            let minute = serviceDiv.find(`.qnt_minutos`).val();
            let price_service_ups = $(`#price_ups_${serviceId}`).val();
            let inputQntAtividade = $(`#conversion_${serviceId}`);
            let inputPriceTotal = $(`#price_total_hours_${serviceId}`);
            let valueQntAtividade = inputQntAtividade.val();

            if (price_service_ups != '0') {
                if (selectSap && selectSap[0].id == '212') {
                    let conversion = minute / 30;
                    let conversionMathFloor = Math.floor(conversion);
                    let priceTotal = numberFormat((price_service_ups * priceUps) * conversionMathFloor)
                    inputQntAtividade.val(conversionMathFloor)
                    inputPriceTotal.val(`${priceTotal}`)
                    inputQntAtividade.attr('readonly', true).attr('tabindex', '-1');

                } else if (selectSap && selectSap[0].id != '') {
                    inputQntAtividade.attr('readonly', false).removeAttr('tabindex');
                    if (valueQntAtividade != 0) {
                        let priceTotal = numberFormat((price_service_ups * priceUps) * valueQntAtividade);
                        inputPriceTotal.val(`${priceTotal}`)
                    } else {
                        inputPriceTotal.val(0)
                    }
                } else {
                    inputQntAtividade.attr('readonly', false).removeAttr('tabindex');
                }
            }
        }

        function attParciais(serviceId, parcial) {
            let serviceDiv = $(`#services_${serviceId}`);
            let minute = serviceDiv.find(`.qnt_minutos`).val();
            let quantidade_parcial = $(`#p_quantidade${parcial}_${serviceId}`).val();
            let price_service_ups = $(`#price_ups_${serviceId}`).val();
            let selectSap = serviceDiv.find(`select.codigo_sap`).select2('data');

            if (price_service_ups != '0') {
                if (selectSap && selectSap[0].id == '212') {
                    let conversion = minute / 30;
                    let conversionMathFloor = Math.floor(conversion);
                    let priceTotal = numberFormat((price_service_ups * priceUps) * conversionMathFloor)
                    $(`#p_quantidade${parcial}_${serviceId}`).val(conversionMathFloor)

                    $(`#price_total_parcial${parcial}_${serviceId}`).val(`${priceTotal}`)
                    $(`#p_quantidade${parcial}_${serviceId}`).attr('readonly', true).attr('tabindex', '-1');

                } else if (selectSap && selectSap[0].id != '') {
                    $(`#p_quantidade${parcial}_${serviceId}`).attr('readonly', false).removeAttr('tabindex');

                    if (quantidade_parcial != 0) {
                        let priceTotal = numberFormat((price_service_ups * priceUps) * quantidade_parcial);
                        $(`#price_total_parcial${parcial}_${serviceId}`).val(`${priceTotal}`)
                    } else {
                        $(`#price_total_parcial${parcial}_${serviceId}`).val(0)
                    }
                } else {
                    $(`#p_quantidade${parcial}_${serviceId}`).attr('readonly', false).removeAttr('tabindex');
                }
            }

        }

        const addRow = async () => {
            if ($('#rdse-status').val() != 'invoice' || $('#rdse-status').val() != 'inventariando' || $('#rdse-status').val() != 'inventariado') {
                await updateServices();

                const service = await storeService();

                if (service && service.data != undefined && service.data != 'andamento') {
                    let line = service.data;

                    if ($(`#services_${line}`).length == 0) {

                        let html = `
        <tr class="service-row" data-id="${line}" id="services_${line}" tabindex="-1">
            <th class="d-none">
                <input type="hidden" name="serviceId[]" value="${line}" />
            </th>

            <th>
                <select name="codigo_sap[]" class="form-control form-control-sm  select2 codigo_sap" placeholder="Código SAP" id="codigo_sap_${line}" data-id="${line}">
                    <option value="" selected> Selecione  </option>
                </select>
            </th>

            <th>
                <input class="form-control form-control-sm  description_sap" name="description[]" id="description_sap_${line}" />
            </th>

            <th>
                <input type="hidden" id="price_ups_${line}">
                <input class="form-control form-control-sm  conversion"
                name="qnt_atividade[]" id="conversion_${line}"
                data-id="${line}"
                tabindex="-1"
                value="0" />
            </th>

            <th>
                <input class="form-control form-control-sm  price_total_hours money" name="preco[]" id="price_total_hours_${line}"  value="0" />
            </th>`;

                        if ($('#parcial_1').val() == 1) {
                            html += `
                            <th>
                                <input
                                    min="0"
                                    type="number"
                                    class="form-control form-control-sm quantidade_parcial"
                                    name="p_quantidade1[]" id="p_quantidade1_${line}"
                                    data-id="${line}"
                                    data-parcial="1"
                                    value="" />
                            </th>
                            <th>
                                <input class="form-control form-control-sm price_parcial price_parcial1 money"
                                    name="p_preco1[]"
                                    id="price_total_parcial1_${line}"
                                    data-parcial="1"
                                    data-id="${line}"
                                    value="" />
                            </th>`
                        }

                        if ($('#parcial_2').val() == 1) {
                            html += `
                            <th>
                                <input
                                    min="0"
                                    type="number"
                                    class="form-control form-control-sm quantidade_parcial"
                                    name="p_quantidade2[]" id="p_quantidade2_${line}"
                                    data-id="${line}"
                                    data-parcial="2"
                                    value="" />
                            </th>
                            <th>
                                <input class="form-control form-control-sm price_parcial price_parcial2 money"
                                    name="p_preco2[]"
                                    id="price_total_parcial2_${line}"
                                    data-parcial="2"
                                    data-id="${line}"
                                    value="" />
                            </th>`
                        }

                        if ($('#parcial_3').val() == 1) {
                            html += `
                            <th>
                                <input
                                    min="0"
                                    type="number"
                                    class="form-control form-control-sm quantidade_parcial"
                                    name="p_quantidade3[]" id="p_quantidade3_${line}"
                                    data-id="${line}"
                                    data-parcial="3"
                                    value="" />
                            </th>
                            <th>
                                <input class="form-control form-control-sm price_parcial price_parcial3 money"
                                    name="p_preco3[]"
                                    id="price_total_parcial3_${line}"
                                    data-parcial="3"
                                    data-id="${line}"
                                    value="" />
                            </th>`
                        }

                        if ($('#parcial_4').val() == 1) {
                            html += `
                            <th>
                                <input
                                    min="0"
                                    type="number"
                                    class="form-control form-control-sm quantidade_parcial"
                                    name="p_quantidade4[]" id="p_quantidade4_${line}"
                                    data-id="${line}"
                                    data-parcial="4"
                                    value="" />
                            </th>
                            <th>
                                <input class="form-control form-control-sm price_parcial price_parcial4 money"
                                    name="p_preco4[]"
                                    id="price_total_parcial4_${line}"
                                    data-parcial="4"
                                    data-id="${line}"
                                    value="" />
                            </th>`
                        }

                        if ($('#parcial_5').val() == 1) {
                            html += `
                            <th>
                                <input
                                    min="0"
                                    type="number"
                                    class="form-control form-control-sm quantidade_parcial"
                                    name="p_quantidade5[]" id="p_quantidade5_${line}"
                                    data-id="${line}"
                                    data-parcial="5"
                                    value="" />
                            </th>
                            <th>
                                <input class="form-control form-control-sm price_parcial price_parcial5 money"
                                    name="p_preco5[]"
                                    id="price_total_parcial5_${line}"
                                    data-parcial="5"
                                    data-id="${line}"
                                    value="" />
                            </th>`
                        }

                        if ($('#parcial_6').val() == 1) {
                            html += `
                            <th>
                                <input
                                    min="0"
                                    type="number"
                                    class="form-control form-control-sm quantidade_parcial"
                                    name="p_quantidade6[]" id="p_quantidade6_${line}"
                                    data-id="${line}"
                                    data-parcial="6"
                                    value="" />
                            </th>
                            <th>
                                <input class="form-control form-control-sm price_parcial price_parcial6 money"
                                    name="p_preco6[]"
                                    id="price_total_parcial6_${line}"
                                    data-parcial="6"
                                    data-id="${line}"
                                    value="" />
                            </th>`
                        }


                        html += `<th>
                        <a type="button" href="javascript:void(0)" onclick="deleteService(${line})" tabindex="-1">
                            <i class="fas fa-trash"></i>
                        </a>
                    </th>
                </tr> `;

                        $('#services-row').append(html);
                        initInputs();
                        attLines();

                        return true;

                    }
                }
            }

            return false;
        };

        const updateServices = async () => {
            let formData = new FormData($("#form-update-services-rdse")[0]);
            formData.append('_method', 'PUT');

            if (!unsaved)
                await axios.post(`${base_url}/api/v1/rdse/${rdseId}/services/all`, formData)
                .then(response => {
                    unsaved = true;
                })
                .catch((error) => {
                    toastr.error(error);
                });
        }

        const storeService = async () => {
            return await axios.post(`${base_url}/api/v1/rdse/${rdseId}/services`).catch(error => {
                toastr.error(error)
            });
        }

        function deleteService(serviceId) {
            axios.post(`${base_url}/api/v1/rdse/${rdseId}/services/${serviceId}`, {
                    _method: 'DELETE'
                })
                .then(response => {
                    $(`#services_${serviceId}`).remove();
                    attLines();
                    attTotal();
                })
                .catch(error => {
                    toastr.error(error)
                })
        }

        /**
         * Debounce
         */
        function debounce(fn, delay) {
            var timer = null;
            return function() {
                var context = this,
                    args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    fn.apply(context, args);
                }, delay);
            };
        }

        const optionsSelectSap = {
            dropdownAutoWidth: true,
            multiple: false,
            minimumInputLength: 3,
            language: "pt-br",
            selectOnClose: true,
            formatNoMatches: function() {
                return "Pesquisa não encontrada";
            },
            inputTooShort: function() {
                return "Digite para Pesquisar";
            },
            templateResult: formatState,
            ajax: {
                url: `{{ route('api.handswork.all') }}`,
                dataType: 'json',
                data: function(term, page) {
                    return {
                        search: term, //search term
                    };
                },
                processResults: function(data, page) {
                    var myResults = [];
                    $.each(data.data, function(index, item) {
                        myResults.push({
                            'id': item.id,
                            'text': `${item.code}`,
                            'description': item.description,
                            'price_ups': item.price_ups,
                        });
                    });
                    return {
                        results: myResults
                    };
                }
            },
            escapeMarkup: function(m) {
                return m;
            }
        }

        function formatState(state) {
            return `${state.text} - ${state.description}`;
        };

        function clearNumber(number) {
            if (number == '' || number == null) {
                return 0;
            }
            number = number.toString().replace("R$", "").replace(".", "").replace(".", "");
            number = number.replace(",", ".");
            return number != '' ? numeral(number).value() : 0;
        }

        function numberFormat(number) {
            return number.toLocaleString('pt-br', {
                minimumFractionDigits: 2
            })
        }

        let clickTable = 0;
        let timeButtonConfirm = 0;
        $('.table').on('click', function(e) {
            clickTable++;
            if (clickTable == 2) {
                let target = e.target.closest('tr');
                if (target) {
                    $(target).hasClass('active') ?
                        $(target).removeClass('active') :
                        $(target).addClass('active');
                }
            }
            clearTimeout(timeButtonConfirm);
            timeButtonConfirm = setTimeout(function() {
                clickTable = 0;
            }, 200);
        })
    </script>


    {{--
    <script>
        var alreadyVisited = localStorage.getItem("is_visited");
        tinymce.init({
            selector: '#textarea-observations',
            plugins: 'lists autoresize',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | checklist',
            skin: alreadyVisited == "dark-mode-switch" ? "oxide-dark" : null,
            content_css: alreadyVisited == "dark-mode-switch" ? "dark" : "light",
            height: 300,
            init_instance_callback: function(editor) {
                let timeUpdate
                editor.on('keyup, change', function(e) {
                    let ed = tinymce.get('textarea-observations').getContent();
                    timeUpdate = setTimeout(function() {
                        axios.put(`${base_url}/api/v1/rdse/${rdseId}`, {
                            collumn: 'observations',
                            value: ed,
                        }).catch(error => {
                            toastr.error(error)
                        });
                    }, 1200);
                });
            }
        });

        tinymce.init({
            selector: '#textarea-observations_execution',
            plugins: 'lists autoresize',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | checklist',
            height: 300,
            skin: alreadyVisited == "dark-mode-switch" ? "oxide-dark" : null,
            content_css: alreadyVisited == "dark-mode-switch" ? "dark" : "light",
            init_instance_callback: function(editor) {
                let timeUpdate
                editor.on('keyup, change', function(e) {
                    let ed = tinymce.get('textarea-observations_execution').getContent();
                    timeUpdate = setTimeout(function() {
                        axios.put(`${base_url}/api/v1/rdse/${rdseId}`, {
                            collumn: 'observations_execution',
                            value: ed,
                        }).catch(error => {
                            toastr.error(error)
                        });
                    }, 1200);
                });
            }
        });
    </script>
--}}

    <script>
        let timeUpdateColumns
        $('.input-update').on('change', function() {
            let collumn = $(this).attr('name');
            let value = $(this).val();
            $('.input-update ').not(this).attr('disabled', true);
            clearTimeout(timeUpdateColumns);
            timeUpdateColumns = setTimeout(function() {
                axios.put(`${base_url}/api/v1/rdse/${rdseId}`, {
                    collumn: collumn,
                    value: value,
                }).then(function(response) {
                    toastr.success('Salvo');
                    $('.input-update').attr('disabled', false);
                }).catch(error => {
                    toastr.error(error)
                });
            }, 900);
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
            integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    </script>

@append
