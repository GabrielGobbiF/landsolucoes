
Dropzone.autoDiscover = false;

$(function () {
    'use strict'

    $(window).on('load', function () {
        getDiv();
    })

    var getFiles = function () {
        return localStorage.getItem('files') ? JSON.parse(localStorage.getItem('files')) : [];
    }

    var getDiv = function () {
        var files = getFiles();
        $('#files-row').html('');
        if (files.length > 0) {
            $.each(files, function (index, value) {
                $('#files-row').append('<h6>' + files[index]['name'] + ' <a href="javascript:void(0)" data-id="' + files[index]['id'] + '" class="removeItem"><i class="fas fa-trash ml-2 tx-danger"></i></a></h6>')
            });
            $("#files--input").val(JSON.stringify(files));
            $('#files-downloading').removeClass('d-none');
            $('.removeItem').on('click', function () {
                var id = $(this).attr('data-id');
                for (var i = 0; i < files.length; i++) {
                    if (files[i].id == id) {
                        files.splice(i, 1);
                        localStorage.setItem('files', JSON.stringify(files));
                        getDiv();
                    }
                }
            })
        } else {
            $('#files-downloading').addClass('d-none');
        }
    }

    /**
    * Documentos
    */
    $('.fav').on('click', function () {
        var v = $(this);
        var file_id = v.attr('data-id');
        var url = v.attr('data-url');
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

    $('.download').on('click', function () {
        var v = $(this);
        var file_id = v.attr('data-id');
        var file_name = v.attr('data-name');
        var item = {
            id: file_id,
            name: file_name
        }
        saveItemfiles(item);
    })

    $('.btn-download').on('click', function () {
        localStorage.setItem('files', JSON.stringify([]));
        $('#files-downloading').addClass('d-none');
    })


    var setFiles = function (filesItems) {
        localStorage.setItem('files', JSON.stringify(filesItems));
        getDiv();
    }

    var hasItem = function (item) {
        var files = getFiles();
        if (!item.id)
            return false
        return files.some(filesItem => item.id == filesItem.id)
    }

    var saveItemfiles = function (item) {
        var files = getFiles()
        if (hasItem(item)) {
            files.forEach(filesItem => {
                if (filesItem.id == item.id) {
                    filesItem.name = item.name
                }
            })
        } else {
            if (!item.id)
                item.id = files.length + 1
            files.push(item)
        }
        setFiles(files)
    }

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

    $('.btn-secondary').on('click', function () {
        myDropzone.removeAllFiles();
    })

});



