
document.addEventListener('DOMContentLoaded', function () {
    $('#select--type').on('change', function () {
        modoExit();
        getEtapas();
    });
    getEtapas();
});

const obraId = document.getElementById('input--obra_id').value;
const BASE_URL = document.querySelector('meta[name=js-base_url]').getAttribute('content');
const BASE_URL_API = document.querySelector('meta[name=js-base_url_api]').getAttribute('content');
const BASE_URL_API_OBRA = `${BASE_URL_API}obra/${obraId}/`
const modal = $('#div--etp');
const divEtpList = $('#etapas-list');
const modalUpdateObra = $('#modal-update-obra');

let timeSearchEtapas = null;
let timeUpdateObra = null;

$('.search-input').on('keyup', function () {
    clearTimeout(timeSearchEtapas);
    timeSearchEtapas = setTimeout(function () {
        getEtapas();
    }, 750);
});

$('#select--type').on('change', function () {
    modoExit();
    getEtapas();
});


var formUpdateEtapa = document.getElementById("form-update-etapa");

//document.querySelectorAll('.js-btn-etapa-show').forEach(item => {
//    item.addEventListener('click', () => {
//        let etpId = item.getAttribute('data-id');
//        document.getElementById('js-etapa-id').value = etpId;
//        showEtapa(etpId);
//    });
//})

