@extends('app')

@section('title', "RDSE'S")

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3">
                    <label>Status</label>
                    <select name="status" id="select--status" class="form-control select2 search-input">
                        @foreach (__trans('rdses.status_label') as $status => $text)
                            <option value='{{ $status }}'
                                {{ (!request()->filled('status') && $text == 'Em Medição' ? ' selected="selected"' : request()->filled('status') && request()->input('status') == $status) ? ' selected="selected"' : '' }}>
                                {{ $text }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Tipo</label>
                    <select name="type" id="select--type" class="form-control select2 search-input">
                        <option value="">Selecione</option>
                        @foreach (config('admin.rdse.type') as $type)
                            <option value='{{ $type['name'] }}'
                                {{ (!request()->filled('type') && $type['name'] == 'Em Medição' ? ' selected="selected"' : request()->filled('type') && request()->input('type') == $type['name']) ? ' selected="selected"' : '' }}>
                                {{ $type['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="form-inline" role="form">
                            <div class="btn-group mr-2">
                                <button type="button" data-toggle="modal" data-target="#modal-add-rdse" class="btn btn-dark waves-effect waves-light">
                                    <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                                </button>
                                <button id="button-pending" type="button" data-type="pending" class="btn btn-secondary btn-states d-none" disabled><i class="fas fa-file-export"></i> Enviar para
                                    Aprovação
                                </button>
                                <button id="button-approval" type="button" data-type="approval" class="btn btn-secondary btn-states d-none" disabled><i class="fas fa-file-export"></i> Aprovar</button>
                                <button id="button-type" type="button" data-type="approved" class="btn btn-secondary btn-states d-none" disabled><i class="fas fa-file-export"></i> Faturar</button>
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
                                <th data-field="equipe" data-sortable="true">Equipe</th>
                                <th data-field="solicitante" data-sortable="true">Solicitante</th>
                                <th data-field="at" data-sortable="true">Data</th>
                                <th data-field="type" data-sortable="true">Tipo</th>
                                <th data-field="status_label">Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal'>
    </button>
    <div class='modal' id='exampleModal' tabindex='-1' role='dialog'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Enviar medições para "Aprovação"</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='form-group'>
                        <label for='input--lote'>As medições serão enviadas para o ultimo lote:</label>
                        <select name='' class='form-control select2'>
                            <option value="1">Lote: 1</option>
                            <option value="2">Lote: 2</option>
                            <option value="3" selected>Lote: 3</option>
                        </select>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-primary btn-submit'>Enviar</button>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                </div>
            </div>
        </div>
    </div>

    @include('pages.painel._partials.modals.modal-add', ['redirect' => 'rdse.index', 'type' => 'rdse'])

@endsection

@section('scripts')
    <script>
        jQuery(function() {
            'use strict'

            initButtons();
            initTable();
        });

        function initButtons() {
            let selected = $('#select--status').val();
            $(`button[data-type="${selected}"]`).removeClass('d-none');
        }

        function initTable() {
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

            $.each($('.search-input'), function() {
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
                    cookieIdTable: dataTable,
                    queryParamsType: 'all',
                    striped: true,
                    pagination: paginate,
                    sidePagination: "server",
                    pageNumber: 1,
                    cookiesEnabled: "['bs.table.sortOrder', 'bs.table.sortName', 'bs.table.columns', 'bs.table.searchText', 'bs.table.filterControl']",
                    mobileResponsive: true,
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
                        return {
                            total: res.meta ? res.meta.total : null,
                            rows: res.data
                        };
                    },
                    onClickCell: function(field, value, row, $element) {
                        if (click == 'false' || field == 'state') {
                            return;
                        }
                        if (field != 'statusButton') {
                            window.location.href = `${BASE_URL}${URL}/${row.id}`
                        }
                    },
                    onLoadSuccess: function() {
                        $('#preloader-content').remove();
                        $('.table-responsive').removeClass('d-none');
                    },
                });

                $table.on('check.bs.table uncheck.bs.table ' +
                    'check-all.bs.table uncheck-all.bs.table',
                    function() {
                        $('.btn-states').attr('disabled', !$table.bootstrapTable('getSelections').length)

                        selections = getIdSelections()
                    })

                function getIdSelections() {
                    return $.map($table.bootstrapTable('getSelections'), function(row) {
                        return row.id
                    })
                }
            }

            $('.search-input .modify').on('change', function() {
                initTable();
            })

            $(function() {
                $('#button-pending').on('click', function(e) {
                    console.log($table.bootstrapTable('getSelections'));
                    alert($table.bootstrapTable('getSelections'))
                })
            })
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
    </script>
@append
