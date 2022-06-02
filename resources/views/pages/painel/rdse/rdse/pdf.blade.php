@extends('app')

@section('title', ucfirst($rdse->description))

@section('content-max-fluid')
    <style>
        .table td,
        .table th {
            padding: 0.3rem;
            vertical-align: top;
        }

        .form-group {
            margin-right: 8px;
        }

        table * a[type=button] {
            vertical-align: -webkit-baseline-middle
        }

        table * input.description_sap {
            text-transform: uppercase;
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

        @media print {

            #button_modal-rdse-codigo,
            #nav-links-rdse,
            .fas.fa-bell,
            .ri-menu-2-line.align-middle,
            .ri-search-line {
                display: none;
            }

            .input-group {
                width: 49%;
            }

            .badge.badge-soft-info {
                border: none
            }

            .table {
                font-size: 10px;
            }
        }

    </style>

    <div class='card'>
        <div class='card-body' style="padding: 1rem 1rem 0 1rem;">
            <div class="d-flex justify-content-between mb-2" style="align-items: end;">
                <div>
                    <h5 class="font-size-12"><i class="mdi mdi-location"></i> Croqui Atualizado Sigeo</h5>
                    <div class="d-flex flex-wrap">
                        <div class="input-group mb-3 w-auto">
                            <span>
                                {{ !empty($rdse->croqui_atualizado_data) ? return_format_date($rdse->croqui_atualizado_data, 'pt') : '' }}
                            </span>
                        </div>
                        <div class="input-group mb-3 w-auto">
                            <span>
                                {{ !empty($rdse->croqui_atualizado_responsavel) ? $rdse->croqui_atualizado_responsavel : '' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <h5 class="font-size-12"><i class="mdi mdi-location"></i> Croqui Validado</h5>
                    <div class="d-flex flex-wrap">
                        <div class="input-group mb-3 w-auto">

                            <span>
                                {{ !empty($rdse->croqui_validado_data) ? return_format_date($rdse->croqui_validado_data, 'pt') : '' }}
                            </span>
                        </div>
                        <div class="input-group mb-3 w-auto">
                            <span>
                                {{ !empty($rdse->croqui_validado_responsavel) ? $rdse->croqui_validado_responsavel : '' }}
                            </span>

                        </div>
                    </div>
                </div>
                <div>
                    <h5 class="font-size-12"><i class="mdi mdi-location"></i> Obra Finalizada</h5>
                    <div class="d-flex flex-wrap">
                        <div class="input-group mb-3 w-auto">
                            <span>
                                {{ !empty($rdse->croqui_finalizado_data) ? return_format_date($rdse->croqui_finalizado_data, 'pt') : '' }}
                            </span>
                        </div>
                        <div class="input-group mb-3 w-auto">
                            <span>
                                {{ !empty($rdse->croqui_finalizado_responsavel) ? $rdse->croqui_finalizado_responsavel : '' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-2" style="    align-items: stretch;">
                <div>
                    <div class='badge badge-soft-{{ $rdse->StatusLabel }} font-size-18'>
                        {{ __trans('rdses.status_label.' . $rdse->status) }}
                    </div>
                </div>
                <div>
                    <h5 class="mt-1 mb-3">{{ $codigoType }} - {{ $rdse->type }}</h5>
                </div>
            </div>

            <div id="table-rdse-clean">

                <table class='table'>
                    <thead class='thead-light'>
                        <tr>
                            <th class="d-none"></th>
                            {{-- <th>Chegada</th> --}}
                            <th style="width: 8%;">Minutos</th>
                            {{-- <th>Saida</th> --}}
                            {{-- <th>Horas</th> --}}
                            <th>SAP</th>
                            <th>Descrição</th>
                            <th class="text-center" style="width: 10%;">Atividade</th>
                            <th style="width: 8%;">Preço</th>

                            @if ($rdse->parcial_1)
                                <th class="text-center">P Qnt 2</th>
                                <th style="width: 8%;">P Preço 2</th>
                            @endif

                            @if ($rdse->parcial_2)
                                <th class="text-center">P Qnt 3</th>
                                <th style="width: 8%;">P Preço 3</th>
                            @endif

                            @if ($rdse->parcial_3)
                                <th class="text-center">P Qnt 4</th>
                                <th style="width: 8%;">P Preço 4</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($rdseServices as $service)
                            <tr class="service-row">
                                {{-- <th>
                                                {{ $service->chegada }}
                                            </th> --}}
                                <th>
                                    {{ $service->minutos }}
                                </th>

                                {{-- <th>
                                                {{ !empty($service->saida) ? $service->saida : '' }}
                                            </th>
                    
                                            <th>
                                                {{ !empty($service->horas) ? $service->horas : '' }}
                                            </th> --}}

                                <th>
                                    {{ !empty($service->handswork) ? $service->handswork->code : '' }}
                                </th>

                                <th>
                                    {{ !empty($service->description) ? $service->description : (!empty($service->handswork) ? $service->handswork->description : '') }}
                                </th>

                                <th class="text-center">
                                    {{ !empty($service->qnt_atividade) ? $service->qnt_atividade : '0' }}
                                </th>
                                <th>
                                    {{ !empty($service->preco) ? $service->preco : '0' }}
                                </th>

                                @if ($rdse->parcial_1)
                                    <th class="text-center">
                                        {{ !empty($service->p_quantidade1) ? $service->p_quantidade1 : '0' }}
                                    </th>
                                    <th>
                                        {{ !empty($service->p_preco1) ? $service->p_preco1 : '0' }}
                                    </th>
                                @endif

                                @if ($rdse->parcial_2)
                                    <th class="text-center">
                                        {{ !empty($service->p_quantidade2) ? $service->p_quantidade2 : '0' }}
                                    </th>
                                    <th>
                                        {{ !empty($service->p_preco2) ? $service->p_preco2 : '0' }}
                                    </th>
                                @endif

                                @if ($rdse->parcial_3)
                                    <th class="text-center">
                                        {{ !empty($service->p_quantidade3) ? $service->p_quantidade3 : '0' }}
                                    </th>
                                    <th>
                                        {{ !empty($service->p_preco3) ? $service->p_preco3 : '0' }}
                                    </th>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="totais my-5">
                    <dl class="row mb-5">
                        <div class="col-8">
                            {!! $rdse->observations !!}
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link mb-2 active" id="v-pills-total-tab" data-toggle="pill" href="#v-pills-total" role="tab" aria-controls="v-pills-total"
                                            aria-selected="true">Total</a>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-total" role="tabpanel" aria-labelledby="v-pills-total-tab">

                                            <div class="row row-xs no-gutters">
                                                <dt class="col-sm-6">Total Espera</dt>
                                                <dd class="col-sm-6 total_espera" style="text-align: end;">R$ {{ maskPrice($totalEspera) }}</dd>

                                                <dt class="col-sm-6">Total Serviços</dt>
                                                <dd class="col-sm-6 total_servico" style="text-align: end;">R$ {{ maskPrice($totalServico) }}</dd>

                                                @if ($rdse->parcial_1)
                                                    <dt class="col-sm-6">Total P1 R$</dt>
                                                    <dd class="col-sm-6 total_p1" style="text-align: end;">R$ {{ maskPrice($totalP1) }}</dd>
                                                @endif

                                                <dt class="col-sm-6">Total R$</dt>
                                                <dd class="col-sm-6 total" style="text-align: end;">R$ {{ maskPrice($total) }}</dd>

                                                <dt class="col-sm-6 text-truncate">Total UPS</dt>
                                                <dd class="col-sm-6 total_ups" style="text-align: end;">{{ maskPrice($totalUps) }}</dd>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script class="">
        window.addEventListener('load', () => {
            window.print()
        });
    </script>
@append
