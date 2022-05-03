(function () {

    "use strict";

    const selectAxOption = (request) => {
        return {
            minimumInputLength: 3,
            language: "pt-br",
            placeholder: "Selecione",
            ajax: {
                url: `${request}`,
                dataType: 'json',
                delay: 250,
                data: function (term, page) {
                    return {
                        filters: {
                            name: term.term
                        }
                    };
                },
                processResults: function (data, page) {
                    var myResults = [];
                    $.each(data.data, function (index, item) {
                        myResults.push({
                            'id': item.id,
                            'text': item.name,
                        });
                    });
                    return {
                        results: myResults
                    };
                },
                cache: true
            }
        }
    }

    $('.select2').each(function () {
        let multiple = $(this).attr('multiple') ? true : false;
        let close = multiple ? false : true;
        let inParent = $(this).attr('parent') ? $(this).attr('parent') : false
        let inRequest = $(this).attr('request') ? $(this).attr('request') : false

        let options = {
            width: '100%',
            closeOnSelect: close,
            language: {
                inputTooShort: function () {
                    return "Pelo menos 3 caracteres para pesquisar";
                },
                formatNoMatches: function () {
                    return "Pesquisa não encontrada";
                }
            },
            escapeMarkup: function (m) {
                return m;
            }
        }

        if (inRequest != false) {
            options = Object.assign(options, selectAxOption(inRequest))
        }

        if (inParent != false) {
            options = Object.assign(options, {
                dropdownParent: $(`${inParent} `),
            })
        }

        $(this).select2(options)
    })

    $('select').on('select2:open', (event) => {
        if (!event.target.multiple) {
            document.querySelector('.select2-search__field').focus();
        }
    });

    $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
        $(this).closest(".select2-container").siblings('select:enabled').select2('open');
    });

})();
