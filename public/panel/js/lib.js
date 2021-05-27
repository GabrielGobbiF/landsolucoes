function btn_delete(v) {
    var href = $(v).attr('data-href');
    var title = $(v).attr('data-title');
    var text = $(v).attr('data-original-title');
    if (text != null && title != null) {
        $('.modal-title').html(title);
        $('#modal-confirm').html(text);
        $('.modal-text-body').html('Tem certeza que deseja ' + text + '?');
    }
    $('#form-modal-action').attr('action', href)
    $('#modal-delete').modal('show');
}
