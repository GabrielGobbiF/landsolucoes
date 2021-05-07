@php
$redirect = $redirect ?? null;
@endphp
<div class="modal" id="modal-add-documento" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-add-documento" role="form" class="needs-validation custom-validation" action="{{ route('pastas.store') }}" method="POST">
                <input type="hidden" name="folder_childer" value="{{ $pasta->uuid ?? '' }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Documento {{ isset($pasta) ? 'em ' . $pasta->name : '' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="input--liters">Documento</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('attachments') is-invalid @enderror" id="attachments" name="attachments"">
                                        <label class="custom-file-label" for="customFile">Selecione</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-submit"> <i class="fas fa-edit"></i> Adicionar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>