document.querySelector('.close-right-bar').addEventListener('click', () => {
    document.getElementById('offcanvasRight').classList.remove('show');
    document.getElementById('rightbar-etp-overlay').classList.remove('show');
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
            getEtapas();
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
        if ($(this).attr('name') !== undefined) {
            if ($(this).is(':checkbox')) {
                // Adiciona ao filtro somente se o checkbox estiver marcado
                if ($(this).is(':checked')) {
                    filter[$(this).attr('name')] = $(this).val();
                }
            } else {
                // Para outros inputs, adiciona o valor normalmente
                filter[$(this).attr('name')] = $(this).val() ?? '';
            }
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
                    let date_abertura = value.data_abertura != null ? '<i data-toggle="tooltip" title="" data-original-title="informações" style="color:#002bff" class="fa fa-fw fa-info"></i>' : ''
                    let meta = value.meta_etapa != '' ? `Meta: ${value.meta_etapa}` : ''


                    html += `
                        <li data-id="${value.id}" data-tipo-id="${value.tipo_id}">
                            <div class="col-mail col-mail-1">
                                <div class="checkbox-wrapper-mail">
                                    <input
                                        type="checkbox"
                                        class="js-btn-status"
                                        ${checked}
                                        onclick="updateStatus(this)"
                                        id="chk${value.id}"
                                        data-id="${value.id}">
                                    <label for="chk${value.id}" class="toggle"></label>
                                </div>

                                <div class="checkbox-wrapper-mail d-none">
                                    <input
                                        type="checkbox"
                                        class="js-btn-mode-input danger"
                                        id="chk_danger${value.id}"
                                        value="${value.id}">
                                    <label for="chk_danger${value.id}" class="toggle"></label>
                                </div>

                                <a href="javascript:void(0)" onclick="showEtapa(${value.id})" class="title">
                                    ${value.name}
                                    ${value.finance != null ? value.finance.state + ' ' + value.finance.total_a_faturar : ''}
                                    ${date_abertura}
                                    ${value.haveDocuments ? '<i class="fas fa-file-alt text-danger"></i>' : ''}
                                </a>
                            </div>

                            <div class="col-mail col-mail-2">
                                <span class="teaser badge-success badge">${meta}</span>
                                <span class="badge-${value.prazo.atraso ?? ''} badge mr-2">${value.prazo.msg ?? ''}</span>
                                <span>${comments ?? ''}</span>
                            </div>
                        </li>
                        `;
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

    $('#pills-tab a[href="#pills-home"]').tab('show');

    document.querySelector('.table-activitiesTableBody').classList.add('d-none');

    const divEtp = document.getElementById('div--etp');

    divEtp.insertAdjacentHTML('beforebegin', preload());
    $('.type').addClass('d-none');

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
            initFetchEtapaDocumentos(etpId);

            document.getElementById('button-add-new-file').setAttribute('data-parentId', etpId);

            document.getElementById('offcanvasRight').classList.add('show');
            document.getElementById('rightbar-etp-overlay').classList.add('show');
            document.getElementById('preloader-content-etp').remove();
            $('#preloader-content-etp').remove();

            const parentModel = 'App\\Models\\ObraEtapa';
            const parentId = etpId;

            document.getElementById('button-add-new-file').setAttribute('data-parentModel', parentModel);
            document.getElementById('button-add-new-file').setAttribute('data-parentId', parentId);

            // Inicializa ou reutiliza a instância do Resumable
            initResumable(parentModel, parentId);

            initFetchModeloEtapaDocumentos(data.id_etapa);

            const activities = data.activities;
            const activitiesTableBody = document.getElementById('activitiesTableBody');
            activitiesTableBody.innerHTML = ''; // Limpa os dados anteriores

            if (activities.length > 0) {
                document.querySelector('.table-activitiesTableBody').classList.remove('d-none');
                // Popula os dados na tabela
                activities.forEach(activity => {
                    const row = `
                <tr>
                    <td>${activity.user_name}</td>
                    <td>${activity.translate}</td>
                    <td>${activity.date}</td>
                </tr>
            `;
                    activitiesTableBody.innerHTML += row;
                });

            }


        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            toastr.error(errorThrown);
            document.getElementById('offcanvasRight').classList.remove('show');
            document.getElementById('rightbar-etp-overlay').classList.remove('show');
        },
        complete: function () {

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
                    const deletePermisson = value.deletu == true ? `<a href="javascript:void(0)" onclick="deleteComment(${value.id},${etpId} )"<i class="fas fa-trash ml-3"></i> </a>` : '';
                    options += '<div class="media mt-4">';
                    options += '<div class="avatar-sm font-weight-bold d-inline-block">'
                    options += '    <span class="avatar-title rounded-circle bg-soft-purple tx-14">'
                    options += value.user
                    options += '    </span>'
                    options += '</div>'
                    options += '    <div class="media-body overflow-hidden ml-2">';
                    options += '        <h5 class="tx-black text-truncate mb-1 tx-14 ">' + value.user_name + '</h5>';
                    options += `        <div class="direct-chat-text"><span style="word-break: break-all; white-space: pre-line">  ${value.text}  </span></div>`
                    options += '    </div>';
                    options += `    <div class="font-size-11">${value.date} ${deletePermisson}</div>`;
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

function deleteComment(commentId, etpId) {
    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        url: `${BASE_URL_API_OBRA}etapa/${etpId}/comment/${commentId}/delete`,
        type: 'DELETE',
        ajax: true,
        dataType: "JSON",
        success: function (j) {
            getCommentsEtapa(etpId)
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            toastr.error('Não foi possivel Deletar');
        }
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
        $('.js-new-comment').html('');
        getCommentsEtapa(etp_id)
        getEtapas();
    });
}


$('#select--department_id').on('change', function () {
    var departmenId = $(this).val();
    if (departmenId != '') {
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
        let scroll = parseFloat(40) + el.scrollHeight;
        // for box-sizing other than "content-box" use:
        // el.style.cssText = '-moz-box-sizing:content-box';
        el.style.cssText = 'height:' + scroll + 'px';
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


$('.input-update-obra').on('keyup', function () {
    let collumn = $(this).attr('name');
    let value = $(this).val();
    $(`.${collumn}-span-save`).html('Salvando...')
    clearTimeout(timeUpdateObra);
    timeUpdateObra = setTimeout(function () {
        updateObra(collumn, value);
    }, 900);
});

function updateObra(collumn, value) {
    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        url: `${BASE_URL_API_OBRA}update`,
        type: "POST",
        ajax: true,
        dataType: "JSON",
        data: {
            collumn: collumn,
            value: value,
        },
        complete: function () {
            $(`.${collumn}-span-save`).html('Salvo')
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            toastr.error('Não foi possivel atualizar a etapa, tente de novo');
        },
    });
}

$('#modoEdicaoBtn').on('click', function () {
    $(this).addClass('d-none');

    $('#etapas-list').sortable({
        placeholder: "ui-state-highlight",
        update: function (event, ui) {

            const ordemEtapas = [];
            $('#etapas-list li').each(function (index, element) {
                const etapaId = $(element).data('id');
                const tipoId = $(element).data('tipo-id');
                ordemEtapas.push({
                    id: etapaId,
                    tipo_id: tipoId,
                    ordem: index + 1 // Começar a ordem em 1
                });
            });


            axios.post(`${BASE_URL_API_OBRA}etapa/reordenar`, {
                ordem: ordemEtapas
            }).then(function (response) {
                console.log('Nova ordem salva com sucesso!');
            }).catch(function (error) {
                console.error('Erro ao salvar a nova ordem:', error);
                alert('Ocorreu um erro ao salvar a nova ordem. Tente novamente.');
            });

        }
    }).disableSelection();

    modoActive();
});

$('#sairModoEdicaoBtn').on('click', function () {
    $('#etapas-list').sortable("destroy");
    $('#editModeButtons').addClass('d-none');
    $('#modoEdicaoBtn').removeClass('d-none');
    $('.checkbox-wrapper-mail').toggleClass('d-none');
});

//$('.mode-edition').on('click', function () {
//    $('.mode-edition').removeClass('d-none');
//    $(this).addClass('d-none');
//    $('.checkbox-wrapper-mail').toggleClass('d-none');
//    let type = $(this).attr('data-type');
//    type == 'active' ? modoActive() : modoExit();
//})
//

function modoActive() {
    $('.checkbox-wrapper-mail').toggleClass('d-none');

    $('#editModeButtons').removeClass('d-none');
}

function modoExit() {
    $('#editModeButtons').addClass('d-none');
    $('#modoEdicaoBtn').removeClass('d-none');
}

$("#addSelectionEtapa").on("click", function () {
    let arr = [];
    $(".js-btn-mode-input:checked").each(function () {
        arr.push($(this).val());
    });

    if (arr != '') {
        axios({
            method: 'get',
            url: `${BASE_URL_API_OBRA}etapas`,
            data: {
                id_etapa: arr,
            },
        }).then(response => {
            modoExit();
            getEtapas();
            toastr.success(response.data);
        }).catch(e => {
            toastr.error(e.response?.data?.message ? e.response.data.message : 'Erro contate o administrador');
        })
    } else {
        toastr.error('selecione alguma etapa')
    }
});

$("#deleteSelectionEtapa").on("click", function () {
    let arr = [];
    $(".js-btn-mode-input:checked").each(function () {
        arr.push($(this).val());
    });

    if (arr != '') {
        axios({
            method: 'DELETE',
            url: `${BASE_URL_API_OBRA}etapa/deleteSelected`,
            data: {
                id_etapa: arr,
            },
        }).then(response => {
            modoExit();
            getEtapas();
            toastr.success(response.data);
        }).catch(e => {
            toastr.error(e.response?.data?.message ? e.response.data.message : 'Erro contate o administrador');
        })
    } else {
        toastr.error('selecione alguma etapa')
    }
});

$('#updateSelectionEtapa').on('click', function () {
    const modalEtp = $('#modal-update-etapa-selecteds')
    let arr = [];
    $(".js-btn-mode-input:checked").each(function () {
        arr.push($(this).val());
    });

    console.log(arr);
    modalEtp.find('#input--etapas').val(arr)
    modalEtp.modal('show');
})

$('.js-new-comment').on('keyup', function () {
    let value = $(this).html();
    $('#input-new-comment').val(value);
    if (value.includes('@')) {
        //getUsers(value);
    } else {
        document.querySelector('#result-users').remove()
    }
})

function getUsers(term) {
    var re = /\s*@\s*/;
    term = term.split(re);
    axios({
        method: 'GET',
        url: `${BASE_URL_API}users?q%5Bterm%5D=${term[1] ?? ''}`,
    }).then(response => {
        const data = response.data.data;
        let html = ``

        if (data.length > 0) {
            if (!document.querySelector('#result-users')) {
                $.each(data, function (index, value) {
                    html += `<div style="width: 94%; height: 120px; background: transparent" id="result-users">
                <div class="d-flex my-2">
                    <div style="height: 1.5rem;width: 1.5rem;font-size: 10px;" class="font-weight-bold d-inline-block">
                            <span class="avatar-title rounded-circle bg-soft-purple ">
                                ${value.singleName}
                            </span>
                        </div>
                        <div class="flex-1">
                            <a href="javascript:void(0)" class="" onclick="userSelected(${value.id})"><h6 class=" mb-1" style="margin-left: 6px;margin-top: 3px;">${value.name}</h6></a>
                        </div>
                    </div>
                </div>`;
                });
            }
            document.querySelector('#comment-div').insertAdjacentHTML('afterend', html);
        } else {
            document.querySelector('#result-users').remove();
        }
    })
}

function userSelected(userId) {
    let text = $('.js-new-comment').html();
    let html = `<a href="#" data-id="1">Gabriel_Gobbi</a>`;
    let prep = $('.js-new-comment').html();

    var re = /\s*@\s*/;
    prep = prep.split(re);
    text = text.replace(prep[1], "");
    text = text.replace('@', "");

    $('.js-new-comment').html('');
    $('.js-new-comment').append(`${text}${html}`);
    $('#input-new-comment').val(`${text}${html}`);
    document.querySelector('#result-users').remove();
}


$('#addEtapaModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
});

document.getElementById('salvarEtapaBtn')?.addEventListener('click', function () {

    const etapasSelecionadas = document.getElementById('select--etapas_not_in_obra').tomselect.getValue();

    if (etapasSelecionadas.length === 0) {
        alert('Por favor, selecione ao menos uma etapa.');
        return;
    }

    // Fazer uma requisição POST com Axios
    axios.post(`${BASE_URL_API_OBRA}etapa/adicionar-etapas`, {
        obra_id: obraId,
        etapas: etapasSelecionadas
    })
        .then(function (response) {
            alert('Etapas adicionadas com sucesso!');
            $('#addEtapaModal').modal('hide');
            modoExit();
            getEtapas();
            document.getElementById('select--etapas_not_in_obra').tomselect.clear()
        })
        .catch(function (error) {
            console.error('Erro ao adicionar as etapas:', error);
            alert('Ocorreu um erro ao adicionar as etapas. Por favor, tente novamente.');
        });
});


/*Documentos Etapas */
const preloader = document.getElementById('preloader');
const documentsTable = document.getElementById('documents-section');
const documentsTableBody = documentsTable.querySelector('.row');

const initFetchEtapaDocumentos = async (etapaId) => {
    documentsTableBody.innerHTML = preload('preload-etapas-documents');
    setEtapaDocumentosInDom(etapaId);
}

const setEtapaDocumentosInDom = async (etapaId) => {
    const documents = await getEtapaDocumentos(etapaId);
    documentsTableBody.innerHTML = '';
    documentsTableBody.innerHTML += documents.data
        .map((data) =>
            `
            <div class="col-6 col-sm-3 col-md-3">
              <div class="card card-file" id="card-file-${data.id}" onclick="toggleSelect(${data.id}, event)">
                <div class="dropdown-file" style="position: absolute;right: 4px;top: 8px;">
                  <a class="dropdown-link" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <button type="button" class="dropdown-item delete" onclick="deleteFile(${data.id}, ${etapaId})">
                      <i class="fas fa-trash mr-2"></i>Deletar
                    </button>
                    <a target="_blank" class="dropdown-item" href="${data.path}">Visualizar</a>
                  </div>
                </div>
                <div class="card-file-thumb">
                  <i class="far fas fa-file" style="color:#d43030"></i>
                </div>
                <div class="card-body">
                  <span>${data.name}</span>
                </div>
              </div>
            </div>
        `
        )
        .join(' ');
}

const getEtapaDocumentos = async (etapaId) => {
    return await axios.get(`/api/v1/etapas/${etapaId}/files`)
        .then(function (response) {
            return response.data;
        })
        .catch(function (error) {
            toastr.error(error.response.data.message);
        });
}

async function deleteFile(fileId, etapaId) {
    if (!confirm('Tem certeza que deseja excluir este arquivo?')) return;

    try {
        await axios.delete(`/api/v1/uploadeds/${fileId}`);
        toastr.success('Deletado com sucesso');
        initFetchEtapaDocumentos(etapaId);
    } catch (error) {
        console.error('Erro ao deletar arquivo:', error);
        toastr.error('Não foi possivel Deletar');
    }
}

function generateArchive() {
    const selectedIds = document.getElementById('selectedFilesInput').value;

    axios.post(
        '/api/v1/uploadeds/generateArchive',
        { ids: selectedIds },
        { responseType: 'blob' } // importante para tratar a resposta como um arquivo binário
    )
        .then(response => {
            $('#generateArchiveButton').addClass('d-none');

            document.querySelectorAll('.card-file.selected').forEach(card => {
                card.classList.remove('selected');
            });

            const url = window.URL.createObjectURL(new Blob([response.data]));

            // Cria um link temporário para disparar o download
            const link = document.createElement('a');
            link.href = url;

            // Tenta extrair o nome do arquivo a partir do header 'content-disposition'
            let fileName = 'arquivo.zip';
            const disposition = response.headers['content-disposition'];
            if (disposition && disposition.indexOf('filename=') !== -1) {
                const fileNameMatch = disposition.match(/filename="?([^"]+)"?/);
                if (fileNameMatch && fileNameMatch.length === 2) {
                    fileName = fileNameMatch[1];
                }
            }
            link.setAttribute('download', fileName);

            // Adiciona o link ao DOM, clica nele para iniciar o download e depois remove-o
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            // Libera o objeto URL criado
            window.URL.revokeObjectURL(url);

            toastr.success('Arquivo gerado com sucesso!');
        })
        .catch(error => {
            console.log(error);
            toastr.error(error.response.data.message || 'Erro ao gerar o arquivo');
        }).finally(() => {
            document.getElementById('selectedFilesInput').value = '';
            console.log(document.getElementById('selectedFilesInput').value)
        });
}


