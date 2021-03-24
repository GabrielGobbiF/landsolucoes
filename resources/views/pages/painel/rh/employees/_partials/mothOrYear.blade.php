<div class="table-mensal d-none">
    <table class="table text-center">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h3 class="title_table--mensal"> </h3>
            <div class="float-right d-flex">
                <button class="btn btn-xs btn-danger back">
                    <i class="fas fa-long-arrow-alt-left"></i>
                    Voltar
                </button>
                <div class="ml-2 d-none removeCourse" >
                    <form role='form' class='needs-validation form-remove-course-employee' action='{{route('auditorys.remove.course', [1,2])}}' method='POST'>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Retirar</button>
                    </form>
                </div>
            </div>
        </div>
        <thead>
            <tr>
                <th scope="col" class="month">Mês</th>
                <th class="month_accomplished d-none"> Mês Realizado </th>
                <th class="vigence d-none"> Vencimento </th>
                <th scope="col">Status</th>
                <th scope="col">Documento</th>
            </tr>
        </thead>
        <tbody class="rows_table--mensal"></tbody>
    </table>
</div>

<div class="table-epi d-none">
    <input type="hidden" id="epi_id">
    <table class="table text-center">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h3 class="title_table--mensal"> </h3>
            <div class="float-right">
                <button class="btn btn-xs btn-danger back">
                    <i class="fas fa-long-arrow-alt-left"></i>
                    Voltar
                </button>
                <button class="btn btn-xs btn-primary new_epi" onclick="newEpi()">
                    <i class="fas fa-plus"></i>
                    Novo
                </button>
            </div>
        </div>
        <thead class="epi--thead">
            <tr>
                <th scope="col">Descrição</th>
                <th scope="col">Mês</th>
                <th scope="col">Status</th>
                <th scope="col">Documento</th>
            </tr>
        </thead>
        <tbody class="rows_table--epi"></tbody>
    </table>
</div>

<script>
    function newEpi() {

        $('.new_epi').prop('disabled', true);
        $('.new_epi').html('Criando..');

        if ($('#epi_id').val() != '') {
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                url: BASE + '/rh/employees/auditory/newEpiEmployee',
                type: 'POST',
                ajax: true,
                dataType: "JSON",
                data: {
                    auditory_id: $('#epi_id').val()
                },
                dataType: 'json',
                success: function(j) {
                    options = '';

                    if (j.error != true) {
                        if (j.payments != null && j.payments.length > 0) {
                            for (var i = 0; i < j.payments.length; i++) {
                                var color = j.payments[i].status == 'Pendente' ? '#ff2f2f' : '#0746b9';
                                options += '<tr class="text-center tr_auditory" data-id="' + j.payments[i]
                                    .id +
                                    '"  data-month="' + j.payments[i].month + '" data-name="' + j.name +
                                    '" data-type="Acompanhamento_mensal">';
                                options += '   <td>' + j.payments[i].epi_description + '</td>';
                                options += '   <td>' + j.payments[i].date_accomplished + '</td>';
                                if (j.payments[i].status == 'Pendente') {
                                    options +=
                                        '<td class="auditory_update" onclick="updateAuditoryMonth(this, `epi`)" style="cursor:pointer;color:' +
                                        color + '" data-status="' + j.payments[i].status + '">' + j
                                        .payments[i]
                                        .status + '</td>';
                                } else {
                                    options += '<td class="" style="color:' + color + '" data-status="' + j
                                        .payments[i].status + '">' + j.payments[i].status + '</td>';
                                }
                                if (j.payments[i].docs != false) {
                                    options += '<td>' + j.payments[i].docs_envio +
                                        ' <a target="_blank" href="' + j.payments[i].docs +
                                        '"> Ver </a> </td>';
                                } else {
                                    options += '<td></td>';
                                }
                                options += '</tr>';
                            }

                        }

                        $('.rows_table--epi').html(options).show();

                        $('.auditory_update').on('mouseover', function() {
                            if ($(this).data('status') != 'OK') {
                                $(this).html('Atualizar');
                            }
                        });
                        $('.epi_doc').on('click', function() {
                            updateAuditoryMonth(this, 'epi');
                        });
                        $('.auditory_update').on('mouseleave', function() {
                            $(this).html($(this).data('status'));
                        });
                        $('.table-epi').removeClass('d-none');
                        $('.acompanhamentoOrCurso').addClass('d-none');
                        $('.title_table--mensal').html(j.title);

                        $('.new_epi').prop('disabled', false);
                        $('.new_epi').html('Novo');



                    } else {
                        toastr.error(j.message);
                        $('.new_epi').prop('disabled', false);
                        $('.new_epi').html('Novo');
                    }
                },
            });
        }

    }

    function updateAuditoryMonth(v, type) {

        var id = $(v).closest('tr').data('id');
        var pasta = $(v).closest('tr').data('type');
        var name = $(v).closest('tr').data('name');
        var employee_id = $('#employee_id').val();
        var data_month = $(v).closest('tr').data('month');

        $('.cursos--employees').addClass('d-none');
        $('.epi--employees').addClass('d-none');

        if (pasta == 'Acompanhamento_mensal' || pasta == 'cursos') {
            $('#update--Auditory').attr('action', BASE + '/rh/employees/' + employee_id +
                '/auditory/updateAuditoryMonth');
            $('#employees_auditory_month_id').val(id);
            $('#employees_auditory_month_id').val(id);
            $('#data_month').val(data_month);
        }
        if (pasta == 'cursos') {
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

            $('#required').val('true');
            $('.cursos--employees').removeClass('d-none');
            $('.cursos--employees').html(options);
        }

        if (type == 'epi') {
            options = ''

            options += '<div class="row">'
            options += '    <div class="col-md-6">'
            options += '        <div class="form-group">'
            options += '            <label for="input--epi_description">Descrição</label>'
            options += '            <input type="text" name="epi_description"'
            options += '                class="form-control"'
            options += '                id="input--epi_description" value="">'
            options += '        </div>'
            options += '    </div>'
            options += '    <div class="col-md-6">'
            options += '        <div class="form-group">'
            options += '            <label for="input--date_accomplished">Mês (10/2020)</label>'
            options += '            <input type="text" name="date_accomplished"'
            options += '                class="form-control date"'
            options += '                id="input--date_accomplished" value="10/2020">'
            options += '        </div>'
            options += '    </div>'
            options += '</div>'

            $('#required').val('true');
            $('.epi--employees').removeClass('d-none');
            $('.epi--employees').html(options);
        }

        $('#auditory_id').val(id);
        $('#type_pasta').val(pasta);
        $('#document_name').val(name);

        $('#modal--save--document').modal({
            show: true
        });

        $('.btn-cancel').on('click', function() {
            $('#option_nao_' + id).prop('checked', true);
        })
    }

</script>
