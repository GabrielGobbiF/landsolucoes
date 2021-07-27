$(function () {
    'use strict'

    let time_etapas = null;

    $('#search-etapa').on('keyup', function () {
        clearTimeout(time_etapas);
        time_matchs = setTimeout(function () {
            initTableEtapas();
        }, 1200);
    });

    //$('#modal-add-etapa').on('show.bs.modal', function (e) {
    //    var modal = $(this)
    //    var $btnStore = $(e.relatedTarget);
    //    var $tipo_id = $btnStore.attr('data-tipo-id');
    //    var $tipo_name = $btnStore.attr('data-tipo-name');
    //    modal.find('.modal-etapa-title').html('Adicionar Etapa "' + $tipo_name + '"');
    //    modal.find('#input--tipo_id').val($tipo_id);
    //})

});



