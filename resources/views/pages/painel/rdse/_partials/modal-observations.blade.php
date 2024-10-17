@once

    @section('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
    @append

@endonce


<div id="modalObservations" class="modal fade" tabindex="-1" aria-labelledby="modalObservationsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalObservationsLabel" class="modal-title">Editor de Texto</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <input id="modal-row_value" type="hidden" class="">
                <input id="modal-row" type="hidden" class="">
                <input id="modal-rdseId" type="hidden" class="">

                <div id="toolbar-container">
                    <span class="ql-formats">
                        <select class="ql-font"></select>
                        <select class="ql-size"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-strike"></button>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-color"></select>
                        <select class="ql-background"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-script" value="sub"></button>
                        <button class="ql-script" value="super"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-header" value="1"></button>
                        <button class="ql-header" value="2"></button>
                        <button class="ql-blockquote"></button>
                        <button class="ql-code-block"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                        <button class="ql-indent" value="-1"></button>
                        <button class="ql-indent" value="+1"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-direction" value="rtl"></button>
                        <select class="ql-align"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-link"></button>
                        <button class="ql-image"></button>
                        <button class="ql-video"></button>
                        <button class="ql-formula"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-clean"></button>
                    </span>
                </div>
                <div id="quillEditor"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


@section('scripts')
    @once

        @section('scripts')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
            <script>
                //document.addEventListener('DOMContentLoaded', function() {
                //    init();
                //});

                const quill = new Quill('#quillEditor', {
                    modules: {
                        syntax: true,
                        toolbar: '#toolbar-container',
                    },
                    placeholder: 'Compose an epic...',
                    theme: 'snow',
                });


                function init() {
                    let observationsContent = $("#modal-row_value").val();

                    quill.root.innerHTML = observationsContent

                    quill.on('text-change', function(delta, oldDelta, source) {
                        var content = quill.root.innerHTML;
                        if (content != $("#modal-row_value").val()) {
                            debouncedSaveContent(content);
                        }
                    });

                    $("#modalObservations").modal('show');

                }

                const debouncedSaveContent = debounce(function(content) {
                    saveContent(content);
                }, 1500);

                function openObservationModal(rdseId, row) {
                    quill.off('text-change');

                    $("#modal-row_value").val('')
                    $("#modal-row").val('')
                    $("#modal-rdseId").val('')

                    axios.get(`${base_url}/api/v1/rdses/${rdseId}`)
                        .then(function(response) {
                            $("#modal-row_value").val(response.data.observations)
                            $("#modal-row").val(row)
                            $("#modal-rdseId").val(rdseId)
                            init();
                        })
                }

                function saveContent(content) {
                    // Definir a URL para o campo correto com base no editor atual
                    var url = $("#modal-row").val();
                    var span = '';
                    let rdseId = $("#modal-rdseId").val();

                    // Enviar o conteúdo via Axios para o backend
                    axios.put(`${base_url}/api/v1/rdse/${rdseId}`, {
                            collumn: url,
                            value: content,
                        })
                        .then(function(response) {
                            toastr.success('Alterado');

                        })
                        .catch(error => {
                            toastr.error(error)
                        });
                }
            </script>
        @append
    @endonce
@append
