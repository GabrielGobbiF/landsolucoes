'use strict';

const modalRdseChangeStatus = $('#exampleModal');
const bodyModal = modalRdseChangeStatus.find('.modal-body');

const listRdsesGroupInDom = (data, status) => {
    $('#form-rdse_change_status').attr('action', `${base_url}/rdse/rdse/status/${status}`)
    bodyModal.html('');
    let html = ``;
    $.each(data, function (type, rdses) {
        html += `
            <div class='card'>
                <div class='card-header'>
                    <h4 class='card-title'>Medições ${type}</h4>
                </div>
                <div class='card-body'>
                    <ul class="nav flex-column mb-4">
                        `
        $.each(rdses.itens, function (index, rdses) {

            html += `<input type="hidden" name="rdses[${type}][itens][]" value="${rdses.id}"/>
            <li class="nav-item">${rdses.description}
            </li>
            `
        });
        html += `
                    </ul>
        `
        if (status != 'pending') {
            html +=
                `
                    <label for='input--lote'>As medições serão enviadas para o ultimo lote:</label>
                    <select name='rdses[${type}][lote]' class='form-control select2'>
                    `

            $.each(rdses.lotes, function (index, value) {
                html += `<option selected value="${value}">Lote: ${value}</option>`
            });
        }
        html += `
                    </select>
                </div>
            </div>`;
    });

    bodyModal.html(html);
    modalRdseChangeStatus.find('.modal-title').html(`Enviar medições para "${status}"`)
    modalRdseChangeStatus.modal('show');
}

const getGroupRdseByType = async (status) => {
    const response = await axios.get(`${base_url}/api/v1/rdses/bygroup`, {
        params: {
            rdses: JSON.parse(localStorage.getItem('rdse-selecteds')),
            status: status
        }
    });
    const data = await response.data;
    listRdsesGroupInDom(data, status)
}

$('#btn-submit-rdse_change_status').on('click', (e) => {
    e.preventDefault()
    localStorage.setItem('rdse-selecteds', JSON.stringify([]));
    $('#form-rdse_change_status').submit();
})

$('.btn-states').on('click', (e) => {
    let stateIn = e.target.getAttribute('data-type');
    getGroupRdseByType(stateIn);
})