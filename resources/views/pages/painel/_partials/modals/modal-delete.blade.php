<div class="modal fade effect-scale" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mg-b-0 modal-text-body"></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="form-delete" role="form" class="needs-validation" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" id="modal-confirm" data-btn-text="Deletando" class="btn btn-danger btn-submit modal-btn-danger">Deletar</button>
                </form>
            </div>
        </div>
    </div>
</div>
