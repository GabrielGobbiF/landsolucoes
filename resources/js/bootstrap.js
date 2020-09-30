
try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) { }

jQuery(function () {
    $('.applicable').on('change', function (e) {
        var id = $(this).val();
        if ($(this).is(":checked")) {
            if (confirm('Deseja alterar esse documento para aplicavel?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'http://teste.landsolucoes.com.br/rh/employees/update_auditory_applicable',
                    type: 'POST',
                    ajax: true,
                    dataType: "JSON",
                    data: {
                        auditory_id: id
                    },
                    dataType: 'json',
                    success: function (json) {
                        $('.radio_applicable_' + id).css('display', 'none');
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
            url: 'http://teste.landsolucoes.com.br/rh/auditorys/month/' + id,
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
                    alert(j.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    });

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

    if (pasta == 'Acompanhamento_mensal') {
        $('#update--Auditory').attr('action', 'http://teste.landsolucoes.com.br/rh/employees/' + employee_id + '/auditory/updateAuditoryMonth');
        $('#employees_auditory_month_id').val(id);
        $('#employees_auditory_month_id').val(id);
        $('#data_month').val(data_month);
    }

    $('#auditory_id').val(id);
    $('#type_pasta').val(pasta);
    $('#document_name').val(name);

    $('#modal--save--document').modal({ show: true });

    $('.btn-cancel').on('click', function () {
        $('#option_nao_' + id).prop('checked', true);
    })
}

