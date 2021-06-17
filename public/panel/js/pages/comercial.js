$(function () {
    'use strict'

    const comercial_id = $('#comercial_id').val();

    var tab = localStorage.getItem('nav-tabs_comercial')
    $('#v-tab a#' + tab).tab('show')

    $('#btn-listaCompra').on('click', function () {

        $('#v-tab a#v-financeiro-tab').tab('show')
        $('.mt-pag').hasClass('d-none') ?
            $('.mt-pag').removeClass('d-none') + $(this).html('Lista de Compra') :
            $('.mt-pag').addClass('d-none') + $(this).html('Método Pagamento');
    })

    getHistorico();

    $('.btn-add-etapa-financeiro').on('click', function (e) {

        var metodo_pagamento = $('#metodo_real').is(':checked') ? 'R$' : '%';
        var valor = $('#input--valor_metodo_porcent').val();
        var valor_receber = $('#input--valor_receber').val();
        var etapa_id = $('#select--etapa').val() ?? '';

        if (etapa_id == '') {
            e.preventDefault();
            $('.select-etapa').addClass('is-invalid-label');
            toastr.error('Selecione um Etapa');
            return;
        }

        if (valor == '') {
            e.preventDefault();
            $('#input--valor_metodo_porcent').addClass('is-invalid');
            toastr.error('Digite um valor');
            return;
        }

        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: BASE_URL_API + "comercial/" + comercial_id + "/etapasFinanceiro/store",
            type: 'POST',
            ajax: true,
            dataType: "JSON",
            data: {
                metodo_pagamento: metodo_pagamento,
                valor: valor,
                valor_receber: valor_receber,
                etapa_id: etapa_id,
            }
        }).done(function () {
            var valorAntigo = $('.spanValorNegociado').attr('data-valor-antigo');
            $("#select--etapa option[value='" + etapa_id + "']").remove();
            $('#input--valor_metodo_porcent').val('')
            $('#input--valor_receber').val('');
            $('.spanValorNegociado').attr('data-valor', valorAntigo);
            if(valorAntigo == '0'){
                $('.btn-add-etapa-financeiro').attr('disabled', true);
            }
            getHistorico();
        });
    })

    function getHistorico() {
        $.ajax({
            url: BASE_URL_API + "comercial/" + comercial_id + "/etapasFinanceiro",
            type: 'GET',
            ajax: true,
            dataType: "JSON",
            success: function (j) {
                var options = '';
                $.each(j, function (index, value) {
                    options += '<tr>';
                    options += '    <td>' + value.nome_etapa + '</td>';
                    options += '    <td>' + value.metodo_pagamento + '</td>';
                    options += '    <td>' + number_format(value.valor_receber) + '</td>';
                    options += '    <td>';
                    options += '        <a href="javascript:void(0)" data-href="' + BASE_URL + '/l/comercial/etapasFinanceiro/' + value.id + '/destroy"';
                    options += '            class="btn btn-xs btn-danger btn-delete" onclick="btn_delete(this)">';
                    options += '            <i class="fa fa-times"></i>';
                    options += '        </a>';
                    options += '    </td>';
                    options += '</tr>';
                });
                $('#row-table-historico').html(options);
            },
        });
    }

});

