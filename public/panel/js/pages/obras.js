const obraId = document.getElementById('input--obra_id').value;
const BASE_URL_API = document.querySelector('meta[name=js-base_url_api]').getAttribute('content');
const BASE_URL_API_OBRA = `${BASE_URL_API}obra/${obraId}/`
const modal = $('#div--etp');
const divEtpList = $('#etapas-list');
const modalUpdateObra = $('#modal-update-obra');

let timeSearchEtapas = null;

$('.search-input').on('keyup', function () {
    clearTimeout(timeSearchEtapas);
    timeSearchEtapas = setTimeout(function () {
        getEtapas();
    }, 750);
});

$('#select--type').on('change', function () {
    getEtapas();
});

getEtapas();

var formUpdateEtapa = document.getElementById("form-update-etapa");

//document.querySelectorAll('.js-btn-etapa-show').forEach(item => {
//    item.addEventListener('click', () => {
//        let etpId = item.getAttribute('data-id');
//        document.getElementById('js-etapa-id').value = etpId;
//        showEtapa(etpId);
//    });
//})

document.querySelector('.close').addEventListener('click', () => {
    document.getElementById('offcanvasRight').classList.remove('show');
})

document.getElementById('form-update-etapa').addEventListener("submit", (e) => {
    e.preventDefault();

    var btnl = $('.js-btn-save');
    var btnh = btnl.html();
    var etpId = document.getElementById('js-etapa-id').value;
    var form_data = new FormData($("#form-update-etapa")[0]);

    $.ajax({
        url: `${BASE_URL_API_OBRA}etapa/${etpId}`,
        type: 'POST',
        data: form_data,
        processData: false,
        cache: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            btnl.html('Salvando..')
            btnl.prop('disabled', true)
        },
        success: function () {
            showEtapa(etpId);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            var errors = XMLHttpRequest.responseJSON.errors;

            if (errors) {
                $.each(errors, function (index, value) {
                    $(`#input--${index}`).addClass('is-invalid');
                    toastr.error(value);
                });
            } else {
                toastr.error(errorThrown);
            }
        },
        complete: function () {
            btnl.html(btnh);
            btnl.prop('disabled', false);
        },
    });
});

function getEtapas() {
    var filter = {};

    $.each($('.search-input'), function () {
        if ($(this).attr('name') != undefined) {
            filter[$(this).attr('name')] = $(this).val() ?? '';
        }
    });

    $.ajax({
        url: `${BASE_URL_API_OBRA}etapas`,
        type: "GET",
        ajax: true,
        dataType: "JSON",
        data: filter,
        beforeSend: () => {
            divEtpList.html(preload('preloader-content-list-etp'));
        },
        success: function (j) {
            var list = j.data;
            var html = '';

            if (list && list.length > 0) {
                $.each(list, function (index, value) {
                    var checked = value.check == 'C' ? 'checked' : '';
                    var comments = value.comments;

                    if (comments[0]) {
                        var textComment = comments[0].text_limit
                    }

                    html += ` <li>
                            <div class="col-mail col-mail-1">
                                <div class="checkbox-wrapper-mail">
                                    <input type="checkbox" class="js-btn-status" ${checked} onclick="updateStatus(this)"
                                        id="chk${value.id}"
                                        data-id="${value.id}">
                                    <label for="chk${value.id}" class="toggle"></label>
                                </div>
                                <a href="javascript:void(0)" onclick="showEtapa(${value.id})" class="title">${value.name}</a>
                            </div>
                            <div class="col-mail col-mail-2">
                                <span class="teaser">${textComment ?? ''}</span>
                                <span class="badge-${value.prazo.atraso ?? ''} badge mr-2">${value.prazo.msg ?? ''}</span>
                            </div>
                        </li>`;
                });
            } else {
                html = 'Sem Resultados';
            }

            divEtpList.html(html);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            toastr.error('Não foi possivel carregar as etapas, recarre a página');
        },
        complete: function () {
            $('#preloader-content-list-etp').remove();
        },
    });

}

function showEtapa(etpId) {
    const divEtp = document.getElementById('div--etp');

    document.getElementById('js-etapa-id').value = '';
    document.getElementById("form-update-etapa").reset();

    modal.find("input").each(function () {
        $(this).removeClass("is-invalid");
    });

    $.ajax({
        url: `${BASE_URL_API_OBRA}etapa/${etpId}`,
        type: "GET",
        ajax: true,
        dataType: "JSON",
        beforeSend: () => {
            divEtp.insertAdjacentHTML('beforebegin', preload());
            $('.type').addClass('d-none');
        },
        success: function (j) {
            let data = j.data;

            document.getElementById('js-etapa-id').value = data.id;

            divEtp.querySelector('.box-title').innerHTML = data.name;
            //divEtp.querySelector('.js-textarea-description').innerHTML = data.observacao;
            divEtp.querySelector('.js-input-etapa-n-nota').innerHTML = data.n_nota;

            $.each(data, function (index, value) {
                modal.find(`#input--${index}`).val(value)
            });

            $(`.${data.tipo}`).removeClass('d-none');

            getCommentsEtapa(etpId);

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            toastr.error(errorThrown);
            document.getElementById('offcanvasRight').classList.remove('show');
        },
        complete: function () {
            document.getElementById('offcanvasRight').classList.add('show');
            document.getElementById('preloader-content-etp').remove();
        },
    });
}

