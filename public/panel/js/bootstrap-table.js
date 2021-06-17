jQuery(function () {

    'use strict'

    var $table = $('#table-api');
    var dataTable = $table.attr('data-table');
    var order = $table.attr('order');

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
                    pageSize: p.pageSize
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
});
