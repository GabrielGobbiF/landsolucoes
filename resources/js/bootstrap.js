
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

} catch (e) { }

jQuery(function () {

    $('.select2').select2();

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

    $('.doc_applicable').on('change', function (e) {
        var id = $(this).val();
        if ($(this).is(":checked")) {
            if (confirm('Deseja alterar esse documento para aplicavel?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: BASE + '/rh/employees/update_auditory_applicable',
                    type: 'POST',
                    ajax: true,
                    dataType: "JSON",
                    data: {
                        auditory_id: id
                    },
                    dataType: 'json',
                    success: function (json) {
                        $('.radio_doc_applicable_' + id).css('display', 'none');
                        $('#yesorno_' + id).css('display', '');
                    },
                });
            } else {
                $(this).prop('checked', false);
            }
        }
    });

    if (window.location.hash == 'documentos-tab') {
        $('#myTab_employee #documentos-tab').tab('show')
    }

    $('.visibility_auditory_month').on('click', function () {
        var id = $(this).data('id');
        $('.acompanhamento-mensal').addClass('d-none');
        $.ajax({
            url: BASE + '/rh/auditorys/month/' + id,
            type: "GET",
            ajax: true,
            dataType: "JSON",
            success: function (j) {
                options = '';
                if (j.error != true) {
                    if (j.payments != null && j.payments.length > 0) {

                        for (var i = 0; i < j.payments.length; i++) {
                            var color = j.payments[i].status == 'Pendente' ? '#ff2f2f' : '#0746b9';
                            options += '<tr class="text-center tr_auditory" data-id="' + j.payments[i].id + '"  data-month="' + j.payments[i].month + '" data-name="' + j.name + '" data-type="Acompanhamento_mensal">'
                            options += '   <td>' + j.payments[i].month + '</td>'

                            if (j.payments[i].status == 'Pendente') {
                                options += '<td class="status auditory_update" style="cursor:pointer;color:' + color + '" data-status="' + j.payments[i].status + '">' + j.payments[i].status + '</td>'
                            } else {
                                options += '<td class="" style="color:' + color + '" data-status="' + j.payments[i].status + '">' + j.payments[i].status + '</td>'
                            }

                            if (j.payments[i].docs != false) {
                                options += '<td>' + j.payments[i].docs_envio + ' <a target="_blank" href="' + j.payments[i].docs + '"> Ver </a> </td>'
                            } else {
                                options += '<td></td>'
                            }

                            options += '</tr>'
                        }

                    }
                    $('#rows_table--mensal').html(options).show();

                    $('.status').on('click', function () {
                        updateAuditoryMonth(this);
                    })

                    $('.auditory_update').on('mouseover', function () {
                        if ($(this).data('status') != 'OK') {
                            $(this).html('Atualizar');
                        }
                    })

                    $('.auditory_update').on('mouseleave', function () {
                        $(this).html($(this).data('status'));
                    })

                    $('.table-mensal').removeClass('d-none');
                    $('.title_table--mensal').html(j.title);

                } else {
                    toastr.error(j.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.error('Error get data from ajax');
            }
        });
    });

    $('#cnh_check').on('change', function () {
        if ($(this).is(":checked")) {
            $('.div--cnh_number').removeClass('d-none')
        } else {
            $('#input--cnh_number').val('');
            $('.div--cnh_number').addClass('d-none')
        }
    })

    $('.status').on('click', function (e) {
        updateAuditoryMonth(this);
    });

    $('.back').on('click', function () {
        $('.acompanhamento-mensal').removeClass('d-none');
        $('.table-mensal').addClass('d-none');
    })
});

function updateAuditoryMonth(v) {
    var id = $(v).closest('tr').data('id');
    var pasta = $(v).closest('tr').data('type');
    var name = $(v).closest('tr').data('name');
    var employee_id = $('#employee_id').val();
    var data_month = $(v).closest('tr').data('month');

    $('.cursos--employees').css('display','none');

    if (pasta == 'Acompanhamento_mensal') {
        $('#update--Auditory').attr('action', BASE + '/rh/employees/' + employee_id + '/auditory/updateAuditoryMonth');
        $('#employees_auditory_month_id').val(id);
        $('#employees_auditory_month_id').val(id);
        $('#data_month').val(data_month);
    }
    if(pasta == 'cursos'){
        options = ''

        options += '<div class="row">'
        options += '    <div class="col-md-6">'
        options += '        <div class="form-group">'
        options += '            <label for="input--date_accomplished">Data Realizada</label>'
        options += '            <input type="text" name="date_accomplished"'
        options += '                class="form-control"'
        options += '                id="input--date_accomplished" value="">'
        options += '        </div>'
        options += '    </div>'
        options += '    <div class="col-md-6">'
        options += '        <div class="form-group">'
        options += '            <label for="input--validity">Vigência (em dias) </label>'
        options += '            <input type="text" name="validity"'
        options += '                class="form-control"'
        options += '                id="input--validity" value="">'
        options += '        </div>'
        options += '    </div>'
        options += '</div>'

        $('.cursos--employees').css('display','');
        $('.cursos--employees').html(options);
    }

    $('#auditory_id').val(id);
    $('#type_pasta').val(pasta);
    $('#document_name').val(name);

    $('#modal--save--document').modal({ show: true });

    $('.btn-cancel').on('click', function () {
        $('#option_nao_' + id).prop('checked', true);
    })
}

