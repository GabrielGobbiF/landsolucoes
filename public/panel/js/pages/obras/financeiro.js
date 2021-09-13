//obras/{obraId}/finance/{faturamentoId}/update
const obraId = document.getElementById('obraId').value;
const routeEtapa = `${base_url_api}obras/${obraId}/finance/`;
const modal = $('#modal-etapas--financeiro');

document.querySelectorAll('.btn-faturamento').forEach(item => {
    item.addEventListener('click', (e) => {
        let etapaId = e.currentTarget.getAttribute('data-id');
        show(etapaId)
    });
})

function show(etapaId) {
    modal.find('#form-etapas-financeiro').attr('action', `${base_url}/l/obras/${obraId}/finance/${etapaId}/update`)
    axios({
        method: 'GET',
        url: `${routeEtapa}${etapaId}?history=1`,
    }).then(response => {
        var table = '';
        const data = response.data.data;
        const history = data.history
        modal.find('.etapa-nome').html(data.nome_etapa)
        $.each(history, function (index, value) {
            table += `<tr>
                <td></td>
                <td>${data.nome_etapa}</td>
                <td>${value.coluna_faturamento}</td>
                <td>${value.nf_n}</td>
                <td>${value.data_emissao}</td>
                <td>${value.data_vencimento}</td>
                <td>${value.valor}</td>
                <td>${value.recebido_status}</td>
            </tr>`;
        });
        document.querySelector('#results-faturamento').innerHTML = table;
        modal.modal('show');
    })
}
