$(document).ready(function () {
    $('#folder_childer').val($('#select__pasta').val());
    init();

    $('.file__change-name').on('click', function () {

    })

})

Dropzone.autoDiscover = false;

const urlDocument = `${BASE_URL_API_OBRA}documents`;
const divDocumentList = document.querySelector('#documents__list');

const all = async () => {
    const response = await axios.get(`${urlDocument}`);
    return response.data;
};

async function list() {
    divDocumentList.innerHTML = preload();
    let documents = await all();
    divDocumentList.innerHTML = documents;
}

function init() {
    list();

    /**
    * Dropzone
    */
    var myDropzone = new Dropzone(".dropzone", {
        autoProcessQueue: true,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        addRemoveLinks: true,
        maxFilesize: 500, // MB
        url: 'http://www2.app.landsolucoes.com.br/l/arquivos',
        success: function () {
            this.removeAllFiles();
            $('#modal-add-documento').modal('hide');
            list()
        }, error: function (file, message) {
            toastr.error(message);
        },
    });

    $('.btn-submit-document').on('click', function (e) {
        e.preventDefault();
        myDropzone.processQueue();
    });

    $('#modal-add-documento').on('hidden.bs.modal', function () {
        myDropzone.removeAllFiles();
    })

    $('.btn-secondary').on('click', function () {
        myDropzone.removeAllFiles();
    })
}

$('#select__pasta').on('change', function () {
    $('#folder_childer').val($(this).val());
})

function addDocument() {

}

function fileUpdate(v){
    let modal = $('#modal-file');
    let docId = $(v).attr('data-id');
    let docName = $(v).attr('data-name');
    let form = modal.find('#form-update-file');
    form.attr('action', `${base_url}/l/arquivos/${docId}`)
    modal.find('#input__fileId').val(docId);
    modal.find('#input--doc_name').val(docName)
    modal.modal('show');
}

function fileMove(v){
    let modal = $('#modal-file-move');
    let docId = $(v).attr('data-id');
    let docName = $(v).attr('data-name');
    let form = modal.find('#form-move-file');
    form.attr('action', `${base_url}/l/arquivos/${docId}/move`)
    modal.find('.modal-title').html(`Mover Documento: ${docName}`);
    modal.modal('show');
}


