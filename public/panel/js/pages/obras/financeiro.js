//obras/{obraId}/finance/{faturamentoId}/update
const obraId = document.getElementById('obraId').value;
const routeEtapa = `${base_url_api}obras/${obraId}/finance/`;
const modal = $('#modal-etapas--financeiro');

document.querySelectorAll('.btn-faturamento').forEach(item => {
    document.querySelector('#results-faturamento').innerHTML = '';
    item.addEventListener('click', (e) => {
        let etapaId = e.currentTarget.getAttribute('data-id');
        show(etapaId)
    });
})

function show(etapaId) {
    modal.find('#form-etapas-financeiro').attr('action', `${base_url}/l/obras/${obraId}/finance/${etapaId}/storeFaturamento`)
    axios({
        method: 'GET',
        url: `${routeEtapa}${etapaId}?history=1`,
    }).then(response => {
        var table = '';
        const data = response.data.data;
        const history = data.history ?? [];
        modal.find('.etapa-nome').html(data.nome_etapa)
        $.each(history, function (index, value) {
            let check = value.recebido == 'Y' ? 'checked' : '';
            table += `<tr>
                <td>
                <form id='form-destroy-faturamento' role='form' onsubmit="return confirm('Certeza que quer deletar?');" class='needs-validation' action='${routeEtapa}${etapaId}/${value.identifyFaturamento}/destroy' method='POST'>
                    <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}" />
                    <input type="hidden" name="_method" value="DELETE" />
                    <button class='btn btn-sm btn-primary js-btn-confirm'><i class="fas fa-trash"></i></button>
                </form>
                </td>
                <td>${data.name_max}</td>
                <td>${value.faturamento}</td>
                <td>${value.nfN}</td>
                <td>${value.emissao}</td>
                <td>${value.vencimento}</td>
                <td>R$ ${value.valor}</td>
                <td>
                    <div class="checkbox-wrapper-mail">
                        <input type="checkbox" ${check} onclick="recebido(this, '${etapaId}')" data-value="${value.recebido}" id="chk${value.identifyFaturamento}" data-id="${value.identifyFaturamento}">
                        <label for="chk${value.identifyFaturamento}" class="toggle" ></label>
                    </div>
                </td>
            </tr>`;
        });
        modal.find('.etapa-valor_receber').html(`R$ ${numberFormat(data.aReceber)}`)
        modal.find('.etapa-valor_receber').attr('data-value', data.aReceber)
        document.querySelector('#results-faturamento').innerHTML = table;
        modal.modal('show');

        modal.find('#input--valor').on('keyup', function () {
            let receber = modal.find('.etapa-valor_receber').attr('data-value');
            let val = clearNumber($(this).val());
            let count = receber - val;
            modal.find('.etapa-valor_receber').html(`R$ ${numberFormat(count)}`)
            if (val > receber) {
                modal.find('.btn-submit').prop('disabled', true);
                toastr.error('Valor não pode ser maior que o valor a receber');
            } else {
                modal.find('.btn-submit').prop('disabled', false);
            }
        })
        data.aReceber == '0'
            ? modal.find('.btn-submit').prop('disabled', true)
            : modal.find('.btn-submit').prop('disabled', false);
    })
}


function recebido(v, etapaId) {
    let check = $(v).attr('data-value');
    let faturamentoId = $(v).attr('data-id');

    axios({
        method: 'PUT',
        url: `${routeEtapa}${etapaId}/${faturamentoId}/updateStatus`,
        data: {
            check: check,
        }
    }).then(response => {
        if (check == 'N')
            toastr.success('Recebido');
    }).catch(error => {
        toastr.error('não foi possivel receber, tente de novo')
    })
}

function numberFormat(number) {
    return number.toLocaleString('pt-br', { minimumFractionDigits: 2 })
    //return new Intl.NumberFormat('pt-BR', {
    //    //style: 'currency',
    //    currency: 'BRL',
    //}).format(number);
}

function clearNumber(number) {
    number = number.toString().replace("R$", "").replace(".", "");
    number = number.replace(",", ".");
    return number != '' ? numeral(number).value() : 0;
}
