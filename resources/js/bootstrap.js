
try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.toastr = require('toastr');
    require('bootstrap');
    require('bootstrap-table');
    require('select2/dist/js/select2.min.js');
    require('tableexport.jquery.plugin/bower_components/tableExport.jquery.plugin/tableExport.min');
    require('bootstrap-table/dist/locale/bootstrap-table-pt-BR');
    require('bootstrap-table/dist/extensions/export/bootstrap-table-export.min');
    require('bootstrap-table/dist/extensions/cookie/bootstrap-table-cookie.min');
    require('jquery_mask/dist/jquery.mask.min.js');
    require('bootstrap4-duallistbox/dist/jquery.bootstrap-duallistbox.min.js');

} catch (e) { }

jQuery(function () {

    $('.select2').select2();

    $('.date').mask('00/00/0000');

    $('.money').mask('000.000.000.000.000,00', { reverse: true });

    $('.rg').mask('00000000-0');

    if (window.location.hash == 'documentos-tab') {
        $('#myTab_employee #documentos-tab').tab('show')
    }

    $('#cursos_employee').bootstrapDualListbox({

        // default text
        filterTextClear: 'mostrar todos',
        filterPlaceHolder: 'Filtar',
        moveSelectedLabel: 'Move selected',
        moveAllLabel: 'Mover todos',
        removeSelectedLabel: 'Remover selecionados',
        removeAllLabel: 'Remover todos',

        // true/false (forced true on androids, see the comment later)
        moveOnSelect: true,

        // 'all' / 'moved' / false
        preserveSelectionOnMove: false,

        // 'string', false
        selectedListLabel: false,

        // 'string', false
        nonSelectedListLabel: false,

        // 'string_of_postfix' / false
        helperSelectNamePostfix: '_helper',

        // minimal height in pixels
        selectorMinimalHeight: 300,

        // whether to show filter inputs
        showFilterInputs: true,

        // string, filter the non selected options
        nonSelectedFilter: '',

        // string, filter the selected options
        selectedFilter: '',

        // text when all options are visible / false for no info text
        infoText: 'Todos {0}',

        // when not all of the options are visible due to the filter
        infoTextFiltered: '<span class="badge badge-warning">Filtrar</span> {0} from {1}',

        // when there are no options present in the list
        infoTextEmpty: 'Lista vazia',

        // sort by input order
        sortByInputOrder: false,

        // filter by selector's values, boolean
        filterOnValues: false,

        // boolean, allows user to unbind default event behaviour and run their own instead
        eventMoveOverride: false,

        // boolean, allows user to unbind default event behaviour and run their own instead
        eventMoveAllOverride: false,

        // boolean, allows user to unbind default event behaviour and run their own instead
        eventRemoveOverride: false,

        // boolean, allows user to unbind default event behaviour and run their own instead
        eventRemoveAllOverride: false,

        // sets the button style class for all the buttons
        btnClass: 'btn-outline-secondary',

        // string, sets the text for the "Move" button
        btnMoveText: '&gt;',

        // string, sets the text for the "Remove" button
        btnRemoveText: '&lt;',

        // string, sets the text for the "Move All" button
        btnMoveAllText: '&gt;&gt;',

        // string, sets the text for the "Remove All" button
        btnRemoveAllText: '&lt;&lt;'

    });

    //localStorage.getItem('tab-pane') == null ? localStorage.setItem('tab-pane', 'thumblist') : '';

    localStorage.getItem('nav-tabs_employee') == null
        || localStorage.getItem('nav-tabs_employee') == undefined
        ? localStorage.setItem('nav-tabs_employee', 'dados-tab') : '';

    var tab_employee = localStorage.getItem('nav-tabs_employee')
    var tab_pane_employee = tab_employee.replace("-tab", "");

    $('.nav-link_employee').removeClass('active');
    $('#' + tab_employee).addClass('active');
    $('.tab-pane_employee').removeClass('show active');
    $('#' + tab_pane_employee).addClass('show active');

    $('.nav-link_employee').on('click', function () {
        var tab_employee = $(this).attr('id');
        localStorage.setItem('nav-tabs_employee', tab_employee)
        $('.nav-link_employee').removeClass('active');
        $('.tab-pane_employee').removeClass('show active');
        var tab_pane_employee = tab_employee.replace("-tab", "");
        $('#' + tab_pane_employee).addClass('show active');
        $('#' + tab_employee).addClass('active');
    });

    localStorage.getItem('nav-link_auditory') == null
        || localStorage.getItem('nav-link_auditory') == undefined
        ? localStorage.setItem('nav-link_auditory', 'v-pills-entrevista-tab') : '';

    var tab_auditory = localStorage.getItem('nav-link_auditory')
    var tab_pane_auditory = tab_auditory.replace("-tab", "");

    $('.nav-link_auditory').removeClass('active');
    $('#' + tab_auditory).addClass('active');
    $('.tab-pane_auditory').removeClass('show active');
    $('#' + tab_pane_auditory).addClass('show active');

    $('.nav-link_auditory').on('click', function () {
        var tab_auditory = $(this).attr('id');
        localStorage.setItem('nav-link_auditory', tab_auditory)
        $('.nav-link_auditory').removeClass('active');
        $('.tab-pane_auditory').removeClass('show active');
        var tab_pane_auditory = tab_auditory.replace("-tab", "");
        $('#' + tab_pane_auditory).addClass('show active');
        $('#' + tab_auditory).addClass('active');
        resetDiv();
    });

    $('.nav-header').on('click', function () {
        localStorage.setItem('nav-tabs_employee', 'dados-tab')
        localStorage.setItem('nav-link_auditory', 'v-pills-entrevista-tab')
    });

    $('[data-toggle="tooltip"]').tooltip()

    $('.btn-delete').on('click', function () {
        var href = $(this).data('href');
        $('#modal-delete').modal('show');
        $('#modal-confirm').on('click', function () {
            window.location.href = href;
        })
    });

    $('.btn-change').on('click', function () {
        var href = $(this).data('href');
        $('#modal-change').modal('show');
        $('#documento_id').val(href);
        $('#modal-confirm').on('click', function () {
            if ($('#reason').val() == '') {
                toastr.error('Motivo é obrigatorio')
            } else {
                if ($('#file_document_change').val() == '') {
                    toastr.error('Documento é obrigatorio')
                } else {
                    $('#form_change').submit();
                }
            }
        })
    });

    $('#cnh_check').on('change', function () {
        if ($(this).is(":checked")) {
            $('.div--cnh_number').removeClass('d-none')
            $('.div--cnh_validity').removeClass('d-none')
        } else {
            $('#input--cnh_number').val('');
            $('.div--cnh_number').addClass('d-none')
            $('.div--cnh_validity').addClass('d-none')
        }
    })

    $('.back').on('click', function () {
        $('.acompanhamentoOrCurso').removeClass('d-none');
        $('.table-mensal').addClass('d-none');
        $('.table-epi').addClass('d-none');
    })
});

function resetDiv() {
    $('.acompanhamentoOrCurso').removeClass('d-none');
    $('.table-mensal').addClass('d-none');
    $('.table-epi').addClass('d-none');
}

