<div class="modal" id="modal-add-update-etapa" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="form-add-update-etapa" role="form" class="needs-validation custom-validation" action="{{ route('etapas.store') }}" method="POST"
                enctype="multipart/form-data">
                @method("post")
                <input type="hidden" name="redirect" value="{{ isset($redirect) ? $redirect : null }}">
                <div class="modal-header">
                    <h5 class="modal-etapa-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include("pages.painel._partials.forms.form_etapa")
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fas fa-edit"></i> <span class="modal-btn-primary">Adicionar</span></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>

