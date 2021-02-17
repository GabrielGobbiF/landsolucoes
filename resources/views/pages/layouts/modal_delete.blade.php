<div class="modal fade effect-scale" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <form id="form-modal-action" role="form" class="needs-validation" method="POST">
            @csrf
            @method('delete')
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Deletar</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mg-b-0 modal-text-body">Tem certeza que deseja deletar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="modal-cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="modal-confirm" class="btn btn-danger">Deletar</button>
                </div>
            </div>
        </form>
    </div>
</div>
