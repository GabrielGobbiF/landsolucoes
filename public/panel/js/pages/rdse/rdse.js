'use strict';

const modalRdseChangeStatus = $('#changeStatus');
const bodyModal = modalRdseChangeStatus.find('.modal-body');

const listRdsesGroupInDom = (data, status) => {
    $('#form-rdse_change_status').attr('action', `${base_url}/rdse/rdse/status/${status}`)
    bodyModal.html('');
    let html = ``;
    let t = 0
    $.each(data, function (type, rdses) {
        t += 1;
        html += `
            <div class='card'>
                <div class='card-header'>
                    <h4 class='card-title'>Medições ${type}</h4>
                </div>
                <div class='card-body'>
                    <ul class="nav flex-column mb-4">
                        `
        $.each(rdses.itens, function (index, rdses) {

            if (status == 'invoice') {
                html += `
                <input type="hidden" name="rdses[${type}][itens][]" value="${rdses.id}"/>
                <h5 class="font-size-14"><i class="mdi mdi-location"></i> ${rdses.description}</h5>
                    <div class="d-flex flex-wrap">
                    <div class="input-group mb-3 w-auto">
                        <input type="text" class="form-control" name="rdses[${type}][nf][]" placeholder="Digite o Nº NF" required>
                    </div>
                    <div class="input-group mb-3 w-auto">
                        <input type="text" class="form-control date" name="rdses[${type}][date][]" placeholder="Digite a data dd/mm/yyyy" required>
                    </div>
                </div>
                `
            } else {
                html += `
                <input type="hidden" name="rdses[${type}][itens][]" value="${rdses.id}"/>
                    <li class="nav-item">${rdses.n_order}
                </li>`
            }

        });
        html += `
                    </ul>
        `
        if (status != 'pending') {
            html +=
                `
                    <label for='input--lote'>As medições serão enviadas para o ultimo lote:</label>
                    <select name='rdses[${type}][lote]' class='form-control select-rdse_lote' id="select_${t}">
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

    $('.date').mask('00/00/0000');

    $('.select-rdse_lote').each(function () {
        let selectId = $(this).attr('id');

        $(this).select2({
            dropdownParent: $('#changeStatus  .modal-content'),
            width: '100%',
            placeholder: 'Selecione',
            language: {
                noResults: function () {
                    return `<a href = "javascript:void(0)" onclick = "add_lote('${selectId}')" style = "padding: 6px;height: 20px;display: inline-table;" > Sem resultados, Adicionar um novo ?</a>`;
                },
            },
            escapeMarkup: function (markup) {
                return markup;
            },
        })
    })

    modalRdseChangeStatus.find('.modal-title').html(`Enviar medições para "${status}"`)
    modalRdseChangeStatus.modal('show');
}


function add_lote(selectId) {
    let select = $(`#${selectId}`)
    let name = select.data("select2").dropdown.$search.val();

    var option = new Option(name, name, true, true);
    select.append(option).trigger('change').trigger('close');
    select.select2('close');
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

    var form = $('#form-rdse_change_status')[0];
    var isValid = true;
    var text = $(this).attr("data-btn-text");
    var textBack = $(this).innerHTML;
    text = text != null ? text : 'Salvando...';
    $(this).innerHTML = `<i class='fa fa-spinner fa-spin'></i> ${text}`;
    $(this).disabled = true;
    $.each(form.elements, function (index, value) {
        if (value.value === '' && value.hasAttribute('required')) {
            value.classList.add('is-invalid')
            isValid = false;
        }
        value.addEventListener('keyup', (e) => {
            if (e.value != '') {
                value.classList.remove('is-invalid')
            }
        });
    });

    if (isValid) {
        form.submit()
    } else {
        $(this).innerHTML = textBack;
        $(this).disabled = false;
    }

    //$('#form-rdse_change_status').submit();
})

$('.btn-states').on('click', (e) => {
    let stateIn = e.target.getAttribute('data-type');
    if (stateIn != null || stateIn !=  undefined) {
        getGroupRdseByType(stateIn);
    }
})
