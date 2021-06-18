jQuery(function () {

    'use strict'

    initTable();
});

function initTable() {
    var $table = $('#table-api');
    var dataTable = $table.attr('data-table');
    var order = $table.attr('order');
    //var filter = $('.search-input').get().map(function (el) {
    //    return el.value;
    //});
    //var filter = localStorage.getItem($table.attr('data-table') + '_table_filter');
    var filter ={};
    $.each($('.search-input'), function () {
        if($(this).attr('name') != undefined){
            filter[$(this).attr('name')] = $(this).val() ?? '';
        }
    });

    console.log(filter);

    if ($table.length > 0) {

        $table.bootstrapTable('refreshOptions', {
            method: 'get',
            url: BASE_URL_API + dataTable,
            dataType: 'json',
            classes: 'table table-hover table-striped',
            pageList: "[10, 25, 50, 100]",
            cookie: true,
            cache: true,
            search: true,
            showExport: true,
            showColumns: true,
            idField: 'id',
            toolbar: '#toolbar',
            buttonsClass: 'dark',
            showColumnsToggleAll: true,
            pageSize: 20,
            cookieIdTable: dataTable,
            queryParamsType: 'all',
            striped: true,
            pagination: true,
            sidePagination: "server",
            pageNumber: 1,
            queryParams: function (p) {
                return {
                    sort: p.sortName ?? order,
                    order: p.sortOrder,
                    search: p.searchText,
                    page: p.pageNumber,
                    pageSize: p.pageSize,
                    filter: filter ?? {}
                };
            },
            responseHandler: function (res) {
                return {
                    total: res.meta.total,
                    rows: res.data
                };
            },
            onClickCell: function (field, value, row, $element) {
                var url = $('#url').val() + '/' + row.id
                if (field != 'statusButton') {
                    window.location.href = BASE_URL + url
                }
            },
        });


    }
}

