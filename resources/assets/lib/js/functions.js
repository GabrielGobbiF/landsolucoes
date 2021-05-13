
(function ($) {

    console.log('init global functions');

    $('.btn-delete').on('click', function () {
        var href = $(this).attr('data-href');
        var text = $(this).attr('data-title')
        if (text != null) {
            $('.modal-title').html(text);
            $('.btn-danger').html(text);
            $('.modal-text-body').html('Tem certeza que deseja ' + text + '?');
        }
        $('#form-delete').attr('action', href)
        $('#modal-delete').modal('show');
    });

    $('.btn-submit').on('click', function () {
        var text = $(this).attr('data-btn-text');
        text = text != null ? text : 'Salvando...';
        $(this).html("<i class='fa fa-spinner fa-spin'></i> " + text)
        $(this).prop('disabled', true);
        $(this).closest("form").submit();
    });

    $('.select2').select2({
        width: '100%'
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

})(jQuery)

