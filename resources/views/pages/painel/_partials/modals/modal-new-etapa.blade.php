<div id="modal-add-update-etapa" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="form-add-update-etapa" role="form" class="needs-validation custom-validation" action="{{ route('etapas.store') }}" method="POST"
                  enctype="multipart/form-data">
                @method('post')
                <input type="hidden" name="redirect" value="{{ isset($redirect) ? $redirect : null }}">
                <input type="hidden" id="etapa_id" value="">
                <div class="modal-header">
                    <h5 class="modal-etapa-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('pages.painel._partials.forms.form_etapa')

                    <div class="card text-start mt-4 arquivos">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Modelos de Documento</h4>
                                <button id="button-add-new-file" type="button" data-parentId="884" data-parentModel="App\Models\Etapa"
                                        class="btn btn-sm btn-primary ">
                                    <i class="fas fa-plus"></i>
                                    Adicionar novo documento
                                </button>
                            </div>
                            <div id="documents-section" class="mt-4">
                                <div class="row">
                                    <div id="preloader" style="display: flex; justify-content: center; align-items: center; height: 100px;">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Carregando...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fas fa-edit"></i> <span class="modal-btn-primary">Adicionar</span></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>
