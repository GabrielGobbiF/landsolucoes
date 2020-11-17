<div class="modal fade effect-scale" id="modal-change" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form role="form" class="needs-validation" novalidate id="form_change" autocomplete="off"
                action="{{ route('auditorys.document.change') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="" name="documento_id" id="documento_id">
                <input type="hidden" value="{{ $employee->uuid }}" name="employee_id" id="employee_id">

                <div class="modal-header">
                    <h6 class="modal-title">Alterar Documento</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="reason" class="">Motivo *</label>
                        <textarea class="form-control" id="reason" name="reason" cols="5" rows="5" required></textarea>
                    </div>

                    <div class="form-group mt-5">
                    <p class="mg-b-0 text-center mt-5">Tem certeza que deseja alterar o documento?</p>
                        <input type="file" name="file" id="file_document_change" required>
                        <p class="help-block">somente arquivos <b>PDF</b></p>
                        <br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="modal-cancel" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="modal-confirm" class="btn btn-danger btn-confirm">Alterar</button>
                </div>
            </form>
        </div>
    </div>
</div>
