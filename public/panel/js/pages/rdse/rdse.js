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

                    <label for='input--lote'>As medições serão enviadas para o ultimo lote:</label>
                    <select name='rdses[${type}][lote]' class='form-control select2'>
                    `
        $.each(rdses.lotes, function (index, value) {
            html += `<option selected value="${value}">Lote: ${value}</option>`
        });
        html += `
                    </select>
                </div>
            </div>`;
    });

    bodyModal.html(html);
    modalRdseChangeStatus.modal('show');
}

const getGroupRdseByType = async (status) => {
    const response = await axios.get(`${base_url}/api/v1/rdses/bygroup`, {
        params: { rdses: JSON.parse(localStorage.getItem('rdse-selecteds')) }
    });
    const data = await response.data;
    listRdsesGroupInDom(data, status)
}

$('#btn-submit-rdse_change_status').on('click', (e) => {
    e.preventDefault()
    localStorage.setItem('rdse-selecteds', JSON.stringify([]));
    $('#form-rdse_change_status').submit();
})

$('.button-pending').on('click', () => {
    getGroupRdseByType('approval');
})