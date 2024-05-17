<div class='modal' id='modal-update-etapa-selecteds' tabindex='-1' role='dialog'>
    <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id='form-update-etapa-selecteds' role='form' class='needs-validation' action='{{ route('obra.etapa.update.selecteds', $obra->id) }}' method='POST'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Atualizar Etapas Selecionadas</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    @csrf
                    <input type="hidden" name="etapas" id="input--etapas">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="tx-green">Data Meta</label>
                                <input type="text" class="form-control date" name="meta_etapa" id="input--meta_etapa" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label>Responsável</label>
                                <input type="text" class="form-control" name="responsavel" id="input--responsavel" autocomplete="off">
                            </div>
                        </div>
                    </div>

                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-primary btn-submit'>Salvar</button>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>
