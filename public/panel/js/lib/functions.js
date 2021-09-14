function btn_delete(v) {

    var token = $('meta[name="csrf-token"]').attr('content');
    var html = `<div class="modal fade effect-scale" id="modal-confirm-delete" tabindex="-1" role="dialog" aria-hidden="true">`;
    html += `       <div class="modal-dialog modal-dialog-centered modal-sm" role="document">`;
    html += `           <div class="modal-content">`;
    html += `               <div class="modal-header">`;
    html += `                   <h6 class="modal-title"></h6>`;
    html += `                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">`;
    html += `                       <i class="fa fa-times"></i>`;
    html += `                   </button>`;
    html += `               </div>`;
    html += `               <div class="modal-body">`;
    html += `                   <p class="mg-b-0 modal-text-body"></p>`;
    html += `               </div>`;
    html += `               <div class="modal-footer">`;
    html += `                   <button type="button" id="modal-cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>`;
    html += `                      <form id="form-delete" role="form" class="needs-validation" action="" method="POST">`
    html += `                          <input type="hidden" name="_token" value="${token}"> `
    html += `                          <input type="hidden" name="_method" value="DELETE"> `
    html += `                          <button type="submit" id="modal-confirm"`
    html += `                              data-btn-text="Deletando" `
    html += `                              class="btn btn-danger `
    html += `                              btn-submit modal-btn-danger"> `
    html += `                              Deletar`
    html += `                          </button>`
    html += `                      </form>`
    html += `               </div>`;
    html += `           </div>`;
    html += `       </div>`;
    html += `</div>`;

    $('body').append(html);

    var $modal = $("#modal-confirm-delete")
    var href = $(v).attr('data-href');
    var text = $(v).attr('data-text');

    if (text != null) {
        $modal.find('.modal-title').html(`${text}`);
        $modal.find('.btn-danger').html(`<i class="fas fa-exclamation-circle"></i> ${text}`);
        $modal.find('.modal-text-body').html(`Tem certeza que deseja ${text}?`);
    }
    $modal.find('#form-delete').attr('action', href)
    $modal.modal('show');

    $modal.on('hidden.bs.modal', function() {
        $modal.remove();
    })

}

