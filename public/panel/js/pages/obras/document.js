$(document).ready(function () {
    $('#folder_childer').val($('#select__pasta').val());
    init();
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
        maxFilesize: 10, // MB
        url: 'http://www2.app.landsolucoes.com.br/l/arquivos',
        complete: function (file, response) {
            this.removeAllFiles();
            $('#modal-add-documento').modal('hide');
            list()
        }
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

