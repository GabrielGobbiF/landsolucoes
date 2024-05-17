
(function ($) {
    'use strict';

    const vC = $('#input--valor_custo');
    const vP = $('#input--valor_proposta');
    const vN = $('#input--valor_negociado');
    const vD = $('#input--valor_desconto');

    init();

    function init() {
        if ($('#financeiro_id').val() == '') {
            updateValorCusto();
        }
    }

    function updateValorCusto() {
        var total = 0;

        $(".sub-total").each(function () {
            var subTotal = $(this).attr('data-value').replace(',', '.');
            if (!isNaN(subTotal)) {
                total = parseFloat(total) + parseFloat(subTotal);
            }
        });

        vC.val(numberFormat(total));
        vP.val(numberFormat(total));
    }

    function updateValorNegociado() {
        var total = 0;
        var valorProposta = clearNumber(vP.val());
        var valorDesconto = clearNumber(vD.val());

        total = (parseFloat(valorProposta) - parseFloat(valorDesconto));
        vN.val(numberFormat(total));
    }

    $('.js-qntEtapa').on('change keyup', function () {
        var $input = $(this);
        var idEtapa = $input.attr('data-id');
        var $price = $input.attr('data-price');
        var $tr = $(`#${idEtapa}`);
        var qnt = $input.val();
        if (qnt < 0) {
            $input.val('1');
        } else {
            var total = qnt * $price;
            $tr.find('.sub-total').html('R$ ' + total)
            $tr.find('.sub-total').attr('data-value', total)
            updateValorCusto();
            updateValorNegociado();
        }
    })

    $('#input--valor_proposta, #input--valor_desconto').on('keyup blur', function () {
        updateValorNegociado();
    })

    $('.js-metodoType').on('click', function () {
        resetValorNegociado();

        /**
         * Limpar CAMPOS
         */
        $('#input--valor_receber').val('')
        $('#input--valor_metodo_porcent').val('')

        if ($(this).val() == 'real') {
            $('.realPc').find('label').html('Valor R$');
            $('.realPc').find('input').attr('data-type', 'real');
        } else {
            $('.realPc').find('label').html('Porcentagem %');
            $('.realPc').find('input').attr('data-type', 'porcent');
        }

        $('.btn-add-etapa-financeiro').attr('disabled', true);

    })

    $('#input--valor_metodo_porcent').on('keyup change', function () {

        $('.btn-add-etapa-financeiro').attr('disabled', true);

        var valorNegociado = clearNumber($('#input--valor_negociado').val());
        var valorCalcular = clearNumber($(this).val());
        var type = $(this).attr('data-type');

        var typeResultado = type == 'real' ? (valorCalcular) : ((valorNegociado * valorCalcular) / 100)
        var totalFaturar = $('#totalFaturar').val();
        var result = (valorNegociado - typeResultado) - clearNumber(totalFaturar);

        var resultFormat = new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
        }).format(result);

        if (valorCalcular == '' || valorCalcular == '0') {
            $('#input--valor_receber').val('R$ 0,00')
            $('.js-spanValorNegociado').html(resultFormat);
            return;
        }

        if (parseFloat(typeResultado) > parseFloat(valorNegociado) || typeResultado < 0) {
            toastr.error('Valor a receber não pode ser maior que negociado');
            resetValorNegociado();
            $(this).val('');
            return;
        }

        $('#input--valor_receber').val(numberFormat(typeResultado))
        $('.js-spanValorNegociado').html(resultFormat);
        $('.btn-add-etapa-financeiro').attr('disabled', false);
    })

    function resetValorNegociado() {
        $('.btn-add-etapa-financeiro').attr('disabled', true);
        $('#input--valor_receber').val('R$ 0,00');
        var valorNegociado = numeral(clearNumber($('#input--valor_negociado').val()));
        var valorNegociado = valorNegociado.subtract(clearNumber($('#totalFaturar').val()));

        $('.js-spanValorNegociado').html(numberFormat(valorNegociado.value()));
    }

    function numberFormat(number) {
        return number.toLocaleString('pt-br', { minimumFractionDigits: 2 })
        //return new Intl.NumberFormat('pt-BR', {
        //    //style: 'currency',
        //    currency: 'BRL',
        //}).format(number);
    }

    function clearNumber(number) {
        number = number.toString().replace("R$", "").replace(".", "").replace(".", "").replace(".", "");
        number = number.replace(",", ".");
        return number != '' ? numeral(number).value() : 0;
    }

    function number_format(number, decimals, dec_point, thousands_point) {

        if (number == null || !isFinite(number)) {
            throw new TypeError("number is not valid");
        }

        if (!decimals) {
            var len = number.toString().split('.').length;
            decimals = len > 1 ? len : 0;
        }

        if (!dec_point) {
            dec_point = '.';
        }

        if (!thousands_point) {
            thousands_point = ',';
        }

        number = parseFloat(number).toFixed(decimals);

        number = number.replace(".", dec_point);

        var splitNum = number.split(dec_point);
        splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
        number = splitNum.join(dec_point);

        return number;
    }

})(jQuery)

