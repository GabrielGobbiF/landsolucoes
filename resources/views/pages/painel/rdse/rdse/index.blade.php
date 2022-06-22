@extends('app')

@section('title', "RDSE'S")

@section('content')

    <div class="card">

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-12 col-md-auto mb-2" style="min-width: 180px">
                    <label>Status</label>
                    <select name="status" id="rdse-select_status" class="form-control select2 search-input-rdse" multiple>
                        <option value="" class="">Todos</option>
                        @foreach (__trans('rdses.status_label') as $status => $text)
                            <option value='{{ $status }}'
                                {{ request()->filled('status') && in_array($text, request()->input('status')) ? 'selected="selected"' : null }}>
                                {{ $text }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-auto" style="min-width: 180px">
                    <label>Status de Execução</label>
                    <select name="status_execution" id="rdse-select_status_execution" class="form-control select2 search-input-rdse" multiple>
                        <option value="" class="">Todos</option>
                        @foreach (__trans('rdses.status_execution') as $status_execution)
                            <option value='{{ $status_execution }}'
                                {{ request()->filled('status_execution') && in_array($text, request()->input('status_execution')) ? 'selected="selected"' : null }}>
                                {{ $status_execution }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label>Tipo</label>
                    <select name="type" id="rdse-select--type" class="form-control select2 search-input-rdse">
                        <option value="">Selecione</option>
                        @foreach (config('admin.rdse.type') as $type)
                            <option value='{{ $type['name'] }}'
                                {{ (!request()->filled('type') && $type['name'] == 'Em Medição' ? ' selected="selected"' : request()->filled('type') && request()->input('type') == $type['name']) ? ' selected="selected"' : '' }}>
                                {{ $type['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3 d-none" id="div-search_lote">
                    <label>Lote</label>
                    <select name="lote" id="rdse-select--lote" class="form-control select2 search-input-rdse">
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

                <input type="hidden" id="totalTable">
                <input type="hidden" id="totalP1">
                <input type="hidden" id="totalP2">
                <input type="hidden" id="totalP3">
                <input type="hidden" id="totalUpsTable">
            </div>

            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="form-inline" role="form">
                            <div class="btn-group mr-2">
                                <button type="button" data-toggle="modal" data-target="#modal-add-rdse" class="btn btn-dark waves-effect waves-light">
                                    <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                                </button>
                            </div>
                        </div>
                    </div>
                    <table data-toggle="table" id="ttable" data-table="rdses" data-on-click="true">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="state" data-checkbox="true"></th>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="n_order" data-sortable="true">Nº Ordem</th>
                                <th data-field="description">Descrição</th>
                                <th data-field="equipe" data-sortable="true" data-visible="false">Equipe</th>
                                <th data-field="solicitante" data-sortable="true" data-visible="false">Solicitante</th>
                                <th data-field="at" data-sortable="true">Data</th>
                                <th data-field="type" data-sortable="true">Tipo</th>
                                <th data-field="valor_total" data-footer-formatter="valor_total_sum">Valor Total</th>

                                {{-- }}
                                <th data-field="total_p1" data-visible="false" data-footer-formatter="valor_totalp1">Valor P2</th>
                                <th data-field="total_p2" data-visible="false" data-footer-formatter="valor_totalp2">Valor P3</th>
                                <th data-field="total_p3" data-visible="false" data-footer-formatter="valor_totalp3">Valor P4</th>
                                <th data-field="parcial">Parcial</th>
                                {{ --}}

                                <th data-field="valor_ups" data-footer-formatter="valor_ups_sum">Valor Ups</th>
                                <th data-field="status_label">Status</th>
                                <th data-field="status_execution" data-formatter="statusExecution">Status de Execução</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="exampleModal" tabindex="-1" role="dialog">
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
                        <button type="button" class="btn btn-primary" id="btn-submit-rdse_change_status">Enviar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="pos-fixed b-10 r-10 z-index-200 d-none" id="rdses-downloading">
        <div class='card'>
            <form id='form-download-rdse' role='form' class='needs-validation' action='' method='POST'>
                <input type="hidden" id="rdse--input" name="rdse">
                <input id="rdse--id" name="rdseId" class="d-none">
                @csrf
                <div class='card-header bg-primary'>
                    <h6 class="tx-white mg-b-0 mg-r-auto">Selecionados</h6>
                </div>
                <div class='card-body pd-15' id="rdses-row"></div>
                <div class="card-footer">
                    <button type='button' class='btn btn-primary mr-3 d-none btn-save-lote' data-toggle='modal' data-target='#modal-update_lote'>
                        <i class="fas fa-save"></i> Alterar Lote
                    </button>
                    @include('pages.painel.rdse._partials.buttons', [request()->input('status')])
                </div>
            </form>
        </div>
    </div>

    <div class='modal' id='modal-update_lote' tabindex='-1' role='dialog'>
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
                            <input type="hidden" name="alterLote" id="input-lote-update">
                            <select class="form-control" name="lote" id="select--lotes"></select>
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

@endsection

@section('scripts')
    <script src="{{ asset('panel/js/pages/rdse/rdse.js') }}"></script>

    <script>
        jQuery(function() {
            'use strict'
            initButtons();
            initTable();
        });

        $('#rdse-select_status').on('change', function() {
            //let state = $(this).val();
            //localStorage.setItem('rdse-selecteds', JSON.stringify([]));
            //if (state != `{{ request()->input('status')[0] }}`) {
            //    //window.location.href = `${base_url}/rdse/rdse?status=${arrStr}`;
            //}
        })

        if (localStorage.getItem('rdse-select_status_execution')) {
            $('#rdse-select_status_execution').val(JSON.parse(localStorage.getItem('rdse-select_status_execution'))).trigger('change');
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
            let selected = $('#rdse-select_status').val();
            //if (selected != 'pending') {
            //    $('#div-search_lote').removeClass('d-none')
            //} else {
            //    $('#div-search_lote').addClass('d-none')
            //    $('#rdse-select--lote').val('').trigger('change');
            //}
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

                            valorTotal += parseFloat(value.valor)
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
                        if (click == 'false' || field == 'state' || field == 'status_execution') {
                            return;
                        }
                        if (field != 'statusButton') {
                            window.location.href = `${BASE_URL}${URL}/${row.id}`
                        }
                    },
                    onLoadSuccess: function() {
                        $('#preloader-content').remove();
                        $('.table-responsive').removeClass('d-none');
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
            <select name="" class="form-control" id="select-status_execution" onchange="updateStatusExecution(this, ${row.id})">
                <option value="Pré APR"> Pré APR</option>
                <option ${value == 'Programação' ? 'selected' : ''} value="Programação">  Programação </option>
                <option ${value == 'Impedimento' ? 'selected' : ''} value="Impedimento"> Impedimento</option>
                <option ${value == 'Execução 25%' ? 'selected' : ''} value="Execução 25%"> Execução 25%</option>
                <option ${value == 'Execução 50%' ? 'selected' : ''} value="Execução 50%"> Execução 50%</option>
                <option ${value == 'Execução 75%' ? 'selected' : ''} value="Execução 75%"> Execução 75%</option>
                <option ${value == 'Execução 100%' ? 'selected' : ''} value="Execução 100%">Execução 100%</option>
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
    </script>
@append
