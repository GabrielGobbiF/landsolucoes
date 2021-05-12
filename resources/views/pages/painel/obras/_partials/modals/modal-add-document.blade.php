@php
$redirect = $redirect ?? null;
@endphp
<div class="modal" id="modal-add-documento" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Documento {{ isset($pasta) ? 'em ' . $pasta->name : '' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form-add-documento" role="form" class="needs-validation custom-validation dropzone" enctype="multipart/form-data" action="{{ route('arquivos.store') }}"
                            method="POST">
                            <input type="hidden" name="folder_childer" value="{{ $pasta->uuid ?? '' }}">
                            @csrf
                            <div id="docs"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-submit"> <i class="fas fa-upload"></i> Enviar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')

    <script>
        Dropzone.autoDiscover = false;

        $(document).ready(function() {

            var myDropzone = new Dropzone(".dropzone", {
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 100,
                maxFilesize: 10, // MB
                addRemoveLinks: true,
            });

            $('.btn-submit').on('click', function(e) {
                e.preventDefault();
                myDropzone.processQueue();
                myDropzone.on("success", function(file, responseText) {
                    console.log(file)
                    console.log(responseText)
                    window.location.href = responseText.redirect;
                });
            });

            $('#modal-add-documento').on('hidden.bs.modal', function() {
                myDropzone.removeAllFiles();
            })

            $('.btn-secondary').click(function() {
                myDropzone.removeAllFiles();
            })

        });

    </script>

@stop
