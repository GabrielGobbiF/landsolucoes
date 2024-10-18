<div id="modalUpdateStatus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form-updateStatusRdse" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalTitleId" class="modal-title">
                        Adicionar Observação
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status">
                    <input type="hidden" name="rdse_id">
                    <div class="mb-3">
                        <label for="" class="form-label">Observação</label>
                        <textarea class="form-control" style="height: auto !important" name="status_observation" cols="50" rows="20"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>
