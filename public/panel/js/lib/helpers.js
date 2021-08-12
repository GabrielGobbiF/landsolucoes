
(function ($) {

    'use strict';

    console.log('init helpers');

    Dropzone.autoDiscover = false;

    //$('.js-btn-delete').on('click', function () {
    //    var $modal = $("#modal-confirm-delete")
    //    var href = $(this).attr('data-href');
    //    var text = $(this).attr('data-text');
    //    if (text != null) {
    //        $modal.find('.modal-title').html(`${text}`);
    //        $modal.find('.btn-danger').html(`<i class="fas fa-exclamation-circle"></i> ${text}`);
    //        $modal.find('.modal-text-body').html(`Tem certeza que deseja ${text}?`);
    //    }
    //    $modal.find('#form-delete').attr('action', href)
    //    $modal.modal('show');
    //});

    $('.js-btn-delete').on('click', function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        var html = `<div class="modal fade effect-scale" id="modal-confirm-delete" tabindex="-1" role="dialog" aria-hidden="true">`;
        html += `       <div class="modal-dialog modal-dialog-centered modal-sm" role="document">`;
        html += `           <div class="modal-content">`;
        html += `               <div class="modal-header">`;
        html += `                   <h6 class="modal-title"></h6>`;
        html += `                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">`;
        html += `                       <i class="fa fa-times"></i>`;
        html += `                   </button>`;
        html += `               </div>`;
        html += `               <div class="modal-body">`;
        html += `                   <p class="mg-b-0 modal-text-body"></p>`;
        html += `               </div>`;
        html += `               <div class="modal-footer">`;
        html += `                   <button type="button" id="modal-cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>`;
        html += `                      <form id="form-delete" role="form" class="needs-validation" action="" method="POST">`
        html += `                          <input type="hidden" name="_token" value="${token}"> `
        html += `                          <input type="hidden" name="_method" value="DELETE"> `
        html += `                          <button type="submit" id="modal-confirm"`
        html += `                              data-btn-text="Deletando" `
        html += `                              class="btn btn-danger `
        html += `                              btn-submit modal-btn-danger"> `
        html += `                              Deletar`
        html += `                          </button>`
        html += `                      </form>`
        html += `               </div>`;
        html += `           </div>`;
        html += `       </div>`;
        html += `</div>`;

        $('body').append(html);

        var $modal = $("#modal-confirm-delete")
        var href = $(this).attr('data-href');
        var text = $(this).attr('data-text');

        if (text != null) {
            $modal.find('.modal-title').html(`${text}`);
            $modal.find('.btn-danger').html(`<i class="fas fa-exclamation-circle"></i> ${text}`);
            $modal.find('.modal-text-body').html(`Tem certeza que deseja ${text}?`);
        }
        $modal.find('#form-delete').attr('action', href)
        $modal.modal('show');

        $modal.on('hidden.bs.modal', function () {
            $modal.remove();
        })
    });

    $('.select2').select2({
        width: '100%',
    });

    $('.select2Multiple').select2({
        width: '100%',
        closeOnSelect: false
    });

    $('.date').mask('00/00/0000');

    $('.money').mask('000.000.000.000.000,00', { reverse: true });

    $('.rg').mask('00000000-0');

    $('[data-toggle="tooltip"]').tooltip()

    $('.date_time').mask('00/00/0000 00:00');

    $('.game_type').mask('0v0');

    $('.phone').mask('(00)  0000-0000');

    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

    $('.sp_celphones').mask(SPMaskBehavior, spOptions);


    /**
    * ToastR
    */
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "800",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };





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

    if (window.location.hash == 'documentos-tab') {
        $('#myTab_employee #documentos-tab').tab('show')
    }

    $('.back').on('click', function () {
        $('.acompanhamentoOrCurso').removeClass('d-none');
        $('.table-mensal').addClass('d-none');
        $('.table-epi').addClass('d-none');
    })

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

})(jQuery)

function resetDiv() {
    $('.acompanhamentoOrCurso').removeClass('d-none');
    $('.table-mensal').addClass('d-none');
    $('.table-epi').addClass('d-none');
}

const txHeight = 50;
const tx = document.getElementsByTagName("textarea");
for (let i = 0; i < tx.length; i++) {
    if (tx[i].value == '') {
        tx[i].setAttribute("style", "height:" + txHeight + "px;overflow-y:hidden;");
    } else {
        tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
    }
}

var elements = document.getElementsByClassName("btn-submit");

var formSubmit = function () {
    var form = this.closest("form");
    var isValid = true;
    var text = this.getAttribute("data-btn-text");
    var textBack = this.innerHTML;
    text = text != null ? text : 'Salvando...';
    this.innerHTML = `<i class='fa fa-spinner fa-spin'></i> ${text}`;
    this.disabled = true;
    $.each(form.elements, function (index, value) {
        if (value.value === '' && value.hasAttribute('required')) {
            value.classList.add('is-invalid')
            isValid = false;
        }
        value.addEventListener('keyup', (e) => {
            if (e.value != '') {
                value.classList.remove('is-invalid')
            }
        });
    });

    if (isValid) {
        form.submit()
    } else {
        this.innerHTML = textBack;
        this.disabled = false;
    }
};

for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', formSubmit, false);
}