function getCommentsEtapa(etpId) {

    $.ajax({
        url: `${BASE_URL_API}etapa/${etpId}/comments`,
        type: "GET",
        ajax: true,
        dataType: "JSON",
        beforeSend: (jqXHR, settings) => {
            modal.find('.etapas-comments').html(preload('preload-comments'));
        },
        success: function (j) {
            var data = j.data;
            if (data.length > 0) {
                var options = '';
                $.each(data, function (index, value) {
                    options += '<div class="media mt-4">';
                    options += '<div class="avatar-sm font-weight-bold d-inline-block">'
                    options += '    <span class="avatar-title rounded-circle bg-soft-purple tx-14">'
                    options += value.user
                    options += '    </span>'
                    options += '</div>'
                    options += '    <div class="media-body overflow-hidden ml-2">';
                    options += '        <h5 class="tx-black text-truncate mb-1 tx-14 ">' + value.user_name + '</h5>';
                    options += `        <div class="direct-chat-text"><span style="word-break: break-all;">  ${value.text}  </span></div>`
                    options += '    </div>';
                    options += '    <div class="font-size-11">' + value.date + '</div>';
                    options += '</div>';
                });
                modal.find('.etapas-comments').html(options);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            toastr.error('erro ao carregar os comentários');
        },
        complete: function () {
            modal.find('#preload-comments').remove();
        },
    });
}

function newComment() {
    var input = $('#input-new-comment').val();
    var obra_id = $('#input--obra_id').val();
    var etp_id = $('#js-etapa-id').val();
    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        url: BASE_URL_API + 'obra/' + obra_id + '/etapa/' + etp_id + '/comment/store ',
        type: 'POST',
        ajax: true,
        dataType: "JSON",
        data: {
            obs_texto: input
        }
    }).done(function (response) {
        $('#input-new-comment').val('').focus();
        $('.js-btn-new-comment').attr('disabled', false);
        getCommentsEtp(etp_id)
    });
}

function getCommentsEtp(etpId) {

    $.ajax({
        url: `${BASE_URL_API}etapa/${etpId}/comments`,
        type: "GET",
        ajax: true,
        dataType: "JSON",
        beforeSend: (jqXHR, settings) => {
            modal.find('.etapas-comments').html(preload('preload-comments'));
        },
        success: function (j) {
            var data = j.data;
            if (data.length > 0) {
                var options = '';
                $.each(data, function (index, value) {
                    options += '<div class="media mt-4">';
                    options += '<div class="avatar-sm font-weight-bold d-inline-block">'
                    options += '    <span class="avatar-title rounded-circle bg-soft-purple tx-14">'
                    options += value.user
                    options += '    </span>'
                    options += '</div>'
                    options += '    <div class="media-body overflow-hidden ml-2">';
                    options += '        <h5 class="tx-black text-truncate mb-1 tx-14 ">' + value.user_name + '</h5>';
                    options += `        <div class="direct-chat-text"><span style="word-break: break-all;">  ${value.text}  </span></div>`
                    options += '    </div>';
                    options += '    <div class="font-size-11">' + value.date + '</div>';
                    options += '</div>';
                });
                modal.find('.etapas-comments').html(options);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            toastr.error('erro ao carregar os comentários');
        },
        complete: function () {
            modal.find('#preload-comments').remove();
        },
    });
}

$('#select--department_id').on('change', function () {
    var departmenId = $(this).val();
    if(departmenId != ''){
        getDepartmentById(departmenId);
    }
})

function getDepartmentById(departmenId) {
    $.ajax({
        url: `${BASE_URL_API}departments/${departmenId}`,
        type: "GET",
        ajax: true,
        dataType: "JSON",
        beforeSend: (jqXHR, settings) => {
            modalUpdateObra.find(`.departments`).val('')
        },
        success: function (j) {
            var data = j.data;
            $.each(data, function (index, value) {
                modalUpdateObra.find(`#input--${index}`).val(value)
            });
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            toastr.error('erro ao carregar o departmento');
        },
        complete: function () {
        },
    });

}

function preload(typ = 'preloader-content-etp') {
    var preload = ''
    preload += `<div class="text-center col-md-12 align-self-center preload" id="${typ}">`;
    preload += `    <div class="spinner-border text-primary m-1 align-self-center" role="status">`;
    preload += `        <span class="sr-only"></span>`;
    preload += `    </div>`;
    preload += `</div>`;
    return preload;
}

var textarea = document.querySelector('textarea');

document.querySelectorAll('textarea').forEach(item => {
    item.addEventListener('keydown', autosize);
    autosize
})

function autosize() {
    var el = this;
    setTimeout(function () {
        el.style.cssText = 'height:auto; padding:0';
        // for box-sizing other than "content-box" use:
        // el.style.cssText = '-moz-box-sizing:content-box';
        el.style.cssText = 'height:' + el.scrollHeight + 'px';
    }, 0);
}

function updateStatus(v) {
    var etpId = $(v).attr('data-id');
    var value = $(v).is(":checked") ? 'C' : 'EM';

    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        url: `${BASE_URL_API_OBRA}etapa/${etpId}/status`,
        type: "POST",
        ajax: true,
        dataType: "JSON",
        data: {
            check: value
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            toastr.error('Não foi possivel atualizar a etapa, tente de novo');
        },
    });

}



