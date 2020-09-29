window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) { }

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.$ = window.jQuery = require('jquery/dist/jquery');

jQuery(function () {
    $('.status').on('change', function (e) {
        var id = $(this).closest('tr').data('id');
        var pasta = $(this).closest('tr').data('type');
        var name = $(this).closest('tr').data('name');

        $('#auditory_id').val(id);
        $('#type_pasta').val(pasta);
        $('#document_name').val(name);

        $('#modal--save--document').modal({ show: true });

        $('.btn-cancel').on('click', function () {
            $('#option_nao_' + id).prop('checked', true);
        })
    });

    $('.applicable').on('change', function (e) {
        var id = $(this).val();
        if ($(this).is(":checked")) {
            if (confirm('Deseja alterar esse documento para aplicavel?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'http://127.0.0.1:8000/rh/employees/update_auditory_applicable',
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
});

function employees() {

}
