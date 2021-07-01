$(document).ready(function () {

    $.fn.editable.defaults.mode = 'inline';
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".select--users").select2({
        multiple: true,
        placeholder: "Buscar",
        minimumInputLength: 3,
        language: "pt-br",
        formatNoMatches: function () {
            return "Pesquisa não encontrada";
        },
        inputTooShort: function () {
            return "Digite para Pesquisar";
        },
        ajax: {
            url: `{{ route('users.all') }}`,
            dataType: 'json',
            data: function (term, page) {
                return {
                    q: term, //search term
                };
            },
            results: function (data, page) {
                return {
                    results: data.data,
                };
            }
        },
        escapeMarkup: function (m) {
            return m;
        }
    });

    numeral.register('locale', 'pt', {
        delimiters: {
            thousands: '.',
            decimal: ','
        },
        abbreviations: {
            thousand: 'k',
            million: 'm',
            billion: 'b',
            trillion: 't'
        },
        ordinal: function (number) {
            return number === 1 ? 'er' : 'ème';
        },
        currency: {
            symbol: 'R$'
        }
    });

    numeral.locale('pt');
})

$(document).on('click', 'body', function (e) {
    if ($(e.target).closest('.right-bar-etp-toggle, .right-bar-etp, .col-mail-1, .filemgr-sidebar').length > 0) {
        return;
    }

    $('body').removeClass('right-bar-etp-enabled');
    return;
});

function btn_delete(v) {
    var href = $(v).attr('data-href');
    var title = $(v).attr('data-title');
    var text = $(v).attr('data-original-title');
    if (text != null && title != null) {
        $('.modal-title').html(title);
        $('#modal-confirm').html(text);
        $('.modal-text-body').html('Tem certeza que deseja ' + text + '?');
    }
    $('#form-modal-action').attr('action', href)
    $('#modal-delete').modal('show');
}


