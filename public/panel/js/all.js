jQuery(function () {

    'use strict'


    initTable();
});

function initTable() {
    const BASE_URL_API = $('meta[name="js-base_url_api"]').attr('content');
    const BASE_URL = $('meta[name="js-base_url"]').attr('content');
    const URL = $('meta[name="url"]').attr('content');

    const $table = $('#table-api');
    var dataTable = $table.attr('data-table');
    var order = $table.attr('order');
    var filter = {};

    $('#preloader-content').remove();

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
        var clickToSelect = $table.attr('data-click-select') != undefined ? false : true;
        var click = $table.attr('data-click');

        $table.bootstrapTable('refreshOptions', {
            locale: 'pt-BR',
            method: 'get',
            url: `${BASE_URL_API}${dataTable}`,
            dataType: 'json',
            classes: 'table table-hover table-striped',
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
                if (click == 'false') {
                    return;
                }
                if (field != 'statusButton') {
                    window.location.href = `${BASE_URL}${URL}/${row.id}`
                }
            },
            onLoadSuccess: function () {
                $('#preloader-content').remove();
                $('.table-responsive').removeClass('d-none');
            },
        });
    }

    $('.search-input .modify').on('change', function () {
        initTable();
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


(function ($) {

    'use strict';

    let BASE_URL_API = $('meta[name="js-base_url_api"]').attr('content');

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
    $('.cnpj').mask('00.000.000/0000-00');

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

    $('.js-btn-confirm').on('click', function (e) {
        e.preventDefault();
        const btn = $(this);
        click++;

        btn.html('<i class="fa fa-exclamation-circle"></i>');
        btn.addClass("js-click-to-confirm");

        if (click == 2) {
            var form = btn.closest("form");
            console.log(form);
            form.submit();
        }

        clearTimeout(timeButtonConfirm);
        timeButtonConfirm = setTimeout(function () {
            btn.html('<i class="fa fa-trash"></i>');
            btn.removeClass("js-click-to-confirm");
            click = 0;
        }, 1900);
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

function axiosCath() {
    return '<div class="text-center"><a onclick="location.reload()" class="btn btn-sm btn-danger"><i class="fas fa-redo-alt"></i> ERROR - Recarregar</a> </div>';
}








/*
<div class=" col-md-12 card mg-b-20 mg-lg-b-25">
    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
        <h6 class="tx-uppercase tx-semibold mg-b-0">Endereço</h6>
    </div>
    <div class="card-body pd-20 pd-lg-25 form-row">
        <div class="form-group col-md-3">
            <label for="inputcep">Cep</label>
            <input type="text" class="form-control" id="input_cep" name="endereco[cep]" maxlength="9" onblur="pesquisacep(this.value);" value="">
        </div>
        <div class="form-group col-md-7">
            <label for="inputrua">Rua</label>
            <input type="text" class="form-control" id="input--street" name="endereco[rua]" value="">
        </div>
        <div class="form-group col-md-2">
            <label for="inputnumero">Nº </label>
            <input type="text" class="form-control" id="input_numero" name="endereco[numero]" value="">
        </div>
        <div class="form-group col-md-4">
            <label for="inputcomplemento">Complemento</label>
            <input type="text" class="form-control" id="input_complemento" name="endereco[complemento]" value="">
        </div>
        <div class="form-group col-md-3">
            <label for="inputbairro">Bairro</label>
            <input type="text" class="form-control" id="input--district" name="endereco[bairro]" value="">
        </div>
        <div class="form-group col-md-3">
            <label for="inputcidade">Cidade</label>
            <input type="text" class="form-control" id="input--city" name="endereco[cidade]" value="">
        </div>

        <div class="form-group col-md-2">
            <label for="inputestado">Estado</label>
            <input type="text" class="form-control" id="input--state" name="endereco[estado]" value="">
        </div>

    </div>
</div>
<script src="cep.js"></script>
*/

function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('input--street').value = ('');
    document.getElementById('input--district').value = ('');
    document.getElementById('input--city').value = ('');
    document.getElementById('input--state').value = ('');
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('input--street').value = (conteudo.logradouro);
        document.getElementById('input--district').value = (conteudo.bairro);
        document.getElementById('input--city').value = (conteudo.localidade);
        document.getElementById('input--state').value = (conteudo.uf);

    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('input--street').value = "consultando";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = '//viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};