let resumableEtapa = null;
function initResumable(parentModel, parentId) {
    if (resumableEtapa) {
        resumableEtapa.cancel();
        resumableEtapa.opts.query = function () {
            return {
                _token: '{{ csrf_token() }}',
                parent_model: parentModel,
                parent_id: parentId,
            };
        };
        return;
    }

    // Cria uma nova instância se ainda não existir
    resumableEtapa = new Resumable({
        target: '/api/v1/upload',
        query: function () {
            return {
                _token: '{{ csrf_token() }}',
                parent_model: parentModel,
                parent_id: parentId,
            };
        },
        chunkSize: 10 * 1024 * 1024, // Tamanho do chunk em bytes
        headers: {
            'Accept': 'application/json',
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumableEtapa.assignBrowse(document.getElementById('button-add-new-file'));

    resumableEtapa.on('fileAdded', function (file) {
        showProgress();
        resumableEtapa.upload();
    });

    resumableEtapa.on('fileProgress', function (file) {
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumableEtapa.on('fileSuccess', function (file, response) { });

    resumableEtapa.on('fileError', function (file, response) {
        toastr.error('Erro ao enviar o arquivo.');
        hideProgress();
    });

    resumableEtapa.on('complete', function () {
        toastr.success('Arquivo enviado com sucesso!');
        initFetchEtapaDocumentos(document.getElementById('js-etapa-id').value);
        hideProgress();
    });
}

let progress = $('.progress');

function showProgress() {
    progress.find('.progress-bar').css('width', '0%');
    progress.find('.progress-bar').html('0%');
    progress.find('.progress-bar').removeClass('bg-success');
    progress.show();
}

function updateProgress(value) {
    progress.find('.progress-bar').css('width', `${value}%`);
    progress.find('.progress-bar').html(`${value}%`);
}

function hideProgress() {
    progress.hide();
}


/*Modelo Documentos Etapas */
const modeloDocumentsTable = document.getElementById('modelo_documents-section');
const modeloDocumentsTableBody = modeloDocumentsTable.querySelector('.row');

const initFetchModeloEtapaDocumentos = async (etapaId) => {
    modeloDocumentsTableBody.innerHTML = preload('preload-etapas-documents');
    setModeloEtapaDocumentosInDom(etapaId);
}

const setModeloEtapaDocumentosInDom = async (etapaId) => {
    const documents = await getModeloEtapaDocumentos(etapaId);
    modeloDocumentsTableBody.innerHTML = '';
    modeloDocumentsTableBody.innerHTML += documents.data.map((data) =>
        `
            <div class="col-6 col-sm-3 col-md-3">
                 <div class="card card-file" id="card-file-${data.id}" onclick="toggleSelect(${data.id}, event)">
                    <div class="dropdown-file" style="position: absolute;right: 4px;top: 8px;">
                        <a class="dropdown-link" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a target="_blank" class="dropdown-item" href="${data.path}">Visualizar</a>
                        </div>
                    </div>
                    <div class="card-file-thumb">
                    <i class="far fas fa-file" style="color:#d43030"></i>
                </div>
                <div class="card-body">
                    <span>${data.name}</span>
                </div>
            </div>
        </div>
    `).join(' ');
}

const getModeloEtapaDocumentos = async (etapaId) => {
    return await axios.get(`/api/v1/etapas/${etapaId}/get-files`)
        .then(function (response) {
            return response.data;
        })
        .catch(function (error) {
            toastr.error(error.response.data.message);
        });
}

let selectedDocumentIds = [];

/**
 * Função chamada ao clicar no card.
 * @param {number} documentId - O ID do documento clicado.
 * @param {Event} event - O objeto de evento para manipular a propagação.
 */
function toggleSelect(documentId, event) {
    if (event.target.closest('.dropdown-file')) return;

    const card = event.currentTarget;

    const index = selectedDocumentIds.indexOf(documentId);
    if (index === -1) {
        selectedDocumentIds.push(documentId);
        card.classList.add('selected');
    } else {
        selectedDocumentIds.splice(index, 1);
        card.classList.remove('selected');
    }

    const hiddenInput = document.getElementById('selectedFilesInput');
    if (hiddenInput) {
        hiddenInput.value = selectedDocumentIds.join(',');
    }

    const generateButton = document.getElementById('generateArchiveButton');
    if (generateButton) {
        if (selectedDocumentIds.length > 0) {
            generateButton.classList.remove('d-none');
        } else {
            generateButton.classList.add('d-none');
        }
    }
}


/*
async function fetchEtapaDocumentos(etapaId) {
    const preloader = document.getElementById('preloader');
    const documentsTable = document.getElementById('documents-section');
    const documentsTableBody = documentsTable.querySelector('.row');

    try {
        // Chamar a API
        const response = await axios.get(`/api/v1/etapas/${etapaId}/files`);
        const documentos = response.data;

        documentsTableBody.innerHTML = '';


        tableTbody.innerHTML += list.data.map((data) => `
            <tr data-id="${data.id}">
                <td>${data.id}</td>
                <td>${data.name}</td>
                <td class="text-end">
                    <a href="${base_url}/admin/artists/${data.id}" data-id="${data.id}" >
                        <i class="fa-solid fa-edit"></i>
                    </a>
                </td>
            </tr>`).join(' ')


        documentos.forEach(doc => {

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${doc.id}</td>
                <td>${doc.name}</td>
                <td>${doc.mime_type}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="viewDocument(${doc.id})">Visualizar</button>
                    <button class="btn btn-sm btn-warning" onclick="editDocument(${doc.id})">Editar</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteDocument(${doc.id})">Excluir</button>
                </td>
            `;
            documentsTableBody.appendChild(row);
        });

        // Exibir a tabela e esconder o preloader
        preloader.style.display = 'none';
        documentsTable.style.display = 'table';
    } catch (error) {
        console.error('Erro ao buscar documentos:', error);
        alert('Erro ao carregar os documentos. Tente novamente.');
    }
}
*/
