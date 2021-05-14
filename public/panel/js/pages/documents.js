
Dropzone.autoDiscover = false;

jQuery(function () {

    /**
    * Dropzone
    */
    var myDropzone = new Dropzone(".dropzone", {
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
    });

    $('.btn-submit').on('click', function (e) {
        e.preventDefault();
        myDropzone.processQueue();
        myDropzone.on("success", function (file, responseText) {
            window.location.href = responseText.redirect;
        });
    });

    $('#modal-add-documento').on('hidden.bs.modal', function () {
        myDropzone.removeAllFiles();
    })

    $('.btn-secondary').click(function () {
        myDropzone.removeAllFiles();
    })

    /**
    * Documentos
    */
    $('.fav').on('click', function () {
        var v = $(this);
        file_id = v.attr('data-id');
        url = v.attr('data-url');
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            ajax: true,
            dataType: "JSON",
            data: {
                file_id: file_id
            }
        }).done(function (response) {
            if (response == 'fav') {
                $('#card-file-' + file_id).find('.card-body').append('<div class="marker-icon marker-warning pos-absolute t--1 l--1"><i class="fas fa-star"></i></div>');
                v.find('span').html('Desmarcar Favorito');
                v.attr('data-url', BASE_URL + '/l/arquivos/unfavorite')
            } else {
                $('#card-file-' + file_id).find('.marker-warning').remove();
                v.find('span').html('Marcar Favorito');
                v.attr('data-url', BASE_URL + '/l/arquivos/favorite')
            }
        });
    })

});
