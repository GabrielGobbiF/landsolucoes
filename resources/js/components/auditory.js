console.log('auditory');

jQuery(function () {

    /**
    * Modal para abrir a demissão do funcionario
    */
    $('.open_dispense_employee').on('click', function () {
        $('#modal-dispense--employee').modal('show');
        $('.modal-confirm').on('click', function () {
            var employee_id = $('#employee_id').val();
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                url: BASE + '/rh/employees/dispense/' + employee_id,
                type: 'PUT',
                ajax: true,
                dataType: "JSON",
                data: {
                    dispense: 1
                },
                dataType: 'json',
                success: function (json) {
                    localStorage.setItem('nav-link_auditory', 'v-pills-dispensa-tab')
                    location.reload();
                },
            });
        })
    })

    /**
    * Form de adicicionar o documento a uma auditoria
    */
    $('.btn-submit').on('click', function () {
        $('#input--date_accomplished').removeClass('is-invalid');
        $('#input--epi_description').removeClass('is-invalid');
        var form = $(this).closest('form');
        $(this).html('Salvando...');
        $(this).attr('disabled', true);

        if ($('#file_document').val() == '') {
            toastr.error('selecione um documento');
            $(this).html('Salvar');
            $(this).attr('disabled', false);
            return;
        }

        if ($('#required').val() == 'true') {
            if ($('#input--epi_description').val() == '' || $('#input--date_accomplished') == '') {
                if ($('#input--date_accomplished').val() == '') {
                    $('#input--date_accomplished').addClass('is-invalid');
                }
                if ($('#input--epi_description').val() == '') {
                    $('#input--epi_description').addClass('is-invalid');
                }
                toastr.error('por favor, complete os campos');
                $(this).html('Salvar');
                $(this).attr('disabled', false);
                return;
            }
        }
        form.submit();
    })

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

    $('.visibility_auditory_epi').on('click', function () {
        var id = $(this).data('id');
        $('#epi_id').val(id);
        $('.table-mensal').addClass('d-none');

        $.ajax({
            url: BASE + '/rh/auditorys/month/' + id,
            type: "GET",
            ajax: true,
            dataType: "JSON",
            success: function success(j) {

                options = '';

                if (j.error != true) {
                    if (j.payments != null && j.payments.length > 0) {
                        for (var i = 0; i < j.payments.length; i++) {
                            var color = j.payments[i].status == 'Pendente' ? '#ff2f2f' : '#0746b9';
                            options += '<tr class="text-center tr_auditory" data-id="' + j.payments[i].id + '"  data-month="' + j.payments[i].month + '" data-name="' + j.name + '" data-type="Acompanhamento_mensal">';
                            options += '   <td>' + j.payments[i].epi_description + '</td>';
                            options += '   <td>' + j.payments[i].date_accomplished + '</td>';
                            if (j.payments[i].status == 'Pendente') {
                                options += '<td class="epi_doc auditory_update" style="cursor:pointer;color:' + color + '" data-status="' + j.payments[i].status + '">' + j.payments[i].status + '</td>';
                            } else {
                                options += '<td class="" style="color:' + color + '" data-status="' + j.payments[i].status + '">' + j.payments[i].status + '</td>';
                            }
                            if (j.payments[i].docs != false) {
                                options += '<td>' + j.payments[i].docs_envio + ' <a target="_blank" href="' + j.payments[i].docs + '"> Ver </a> </td>';
                            } else {
                                options += '<td></td>';
                            }
                            options += '</tr>';
                        }
                    }

                    $('.rows_table--epi').html(options).show();
                    $('.epi_doc').on('click', function () {
                        updateAuditoryMonth(this, 'epi');
                    });
                    $('.auditory_update').on('mouseover', function () {
                        if ($(this).data('status') != 'OK') {
                            $(this).html('Atualizar');
                        }
                    });
                    $('.auditory_update').on('mouseleave', function () {
                        $(this).html($(this).data('status'));
                    });
                    $('.table-epi').removeClass('d-none');
                    $('.acompanhamentoOrCurso').addClass('d-none');
                    $('.title_table--mensal').html(j.title);
                } else {
                    toastr.error(j.message);
                }

            },
            error: function error(jqXHR, textStatus, errorThrown) {
                toastr.error('Error get data from ajax');
            }
        });


    });

    $('.visibility_auditory_month').on('click', function () {
        var id = $(this).data('id');

        $('.acompanhamentoOrCurso').addClass('d-none');
        $('.table-epi').addClass('d-none');

        $.ajax({
            url: BASE + '/rh/auditorys/month/' + id,
            type: "GET",
            ajax: true,
            dataType: "JSON",
            success: function success(j) {

                var type = j.type == 'cursos' ? 'cursos' : 'Acompanhamento_mensal';

                options = '';

                if (j.error != true) {
                    if (j.payments != null && j.payments.length > 0) {
                        for (var i = 0; i < j.payments.length; i++) {
                            var color = j.payments[i].status == 'Pendente' ? '#ff2f2f' : '#0746b9';

                            if (type == 'cursos') {
                                $('.month').addClass('d-none');
                                $('.month_accomplished').removeClass('d-none');
                                $('.vigence').removeClass('d-none');

                                var month = j.payments[i].date_accomplished
                            } else {
                                $('.month').removeClass('d-none');
                                $('.month_accomplished').addClass('d-none');
                                $('.vigence').addClass('d-none');

                                var month = j.payments[i].month
                            }

                            options += '<tr class="text-center tr_auditory" data-id="' + j.payments[i].id + '"  data-month="' + j.payments[i].month + '" data-name="' + j.name + '" data-type="' + type + '">';
                            options += '   <td>' + month + '</td>';

                            if (type == 'cursos') {
                                options += '   <td>' + j.payments[i].validade + '</td>';
                            }

                            if (j.payments[i].status == 'Pendente') {
                                options += '<td class="status auditory_update" style="cursor:pointer;color:' + color + '" data-status="' + j.payments[i].status + '">' + j.payments[i].status + '</td>';
                            } else {
                                options += '<td class="" style="color:' + color + '" data-status="' + j.payments[i].status + '">' + j.payments[i].status + '</td>';
                            }

                            if (j.payments[i].docs != false) {
                                options += '<td>' + j.payments[i].docs_envio + ' <a target="_blank" href="' + j.payments[i].docs + '"> Ver </a> </td>';
                            } else {
                                options += '<td></td>';
                            }

                            options += '</tr>';
                        }
                    }

                    $('.rows_table--mensal').html(options).show();
                    $('.status').on('click', function () {
                        updateAuditoryMonth(this, '');
                    });
                    $('.auditory_update').on('mouseover', function () {
                        if ($(this).data('status') != 'OK') {
                            $(this).html('Atualizar');
                        }
                    });
                    $('.auditory_update').on('mouseleave', function () {
                        $(this).html($(this).data('status'));
                    });
                    $('.table-mensal').removeClass('d-none');
                    $('.title_table--mensal').html(j.title);
                } else {
                    toastr.error(j.message);
                }
            },
            error: function error(jqXHR, textStatus, errorThrown) {
                toastr.error('Error get data from ajax');
            }
        });
    });

    $('.status').on('click', function (e) {
        updateAuditoryMonth(this, '');
    });
});


