@extends('app')

@section('title', "RDSE'S")

@section('content')

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
    </style>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4 no-print">
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

                <div class="col-12 col-md-3">
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

                <div id="div-search_lote" class="col-12 col-md-3">
                    <label>Lote</label>
                    <select id="rdse-select--lote" name="lote" class="form-control select2 search-input-rdse">
                        <option value="">Selecione</option>
                        @foreach ($lotes as $lote)
                            <option value='{{ $lote->lote }}'>{{ $lote->lote }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label>Data</label>
                    <input type="text" class="form-control search-input-rdse" name="daterange"
                           @if (request()->input('daterange') != null) value="{{ $date_to }} - {{ $date_from }}" @endif />
                </div>

                <div class="col-12 col-md-1">
                    <label>NFE</label>
                    <input type="text" class="form-control search-input-rdse" name="nfe" value="" />
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
                            <div class="btn-group mr-2">
                                <button type="button" data-toggle="modal" data-target="#modal-add-rdse" class="btn btn-dark waves-effect waves-light">
                                    <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                                </button>
                            </div>
                        </div>
                    </div>
                    <table id="ttable" data-toggle="table" data-table="rdses" data-on-click="true">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="state" data-checkbox="true"></th>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="n_order" data-sortable="true" data-width="150">Nº Ordem</th>
                                <th data-field="description">Descrição / Endereço</th>
                                <th data-field="type" data-sortable="true">Tipo</th>
                                <th data-field="status_execution" data-formatter="statusExecution">Status de Programação</th>
                                <th data-field="apr_at" data-formatter="aprInput">Data Pré APR</th>
                                <th data-field="is_civil" data-width="100" data-formatter="isCivil">Civil</th>
                                <th data-field="enel_deadline" data-formatter="enelDeadline">Data Limite ENEL</th>
                                <th data-field="observations" data-formatter="observationInput">Obs</th>


                                {{-- }}
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

    <div id="exampleModal" class="modal" tabindex="-1" role="dialog">
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

@endsection

@section('scripts')
    <script src="{{ asset('panel/js/pages/rdse/rdse.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        jQuery(function() {
            'use strict'
            initButtons();
            initTable();
        });

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

        function initTable() {
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
                        if (click == 'false' || field == 'state' || field == 'status_execution' || field == 'apr_at' || field == 'is_civil' ||
                            field == 'enel_deadline' || field == 'observations'

                        ) {
                            return;
                        }
                        if (field != 'statusButton') {
                            window.location.href = `${BASE_URL}${URL}/${row.id}`
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
            return `
                <a name="observations" type="button" class=""
                    onclick="openObservationModal(${row.id}, 'observations')">
                    <i class="fas fa-edit"></i>
                </a>
            `;
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
            axios.post(`${base_url}/api/v1/rdse/${rdseId}/update-status-execution`, {
                    _method: 'PUT',
                    status_execution: $(select).val(),
                }).then(function(error) {
                    toastr.success('Alterado')
                })
                .catch(function(error) {
                    toastr.error(error)
                });
        }

        let timeUpdateColumns

        function updateRdse(select, rdseId) {
            let collumn = $(select).attr('name');
            let value = $(select).val();
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

        //$('#observationModal').on('show.bs.modal', function(event) {
        //    axios.get(`${base_url}/api/v1/rdse/${rdseId}`)
        //        .then(function(response) {
        //            console.log(response);
        //            $("#observationInput").val(response.observations)
        //        })
        //});
    </script>
@append
