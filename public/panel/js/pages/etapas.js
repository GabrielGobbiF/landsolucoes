$(function () {
    'use strict'

    let time_etapas = null;

    $('#search-etapa').on('keyup', function () {
        clearTimeout(time_etapas);
        time_matchs = setTimeout(function () {
            initTableEtapas();
        }, 1200);
    });

    $('#modal-add-etapa').on('show.bs.modal', function (e) {
        var modal = $(this)
        var $btnStore = $(e.relatedTarget);
        var $tipo_id = $btnStore.attr('data-tipo-id');
        var $tipo_name = $btnStore.attr('data-tipo-name');
        modal.find('.modal-etapa-title').html('Adicionar Etapa "' + $tipo_name + '"');
        modal.find('#input--tipo_id').val($tipo_id);
    })

    $("#tt").submit(function (event) {
        event.preventDefault();
        var post_url = $('#form-add-etapa').attr("action");
        var request_method = $('#form-add-etapa').attr("method");
        var form_data = new FormData($('#form-add-etapa')[0]);
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: post_url,
            type: request_method,
            data: form_data,
            processData: false,
            cache: false,
            contentType: false,
            dataType: 'json',
        }).done(function (response) {
            $('#form-add-etapa')[0].reset();
            $("#modal-add-etapa").modal('hide');
            initTableEtapas();
        });
    });

});



