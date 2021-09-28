jQuery(function () {

    'use strict'


    initTable();
});

function initTable() {
    const BASE_URL_API = $('meta[name="js-base_url_api"]').attr('content');
    const BASE_URL = $('meta[name="js-base_url"]').attr('content');
    const URL = $('meta[name="url"]').attr('content');

    var $table = $('#table-api');
    var dataTable = $table.attr('data-table');
    var order = $table.attr('order');
    var filter = {};

    $('.table-api').append(preload());

    $.each($('.search-input'), function () {
        if ($(this).attr('name') != undefined) {
            filter[$(this).attr('name')] = $(this).val() ?? '';
        }
    });

    if ($table.length > 0) {
        var paginate = $table.attr('data-paginate') != undefined ? false : true;
        var eExport = $table.attr('data-export') != undefined ? false : true;
        var showColumns = $table.attr('data-collums') != undefined ? false : true;
        var click = $table.attr('data-click');

        $table.bootstrapTable('refreshOptions', {
            locale: 'pt-BR',
            method: 'get',
            url: `${BASE_URL_API}${dataTable}`,
            dataType: 'json',
            classes: 'table table-hover table-striped',
            pageList: "[10, 25, 50, 100]",
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
            queryParams: function (p) {
                return {
                    sort: p.sortName ?? order,
                    order: p.sortOrder,
                    search: p.searchText,
                    page: p.pageNumber,
                    pageSize: paginate ? p.pageSize : 'all',
                    filter: filter ?? {}
                };
            },
            responseHandler: function (res) {
                return {
                    total: res.meta ? res.meta.total : null,
                    rows: res.data
                };
            },
            onClickCell: function (field, value, row, $element) {
                if(click == 'false'){
                    return;
                }
                if (field != 'statusButton') {
                    window.location.href = `${BASE_URL}${URL}/${row.id}`
                }
            },
            onLoadSuccess: function () {
                $('#preloader-content').remove();
                $('.table').removeClass('d-none');
            },
        });
    }
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
