@extends('app')

@section('title', "RDSE'S")

@section('content-max-fluid')

    <style>
        @media print {

            .table-responsive {
                -webkit-overflow-scrolling: touch !important;
                display: inline !important;
                overflow-x: auto !important;
                width: 120% !important;
            }

            .badge {
                border: none !important;
            }

            table thead tr th:first-child,
            table tbody tr td:first-child,
            table tfoot tr th:first-child {
                display: none !important;
            }

        }

        .fixed-table-body {
            overflow: visible !important;
        }
    </style>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4 no-print">

                <div class="col-12">
                    <div class="card text-start">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Filtro RDSE</h4>

                            <div class="row">
                                <div class="col-12 col-md-auto mb-2" style="min-width: 180px">
                                    <label>Status de Medição</label>
                                    <select id="rdse-select_status" name="status" class="form-control select2 search-input-rdse" multiple>
                                        @foreach (trans('rdses.status_label') as $status => $text)
                                            <option value='{{ $status }}'
                                                    {{ request()->filled('status') && in_array($text, request()->input('status')) ? 'selected="selected"' : null }}>
                                                {{ __trans('rdses.status_label.' . $status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-auto" style="min-width: 180px">
                                    <label>Status de Programação</label>
                                    <select id="rdse-select_status_execution" name="status_execution" class="form-control select2 search-input-rdse" multiple>
                                        @foreach (trans('rdses.status_execution') as $status_execution)
                                            <option value='{{ $status_execution }}'
                                                    {{ request()->filled('status_execution') && in_array($text, request()->input('status_execution')) ? 'selected="selected"' : null }}>
                                                {{ $status_execution }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-auto" style="min-width: 180px">
                                    <label>Status de Encerramento</label>
                                    <select id="rdse-select_status_closing" name="status_closing" class="form-control select2 search-input-rdse" multiple>
                                        @foreach (\App\Supports\Enums\Rdse\RdseClosingStatus::options() as $status_closing)
                                            <option value='{{ $status_closing['value'] }}'>
                                                {{ $status_closing['label_translate'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-3 col-lg-2 col-xl-2 col-xxl-2">
                                    <label>Tipo</label>
                                    <select id="rdse-select--type" name="type" class="form-control select2 search-input-rdse">
                                        <option value="">Selecione</option>
                                        @foreach (config('admin.rdse.type') as $type)
                                            <option value='{{ $type['name'] }}'
                                                    {{ (!request()->filled('type') && $type['name'] == 'Em Medição' ? ' selected="selected"' : request()->filled('type') && request()->input('type') == $type['name']) ? ' selected="selected"' : '' }}>
                                                {{ $type['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="div-search_lote" class="col-12 col-md-3 col-lg-2 col-xl-2 col-xxl-2">
                                    <label>Lote</label>
                                    <select id="rdse-select--lote" name="lote" class="form-control select2 search-input-rdse">
                                        <option value="">Selecione</option>
                                        @foreach ($lotes as $lote)
                                            <option value='{{ $lote->lote }}'>{{ $lote->lote }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-3 col-lg-2 col-xl-auto col-xxl-2">
                                    <label>Data</label>
                                    <input type="text" class="form-control search-input-rdse" name="daterange"
                                           @if (request()->input('daterange') != null) value="{{ $date_to }} - {{ $date_from }}" @endif />
                                </div>

                                <div class="col-12 col-md-1">
                                    <label for="rdse-diretoria">Diretoria</label>
                                    <select id="rdse-diretoria" name="diretoria" class="form-control search-input-rdse" required tabindex="1">
                                        <option value="">Selecione </option>
                                        <option value='PM'>PM </option>
                                        <option value='HV'>HV </option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-auto">
                                    <label for="rdse-tipo_obra">Tipo de Obra</label>
                                    <select id="select--tipo_obra" name="tipo_obra" class="form-control select-tipo_obra t-select  search-input-rdse"
                                            data-request="{{ route('tipos_obra.all') }}" data-value-field="id" required>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12 col-md-1">
                                    <label>Mês</label>
                                    <select id="mes" name="month_date" class="form-control search-input-rdse">
                                        <option selected value="">Selecione</option>
                                        <option value="01">Janeiro</option>
                                        <option value="02">Fevereiro</option>
                                        <option value="03">Março</option>
                                        <option value="04">Abril</option>
                                        <option value="05">Maio</option>
                                        <option value="06">Junho</option>
                                        <option value="07">Julho</option>
                                        <option value="08">Agosto</option>
                                        <option value="09">Setembro</option>
                                        <option value="10">Outubro</option>
                                        <option value="11">Novembro</option>
                                        <option value="12">Dezembro</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-1">
                                    <label>Ano</label>
                                    <select id="year" name="year" class="form-control search-input-rdse">
                                        <option value="all">Todos</option>
                                        <option {{ request()->input('year') == '2024' ? 'selected' : null }} value="2024">2024</option>
                                        <option {{ request()->input('year') == '2025' ? 'selected' : null }} value="2025">2025</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-1">
                                    <label>NFE</label>
                                    <input type="text" class="form-control search-input-rdse" name="nfe" value="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card text-start">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Filtro Atividades</h4>
                            <div class="row">
                                <div class="col-12 col-md-1">
                                    <label>Atividades</label>
                                    <select id="rdse-atividades" name="atividades" class="form-control select2 search-input-rdse">
                                        <option value="all">Todas</option>
                                        <option value="nao_execucao">Não executado</option>
                                        <option value="execucao">Executado</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-1" style="min-width: 180px">
                                    <label>Equipe</label>
                                    <select id="rdse-equipe" name="equipe_id" class="form-control select2 search-input-rdse">
                                        <option value="">Selecione</option>
                                        @foreach (equipes() as $equipe)
                                            <option value='{{ $equipe->id }}'>{{ $equipe->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-3 col-xl-2">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Data:</label>
                                        <select data-target="date-fields-1" name="period" class="form-select t-select search-input-rdse period-select">
                                            <option value="" selected>Selecione</option>
                                            <option value="today">Hoje</option>
                                            <option value="yesterday">Ontem</option>
                                            <option value="tomorrow">Amanhã</option>
                                            <option value="next_3_days">Próximos 03 dias</option>
                                            <option value="next_5_days">Próximos 05 dias</option>
                                            <option value="last_3_days">Últimos 03 dias</option>
                                            <option value="last_5_days">Últimos 05 dias</option>
                                            <option value="last_15_days">Últimos 15 dias</option>
                                            <option value="last_30_days">Últimos 30 dias</option>
                                            <option value="next_15_days">Próximos 15 dias</option>
                                            <option value="next_30_days">Próximos 30 dias</option>
                                            <option value="specific">Período específico</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-3 col-xl-2">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Periodo:</label>
                                        <select name="hour" class="form-select t-select search-input-rdse ">
                                            <option value="all" selected>Todos</option>
                                            <option value="diurno">Diurno</option>
                                            <option value="noturno">Noturno</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div data-id="date-fields-1" class="mb-3 date-fields row d-none">
                                        <div class="form-group col-12 col-md-2" style="min-width: 180px">
                                            <label class="form-label">De</label>
                                            <input type="date" name="start_at" class="form-control datetimepicker flatpickr-input search-input-rdse">
                                        </div>

                                        <div class="form-group col-12 col-md-2" style="min-width: 180px">
                                            <label class="form-label">Até</label>
                                            <input type="date" name="end_at" class="form-control datetimepicker flatpickr-input search-input-rdse">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input id="totalTable" type="hidden">
                <input id="totalP1" type="hidden">
                <input id="totalP2" type="hidden">
                <input id="totalP3" type="hidden">
                <input id="totalUpsTable" type="hidden">
            </div>

            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar" class="no-print">
                        <div class="form-inline" role="form">
                            <div class="">
                                <button type="button" data-toggle="modal" data-target="#modal-add-rdse" class="btn btn-dark waves-effect waves-light">
                                    <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                                </button>

                                <button type="button" data-toggle="modal" data-target="#modal-export-activity"
                                        class="btn btn-outline-primary waves-effect waves-light mr-2">
                                    <i class="ri-add-circle-line align-middle mr-2"></i> Exportar Atividades
                                </button>

                                <button type="button" data-toggle="modal" data-target="#modal-import"
                                        class="btn btn-outline-primary waves-effect waves-light mr-2">
                                    <i class="ri-add-circle-line align-middle mr-2"></i> Importar Planilha
                                </button>

                            </div>
                        </div>
                    </div>
                    <table id="ttable" data-toggle="table" data-table="rdses" data-on-click="true" data-target="false">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="state" data-checkbox="true"></th>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="n_order" data-sortable="true" data-width="10">Nº Ordem</th>
                                <th data-field="description_limit">Descrição / Endereço</th>
                                <th data-field="tipo_obra" data-formatter="tipo_obra">Tipo de Obra</th>
                                <th data-field="status_execution" data-formatter="statusExecution">Status de Programação</th>
                                <th data-field="atividades" data-width="500">Atividades Programação</th>
                                <th data-field="sigeo" data-formatter="sigeo">Viab Sigeo</th>
                                <th data-field="diretoria">Diretoria</th>
                                <th data-field="apr_at" data-formatter="aprInput">Data Pré APR</th>
                                <th data-field="enel_deadline" data-formatter="enelDeadline">Data Limite ENEL</th>
                                <th data-field="observations" data-formatter="observationInput">Obs</th>
                                <th data-field="sigeo_at" data-formatter="sigeoInput">Sigeo</th>
                                <th data-field="month">Mês</th>

                                {{--
                                <th data-field="total_p1" data-visible="false" data-footer-formatter="valor_totalp1">Valor P2</th>
                                <th data-field="total_p2" data-visible="false" data-footer-formatter="valor_totalp2">Valor P3</th>
                                <th data-field="total_p3" data-visible="false" data-footer-formatter="valor_totalp3">Valor P4</th>
                                <th data-field="parcial">Parcial</th>
                                --}}

                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="changeStatus" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="form-rdse_change_status" role="form" class="needs-validation" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button id="btn-submit-rdse_change_status" type="button" class="btn btn-primary">Enviar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="rdses-downloading" class="pos-fixed b-10 r-10 z-index-200 d-none">
        <div class='card'>
            <form id='form-download-rdse' role='form' class='needs-validation' action='' method='POST'>
                <input id="rdse--input" type="hidden" name="rdse">
                <input id="rdse--id" name="rdseId" class="d-none">
                @csrf
                <div class='card-header bg-primary'>
                    <h6 class="tx-white mg-b-0 mg-r-auto">Selecionados</h6>
                </div>
                <div id="rdses-row" class='card-body pd-15'></div>
                <div class="card-footer">
                    <button type='button' class='btn btn-primary mr-3 d-none btn-save-lote' data-toggle='modal' data-target='#modal-update_lote'>
                        <i class="fas fa-save"></i> Alterar Lote
                    </button>
                    @include('pages.painel.rdse._partials.buttons', [request()->input('status')])
                </div>
            </form>
        </div>
    </div>

    <div id='modal-update_lote' class='modal' tabindex='-1' role='dialog'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <form id='form-update_rdse_lote' role='form' class='needs-validation' action='{{ route('rdse.update.lote') }}' method='POST'>
                    @csrf
                    <div class='modal-header'>
                        <h5 class='modal-title'>Alterar Lote</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        <div class='form-group'>
                            <label for='input--lote'>Lote</label>
                            <input id="input-lote-update" type="hidden" name="alterLote">
                            <select id="select--lotes" class="form-control" name="lote"></select>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-primary btn-submit'>Salvar</button>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('pages.painel._partials.modals.modal-add', ['redirect' => 'rdse.index', 'type' => 'rdse'])


    {{--
    <!-- Modal de Observação -->
    <div id="observationModal" class="modal fade" tabindex="-1" aria-labelledby="observationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="observationModalLabel" class="modal-title">Editar Observação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="observationForm">
                        <div class="form-group">
                            <label for="observationInput">Observação</label>
                            <input id="observationInput" type="text" class="form-control" name="observation" placeholder="Digite a observação">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" onclick="saveObservation()">Salvar Alterações</button>
                </div>
            </div>
        </div>
    </div>
--}}

    @include('pages.painel.rdse._partials.modal-observations')

    @include('pages.painel.rdse._partials.modal-updateStatus')

    @include('pages.painel.rdse.rdse.atividade.modal_add_atividade')

    <div id="modal-export-activity" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exportModalLabel" class="modal-title">Exportar Atividades</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="exportForm" method="GET" action="{{ route('rdse.atividades.export') }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <label>Data:</label>
                                <select data-target="date-fields-2" name="period" class="form-control t-select period-select" required>
                                    <option value="" selected>Selecione</option>
                                    <option value="today">Hoje</option>
                                    <option value="yesterday">Ontem</option>
                                    <option value="tomorrow">Amanhã</option>
                                    <option value="next_3_days">Próximos 03 dias</option>
                                    <option value="next_5_days">Próximos 05 dias</option>
                                    <option value="last_3_days">Últimos 03 dias</option>
                                    <option value="last_5_days">Últimos 05 dias</option>
                                    <option value="last_15_days">Últimos 15 dias</option>
                                    <option value="last_30_days">Últimos 30 dias</option>
                                    <option value="next_15_days">Próximos 15 dias</option>
                                    <option value="next_30_days">Próximos 30 dias</option>
                                    <option value="specific">Período específico</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-12 mt-3">
                                <div class="mb-3 form-group">
                                    <label class="form-label">Periodo:</label>
                                    <select name="hour" class="form-select t-select  " required>
                                        <option value="all" selected>Todos</option>
                                        <option value="diurno">Diurno</option>
                                        <option value="noturno">Noturno</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 col-md-12">
                                <div data-id="date-fields-2" class="mb-3 date-fields row d-none">
                                    <div class="form-group col-12 col-md-2" style="min-width: 180px">
                                        <label class="form-label">De</label>
                                        <input type="date" name="start_at" class="form-control datetimepicker flatpickr-input">
                                    </div>

                                    <div class="form-group col-12 col-md-2" style="min-width: 180px">
                                        <label class="form-label">Até</label>
                                        <input type="date" name="end_at" class="form-control datetimepicker flatpickr-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Exportar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exportModalLabel" class="modal-title">Importar Planilha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('rdse.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="card ">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input id="file_document" type="file" name="file" required>
                                            <p class="help-block">somente arquivos <b>EXCEL</b></p>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Importar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalId" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalTitleId" class="modal-title">
                        Adicionar em Massa
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('rdse.store') }}">
                        @csrf

                        <div id="formulario">
                            <div class="linha-formulario">
                                <div class="row">
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label>Descrição / Endereço</label>
                                            <input type="text" name="description[]" class="form-control @error('description') is-invalid @enderror"
                                                   autocomplete="off" required>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label>Tipo</label>
                                            <select name="type[]" class="form-control select2">
                                                @foreach (config('admin.rdse.type') as $status)
                                                    <option value="{{ $status['name'] }}">{{ $status['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label>Solicitante</label>
                                            <input type="text" name="solicitante[]" class="form-control @error('solicitante') is-invalid @enderror"
                                                   value="{{ auth()->user()->name }}" autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label>Data</label>
                                            <input type="text" name="at[]" class="form-control date @error('at') is-invalid @enderror"
                                                   value="{{ date('d/m/Y') }}" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-2">
                                        <div class="form-group">
                                            <label>Data Mês</label>
                                            <select name="month_date[]" class="form-control" required>
                                                <option value="">Selecione</option>
                                                <option value="01">Janeiro</option>
                                                <option value="02">Fevereiro</option>
                                                <option selected value="03">Março</option>
                                                <option value="04">Abril</option>
                                                <option value="05">Maio</option>
                                                <option value="06">Junho</option>
                                                <option value="07">Julho</option>
                                                <option value="08">Agosto</option>
                                                <option value="09">Setembro</option>
                                                <option value="10">Outubro</option>
                                                <option value="11">Novembro</option>
                                                <option value="12">Dezembro</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label>Ano</label>
                                            <select name="year[]" class="form-control" required>
                                                <option value="">Selecione</option>
                                                <option value="2024">2024</option>
                                                <option selected value="2025">2025</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label>Diretoria</label>
                                            <select name="diretoria[]" class="form-control" required>
                                                <option value="">Selecione</option>
                                                <option value="PM">PM</option>
                                                <option value="HV">HV</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-2">
                                    <button type="button" class="btn btn-danger btn-remover">Remover</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <button id="btn-adicionar" type="button" class="btn btn-primary">Adicionar mais</button>
                            <button type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>



    <style class="">
        /* Estilos customizados para o sidebar */
        .sidebar {
            height: 100vh;
            width: 25%;
            position: fixed;
            top: 0rem;
            bottom: 0rem;
            right: 0;
            background-color: #fff;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            z-index: 1050;
            border-radius: 2%;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }

        #sidebarDireita {
            overflow: auto;
        }

        .sidebar.show+.overlay {
            display: block;
        }

        #sidebarDireita .txt {
            float: inline-end;
        }
    </style>

    <!-- Sidebar -->
    <div id="sidebarDireita" data class="sidebar collapse ">
        <div class="p-3">

            <div class="d-flex justify-content-between">
                <h5 class="mb-3">Programação</h5>
                <div class="d-flex gap-3" style="gap:1rem">
                    <a href="javscript:void(0)" data-toggle="collapse" data-target="#sidebarDireita">
                        <i class="fas fa-expand-alt"></i>
                    </a>

                    <a href="javscript:void(0)" class="" data-toggle="collapse" data-target="#sidebarDireita">
                        <i class="far fa-times-circle"></i>
                    </a>
                </div>
            </div>

            <div class="mt-3 row">
                <div class="col-12">
                    <h6 class="">Atividades</h6>
                    <table class="w-100">
                        <tbody>
                            <tr>
                                <td class="align-top py-1">
                                    <div class="d-flex">
                                        <h6 class="text-body mb-0 text-nowrap">Endereço :</h6>
                                    </div>
                                </td>
                                <td class="ps-3 py-1"><a class="txt fw-semibold d-block lh-sm description" href="#!"> </a></td>
                            </tr>
                            <tr>
                                <td class="align-top py-1">
                                    <div class="d-flex">
                                        <h6 class="text-body mb-0 text-nowrap">Tipo de Obra:</h6>
                                    </div>
                                </td>
                                <td class="ps-3 py-1">
                                    <a class="txt fw-semibold d-block lh-sm tipo_obra_nome" href="#!"></a>
                                </td>
                            </tr>

                            <tr>
                                <td class="align-top py-1">
                                    <div class="d-flex">
                                        <h6 class="text-body mb-0 text-nowrap">Status da Obra: </h6>
                                    </div>
                                </td>
                                <td class="ps-3 py-1"><a class="txt fw-semibold d-block lh-sm status_execution" href="#!"></a>
                                </td>
                            </tr>

                            <tr>
                                <td class="align-top py-1">
                                    <div class="d-flex">
                                        <h6 class="text-body mb-0 text-nowrap">Data: </h6>
                                    </div>
                                </td>
                                <td class="ps-3 py-1"><a class="txt fw-semibold d-block lh-sm at" href="#!"></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <div class="card text-start">
                        <div class="card-body">

                            <ul id="sidebarContentAtividades" class=""></ul>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay" data-toggle="collapse" data-target="#sidebarDireita"></div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Adicionar nova linha
            $('#btn-adicionar').click(function() {
                var novaLinha = $('.linha-formulario:first').clone();
                novaLinha.find('input').val(''); // Limpa os valores dos inputs
                novaLinha.find('select').val(''); // Limpa os valores dos selects
                novaLinha.appendTo('#formulario');

                // Reinicie plugins como Select2 ou datepicker, se estiver usando
                // novaLinha.find('.select2').select2();
                // novaLinha.find('.date').datepicker();
            });

            // Remover linha
            $(document).on('click', '.btn-remover', function() {
                if ($('.linha-formulario').length > 1) {
                    $(this).closest('.linha-formulario').remove();
                } else {
                    alert('Você deve manter pelo menos uma linha.');
                }
            });
        });
    </script>
@append

@section('scripts')
    @yield('modal-scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script src="{{ asset('panel/js/pages/rdse/rdse.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        jQuery(function() {
            'use strict'
            initButtons();
            initTable();
        });

        function openModaladdItemsModal(row) {
            let id = $(row).data("id");
            $('#modalrdseId').val(id);
            $('#modaladdItemsModal').modal('show');
        }


        //$('#rdse-select_status').on('change', function() {
        //let state = $(this).val();
        //let arrStr = encodeURIComponent(JSON.stringify(state));
        //localStorage.setItem('rdse-selecteds', JSON.stringify([]));
        //if (state[0] == `{{ request()->input('status')[0] }}`) {
        //    window.location.href = `${base_url}/rdse/rdse?status=${arrStr}`;
        //}
        //})

        if (localStorage.getItem('rdse-select_status_execution')) {
            $('#rdse-select_status_execution').val(JSON.parse(localStorage.getItem('rdse-select_status_execution'))).trigger('change');
        }

        if (localStorage.getItem('rdse-select_status_closing')) {
            $('#rdse-select_status_closing').val(JSON.parse(localStorage.getItem('rdse-select_status_closing'))).trigger('change');
        }

        if (localStorage.getItem('rdse-select_status')) {
            $('#rdse-select_status').val(JSON.parse(localStorage.getItem('rdse-select_status'))).trigger('change');
        }

        if (localStorage.getItem('rdse-select--type')) {
            $('#rdse-select--type').val(JSON.parse(localStorage.getItem('rdse-select--type'))).trigger('change');
        }

        if (localStorage.getItem('rdse-select--lote')) {
            $('#rdse-select--lote').val(JSON.parse(localStorage.getItem('rdse-select--lote'))).trigger('change');
        }

        $('.search-input-rdse').on('change', function() {
            const value = $(this).val();
            const id = $(this).attr('id');
            localStorage.setItem(id, JSON.stringify(value));
            localStorage.setItem('rdse-selecteds', JSON.stringify([]));
            initButtons();

            if (id == 'input--start_at') {
                if ($('#input--end_at').val() == '' || $(this).val() == '') {
                    return;
                }
            }

            if (id == 'input--end_at') {
                if ($('#input--start_at').val() == '' || $(this).val() == '') {
                    return;
                }
            }

            if ($(this).val() == 'specific') {
                const startAt = document.getElementById('input--start_at');
                const endAt = document.getElementById('input--end_at');
                if (startAt.value == '' || endAt.value == '') {
                    return;
                }
            }

            initTable();
        })

        function initButtons() {
            $('.div__pending').addClass('d-none')

            let selected = $('#rdse-select_status').val();
            //if (selected != 'pending') {
            //    $('#div-search_lote').removeClass('d-none')
            //} else {
            //    $('#div-search_lote').addClass('d-none')
            //    $('#rdse-select--lote').val('').trigger('change');
            //}
            $(`#div-${selected[0]}`).removeClass('d-none')

            selected.length == 1 ? $("#buttons-alter-status").removeClass('d-none') :
                $("#buttons-alter-status").addClass('d-none')
        }

        async function initTable() {
            await buscarItens();


            /**
             * Rdse Selecionados
             */
            const getRdseSelected = function() {
                return localStorage.getItem('rdse-selecteds') ? JSON.parse(localStorage.getItem('rdse-selecteds')) : [];
            }

            const setRdseSelected = function(rdsesItems) {
                localStorage.setItem('rdse-selecteds', JSON.stringify(rdsesItems));
                getDivItensSelected();
            }

            const hasItemSelected = function(item) {
                let rdses = getRdseSelected();
                if (!item.id)
                    return false
                return rdses.some(rdse => item.id == rdse.id)
            }

            const getDivItensSelected = function() {
                let rdses = getRdseSelected();
                let obj = Object.keys(rdses).map(f => rdses[f].id);
                let implode = obj.join([obj = ',']);
                $('#rdses-row').html('');
                if (rdses.length > 0) {
                    $.each(rdses, function(index, value) {
                        $('#rdses-row').append('<h6>' + rdses[index]['name'] + ' <a href="javascript:void(0)" data-id="' + rdses[index]['id'] +
                            '" class="removeItem"><i class="fas fa-trash ml-2 tx-danger"></i></a></h6>')
                    });
                    $("#rdses--input").val(JSON.stringify(rdses));
                    $("#rdses--id").val(implode);
                    $('#rdses-downloading').removeClass('d-none');
                    $('.removeItem').on('click', function() {
                        var id = $(this).attr('data-id');
                        for (var i = 0; i < rdses.length; i++) {
                            if (rdses[i].id == id) {
                                rdses.splice(i, 1);
                                localStorage.setItem('rdse-selecteds', JSON.stringify(rdses));
                                getDivItensSelected();
                            }
                        }
                    })

                    if ($('#rdse-select--lote').val() != '') {
                        $('.btn-save-lote').removeClass('d-none')
                        $('#input-lote-update').val($('#rdse-select--lote').val());
                    } else {
                        $('.btn-save-lote').addClass('d-none')
                        $('#input-lote-update').val();
                    }

                } else {
                    $('#rdses-downloading').addClass('d-none');
                }
            }

            const items = function() {
                let rdses = getRdseSelected();
                return rdses.map(({
                    id
                }) => ({
                    id
                }));
            }

            const BASE_URL_API = $('meta[name="js-base_url_api"]').attr('content');
            const BASE_URL = $('meta[name="js-base_url"]').attr('content');
            const URL = $('meta[name="url"]').attr('content');

            const $table = $('#ttable');
            var dataTable = $table.attr('data-table');
            var order = $table.attr('order');
            var filter = {};
            let selections = [];

            $('#preloader-content').remove();

            $('.table-api').append(preload());

            $.each($('.search-input-rdse'), function() {
                if ($(this).attr('name') != undefined) {
                    filter[$(this).attr('name')] = $(this).val() ?? '';
                }
            });

            window.parseCurrency = (value) => {
                if (value === null || value === undefined || value === '') {
                    return 0;
                }
                return parseFloat(value.replace(' meses', '').replace('%', '').replace('R$', '').replace('R$ ', '').replace(/\./g, '').replace(',', '.'));
            }



            if ($table.length > 0) {
                var paginate = $table.attr('data-paginate') != undefined ? false : true;
                var eExport = $table.attr('data-export') != undefined ? false : true;
                var showColumns = $table.attr('data-collums') != undefined ? false : true;
                var clickToSelect = $table.attr('data-click-select') != undefined ? false : true;
                var click = $table.attr('data-click');

                $table.bootstrapTable('refreshOptions', {
                    locale: 'pt-BR',
                    method: 'get',
                    url: `${BASE_URL_API}${dataTable}`,
                    dataType: 'json',
                    classes: 'table table-hover table-striped ',
                    pageList: "[10, 25, 50, 100, all]",
                    cookie: true,
                    cache: true,
                    search: true,
                    showExport: eExport,
                    showColumns: showColumns,
                    idField: 'id',
                    toolbar: '#toolbar',
                    buttonsClass: 'dark',
                    showColumnsToggleAll: true,
                    pageSize: 20,
                    cookieIdTable: 'rdseTable',
                    queryParamsType: 'all',
                    striped: true,
                    pagination: paginate,
                    sidePagination: "server",
                    pageNumber: 1,
                    cookiesEnabled: "['bs.table.sortOrder', 'bs.table.sortName', 'bs.table.columns', 'bs.table.pageNumber', 'bs.table.pageList', 'bs.table.columns', 'bs.table.searchText', 'bs.table.filterControl',]",
                    mobileResponsive: true,
                    showFooter: true,
                    queryParams: function(p) {
                        return {
                            sort: p.sortName ?? order,
                            order: p.sortOrder,
                            search: p.searchText,
                            page: p.pageNumber,
                            pageSize: paginate ? p.pageSize : 'all',
                            filter: filter ?? {}
                        };
                    },
                    responseHandler: function(res) {
                        var valorTotal = 0;
                        var valorP1 = 0;
                        var valorP2 = 0;
                        var valorP3 = 0;
                        var valorUpsTotal = 0;
                        $.each(res.data, function(index, value) {
                            valorP1 += parseFloat(value.total_p1)
                            valorP2 += parseFloat(value.total_p2)
                            valorP3 += parseFloat(value.total_p3)
                            valorTotal += parseCurrency(value.valor)
                            valorUpsTotal += parseFloat(value.ups)
                        });

                        $('#totalP1').val(valorP1.toLocaleString('pt-br', {
                            minimumFractionDigits: 2
                        }));
                        $('#totalP2').val(valorP2.toLocaleString('pt-br', {
                            minimumFractionDigits: 2
                        }));
                        $('#totalP3').val(valorP3.toLocaleString('pt-br', {
                            minimumFractionDigits: 2
                        }));

                        $('#totalTable').val(valorTotal.toLocaleString('pt-br', {
                            minimumFractionDigits: 2
                        }));

                        $('#totalUpsTable').val(valorUpsTotal.toLocaleString('pt-br', {
                            minimumFractionDigits: 2
                        }));
                        return {
                            total: res.meta ? res.meta.total : null,
                            rows: res.data
                        };
                    },
                    onClickCell: function(field, value, row, $element) {

                        //if (fiel == 'sigeo_at') {
                        //    axios.post(`${base_url}/api/v1/rdse/${rdseId}/update-status-execution`, {
                        //            _method: 'PUT',
                        //            status_execution: $('#modalUpdateStatus input[name="status"]').val(),
                        //            status_observation: $('#modalUpdateStatus #form-updateStatusRdse textarea[name="status_observation"]')
                        //            .val(),
                        //        }).then(function(error) {
                        //            toastr.success('Alterado');
                        //            $('#modalUpdateStatus').modal('hide');
                        //        })
                        //        .catch(function(error) {
                        //            toastr.error(error);
                        //        });
                        //}

                        if (field === 'description_limit') {

                            axios.get(`${BASE_URL}/api/v1/rdses/${row.id}`)
                                .then(function(response) {

                                    const filters = getFilters();

                                    // Faz a requisição Axios com o ID e os filtros como parâmetros
                                    const responseAtividades = axios.get(`${BASE_URL}/api/v1/rdses/${row.id}/atividades`, {
                                        params: filters // Passa os filtros como query parameters
                                    }).then(function(responseAtividades) {
                                        const atividades = responseAtividades.data.data;

                                        const sidebarContentAtividades = document.querySelector('#sidebarContentAtividades');
                                        sidebarContentAtividades.innerHTML = ''; // Limpa o conteúdo anterior

                                        if (atividades.length > 0) {
                                            // Itera sobre as atividades e cria o HTML
                                            atividades.forEach(atividade => {
                                                const atividadeHTML = `
                                                <li style="margin-bottom: 1.5rem;">
                                                    ${atividade.equipe} - ${atividade.data_format}
                                                    <br>
                                                    ${atividade.atividades}
                                                </li>
                                            `;
                                                sidebarContentAtividades.innerHTML += atividadeHTML;
                                            });
                                        } else {
                                            sidebarContentAtividades.innerHTML = '<p>Nenhuma atividade encontrada.</p>';
                                        }
                                    })

                                    const data = response.data.data;

                                    // Preenche cada campo do sidebar com os dados da resposta
                                    document.querySelector('#sidebarDireita .description').innerHTML = data.description || 'N/A';
                                    document.querySelector('#sidebarDireita .tipo_obra_nome').innerHTML = data.tipo_obra_nome || 'N/A';
                                    document.querySelector('#sidebarDireita .status_execution').innerHTML = data.status_execution || 'N/A';
                                    document.querySelector('#sidebarDireita .at').innerHTML = data.month || 'N/A';

                                    $('#sidebarDireita').collapse('show');
                                })
                                .catch(function(error) {
                                    console.error('Erro ao carregar dados:', error);
                                    $('#sidebarContent').html('<p>Erro ao carregar os dados.</p>');
                                    $('#sidebarDireita').collapse('show');
                                });

                            return;
                        }


                        if (click == 'false' || field == 'state' || field == 'status_execution' || field == 'apr_at' || field == 'is_civil' ||
                            field == 'enel_deadline' || field == 'observations' || field == 'atividades' || field == 'type' || field ==
                            'tipo_obra' || field == 'sigeo' || field == 'sigeo_at'

                        ) {
                            return;
                        }
                        if (field != 'statusButton') {
                            window.open(`${BASE_URL}${URL}/${row.id}`, '_blank')
                        }
                    },
                    onLoadSuccess: function() {
                        $('#preloader-content').remove();
                        $('.table-responsive').removeClass('d-none');
                        $('.date').mask('00/00/0000');
                    }
                });

                $table.on('check.bs.table uncheck.bs.table ' +
                    'check-all.bs.table uncheck-all.bs.table',
                    function() {
                        // $('.btn-states').attr('disabled', !$table.bootstrapTable('getSelections').length)
                        selections = getIdSelections()
                    })

                function getIdSelections() {
                    return $.map($table.bootstrapTable('getSelections'), function(row) {
                        let item = {
                            id: row.id,
                            name: `${row.id} - ${row.n_order} - ${row.description} - ${row.type}`
                        }
                        saveItemRdses(item);
                    })
                }

                function getFilters() {
                    // Captura os valores dos campos
                    const atividades = document.querySelector('#rdse-atividades').value; // 'all', 'nao_execucao', 'execucao'
                    const equipe = document.querySelector('#rdse-equipe').value; // ID da equipe ou vazio
                    const period = document.querySelector('.period-select').value; // 'today', 'yesterday', 'specific', etc.
                    const hour = document.querySelector('select[name="hour"]').value; // 'all', 'diurno', 'noturno'
                    const start_at = document.querySelector('input[name="start_at"]').value; // Data inicial (se "specific")
                    const end_at = document.querySelector('input[name="end_at"]').value; // Data final (se "specific")

                    // Se o período for "specific", usa as datas start_at e end_at; caso contrário, usa o period
                    const dateFilter = period == 'specific' ? {
                        start_at,
                        end_at
                    } : {
                        period
                    };

                    // Retorna um objeto com todos os filtros
                    return {
                        atividades,
                        equipe,
                        hour,
                        period,
                        start_at,
                        end_at
                    };
                }

                const saveItemRdses = function(item) {
                    let rdses = getRdseSelected()
                    if (hasItemSelected(item)) {
                        rdses.forEach(rdseItem => {
                            if (rdseItem.id == item.id) {
                                rdseItem.name = item.name
                            }
                        })
                    } else {
                        if (!item.id)
                            item.id = rdses.length + 1
                        rdses.push(item)
                    }
                    setRdseSelected(rdses)
                }

                $table.on('check.bs.table uncheck.bs.table ' +
                    'check-all.bs.table uncheck-all.bs.table',
                    function() {
                        selections = getIdSelections();
                    })
            }

            getDivItensSelected();

        }

        function valor_total_sum(data, footerValue) {
            return 'R$ ' + $('#totalTable').val()
        }

        function valor_totalp1(data, footerValue) {
            return 'R$ ' + $('#totalP1').val()
        }

        function valor_totalp2(data, footerValue) {
            return 'R$ ' + $('#totalP2').val()
        }

        function valor_totalp3(data, footerValue) {

            return 'R$ ' + $('#totalP3').val()
        }

        function valor_ups_sum(data, footerValue) {
            return $('#totalUpsTable').val()
        }

        function statusExecution(value, row) {
            return `
            <select name="" class="form-control form-control-sm" id="select-status_execution" onchange="updateStatusExecution(this, ${row.id})">
                <option value="Carteira"> Carteira</option>

                <option ${value == 'Impedimento' ? 'selected' : ''} value="Impedimento">  Impedimento </option>
                <option ${value == 'Cancelada' ? 'selected' : ''} value="Cancelada">  Cancelada </option>
                <option ${value == 'Viabilidade' ? 'selected' : ''} value="Viabilidade">  Viabilidade </option>
                <option ${value == 'Liberada' ? 'selected' : ''} value="Liberada">  Liberada </option>
                <option ${value == 'Programada' ? 'selected' : ''} value="Programada">  Programada </option>
                <option ${value == 'Execução 25%' ? 'selected' : ''} value="Execução 25%"> Execução 25%</option>
                <option ${value == 'Execução 50%' ? 'selected' : ''} value="Execução 50%"> Execução 50%</option>
                <option ${value == 'Execução 75%' ? 'selected' : ''} value="Execução 75%"> Execução 75%</option>
                <option ${value == 'Execução 100%' ? 'selected' : ''} value="Execução 100%">Execução 100%</option>
            </select>
            `
        }


        let opcoesTipoObra = [];

        // Função para buscar as opções (executada apenas uma vez)
        async function buscarItens() {
            try {
                // Fazendo a requisição com axios
                const resposta = await axios.get('{{ route('tipos_obra.all') }}', {
                    params: {
                        pageSize: 'all'
                    }
                });

                // Verificando se a resposta contém dados
                if (resposta.data.data && Array.isArray(resposta.data.data)) {
                    opcoesTipoObra = resposta.data.data; // Armazenando as opções na variável global
                } else {
                    console.log('Nenhum dado encontrado');
                }
            } catch (error) {
                console.error('Erro ao carregar as opções:', error);
            }
        }

        function tipo_obra(value, row) {
            // Chama a função de criação do select com as opções pré-carregadas
            return criarSelect(value, row.id);
        }

        function criarSelect(value, rowId) {
            // Criando o elemento select como string e depois adicionando ao DOM
            const selectId = `select-${rowId}`;
            const selectHtml = `<select class="form-control form-control-sm" id="${selectId}" name="tipo_obra" onchange="updateRdse(this, ${rowId})"></select>`;

            // Retorna o HTML do select (será adicionado ao DOM pela tabela)
            setTimeout(() => {
                const select = document.getElementById(selectId);

                if (value == null) {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Nenhum Selecionado';
                    option.setAttribute('selected', 'selected');
                    select.appendChild(option);
                }

                // Popula o select com as opções
                opcoesTipoObra.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;

                    if (value == item.id) {
                        option.setAttribute('selected', 'selected');
                    }
                    select.appendChild(option);
                });

                // Inicializa o Tom Select após adicionar as opções
                new TomSelect(select, {
                    placeholder: "Selecione uma opção",
                    allowEmptyOption: true
                });
            }, 100); // Timeout para garantir que o elemento está no DOM

            return selectHtml;
        }


        function isCivil(value, row) {
            return `
            <select name="is_civil" class="form-control form-control-sm" id="select-is_civil" onchange="updateRdse(this, ${row.id})">
                <option ${value == 0 ? 'selected' : ''} value="0">  Não </option>
                <option ${value == 1 ? 'selected' : ''} value="1">  Sim </option>
            </select>
            `
        }

        function observationInput(value, row) {
            let rowValue = value === null ? '' : value;
            let haveClass = row.observations != null ? 'text-success' : 'text-primary';
            return `
                <a name="observations" type="button" class="${haveClass}"
                    onclick="openObservationModal(${row.id}, 'observations')">
                    <i class="fas fa-edit"></i>
                </a>
            `;
        }

        function sigeoInput(value, row) {
            let isChecked = value === null ? '' : 'checked';
            let checkboxId = `sigeo-check-${row.id}`;

            return `
                <input type="checkbox" id="${checkboxId}" ${isChecked}
                    onchange="handleSigeoToggle(${row.id}, this.checked)"
                >
            `;
        }

        function handleSigeoToggle(id, isChecked) {

            axios.put(`${base_url}/api/v1/rdse/${id}/update-sigeo_at`, {
                    checked: isChecked
                })
                .then(response => {
                    console.log('Atualizado com sucesso:', response.data);
                })
                .catch(error => {
                    console.error('Erro ao atualizar Sigeo:', error);
                });
        }


        function aprInput(value, row) {
            let rowValue = value === null ? '' : value;
            let inputHtml = `
                <input type="text" class="form-control form-control-sm input-update date" name="apr_at"
                       onchange="updateRdse(this, ${row.id})"
                       value="${rowValue}"
                       maxlength="10"
                       data-mask="00/00/0000" placeholder="dd/mm/yyyy">
            `;

            // Retorna o HTML com o input
            return inputHtml;
        }

        function enelDeadline(value, row) {
            let rowValue = value === null ? '' : value;
            let inputHtml = `
                <input type="text" class="form-control form-control-sm input-update date" name="enel_deadline"
                       onchange="updateRdse(this, ${row.id})"
                       value="${rowValue}"
                       maxlength="10"
                       data-mask="00/00/0000" placeholder="dd/mm/yyyy">
            `;

            // Retorna o HTML com o input
            return inputHtml;
        }

        function sigeo(value, row) {
            return `
            <select name="sigeo" class="form-control form-control-sm" id="select-sigeo" onchange="updateRdse(this, ${row.id})">
                <option ${value == 0 ? 'selected' : ''} value="0">  Não </option>
                <option ${value == 1 ? 'selected' : ''} value="1">  Sim </option>
            </select>
            `
        }

        function preload() {
            var preload = ''
            preload += `<div class="text-center" id="preloader-content">`;
            preload += `    <div class="spinner-border text-primary m-1 align-self-center" role="status">`;
            preload += `        <span class="sr-only"></span>`;
            preload += `    </div>`;
            preload += `</div>`;
            return preload;
        }

        function updateStatusExecution(select, rdseId) {
            $('#modalUpdateStatus input[name="status"]').val($(select).val());
            $('#modalUpdateStatus input[name="rdse_id"]').val(rdseId);
            $('#modalUpdateStatus').modal('show');

            //axios.post(`${base_url}/api/v1/rdse/${rdseId}/update-status-execution`, {
            //        _method: 'PUT',
            //        status_execution: $(select).val(),
            //    }).then(function(error) {
            //        toastr.success('Alterado')
            //    })
            //    .catch(function(error) {
            //        toastr.error(error)
            //    });
        }

        $('#form-updateStatusRdse').submit(function(event) {
            event.preventDefault();
            let rdseId = $('#modalUpdateStatus input[name="rdse_id"]').val();

            axios.post(`${base_url}/api/v1/rdse/${rdseId}/update-status-execution`, {
                    _method: 'PUT',
                    status_execution: $('#modalUpdateStatus input[name="status"]').val(),
                    status_observation: $('#modalUpdateStatus #form-updateStatusRdse textarea[name="status_observation"]').val(),
                }).then(function(error) {
                    toastr.success('Alterado');
                    $('#modalUpdateStatus').modal('hide');
                })
                .catch(function(error) {
                    toastr.error(error);
                });
        });

        let timeUpdateColumns

        function updateRdse(select, rdseId) {
            let collumn = $(select).attr('name');
            let value = $(select).val();
            if (value == null || value == '') {
                return;
            }
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
            }, 400);

        }
    </script>

    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'center',
                autoUpdateInput: false,
                locale: {
                    format: 'Y-m-d',
                    cancelLabel: 'Clear'
                },
            }).on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                initTable();
            }).on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                initTable();
            });
        });
    </script>

    <script>
        $('.btn-save-lote').on('click', function() {
            axios.get(`${base_url}/rdse/rdse/lotesByStatus`, {
                    params: {
                        status: $('#rdse-select_status').val()
                    }
                })
                .then(function(response) {
                    let select = $('#select--lotes');
                    let selectId = select.attr('id');

                    $.each(response.data, function(index, value) {
                        var option = new Option(value.lote, value.lote, true, true);
                        select.append(option);
                    });

                    select.select2({
                        dropdownParent: $('#modal-update_lote  .modal-content'),
                        width: '100%',
                        placeholder: 'Selecione',
                        language: {
                            noResults: function() {
                                return `<a href = "javascript:void(0)" onclick = "add_lote('${selectId}')" style = "padding: 6px;height: 20px;display: inline-table;" > Sem resultados, Adicionar um novo ?</a>`;
                            },
                        },
                        escapeMarkup: function(markup) {
                            return markup;
                        },
                    })

                })
        });



        // Seleciona todos os selects com a classe `period-select`
        const periodSelects = document.querySelectorAll('.period-select');

        // Adiciona o evento de `change` a cada select
        periodSelects.forEach(select => {
            select.addEventListener('change', function() {
                // Recupera o valor do `data-target` para encontrar o container correspondente
                const targetId = this.getAttribute('data-target');
                const dateFields = document.querySelector(`[data-id="${targetId}"]`);

                // Verifica o valor selecionado
                if (this.value === 'specific') {
                    dateFields.classList.remove('d-none');
                } else {
                    dateFields.classList.add('d-none');
                }
            });
        });


        //$('#observationModal').on('show.bs.modal', function(event) {
        //    axios.get(`${base_url}/api/v1/rdse/${rdseId}`)
        //        .then(function(response) {
        //            console.log(response);
        //            $("#observationInput").val(response.observations)
        //        })
        //});
    </script>

@append
