@once

    @section('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
    @append

@endonce


<div id="editorModal" class="modal fade" tabindex="-1" aria-labelledby="editorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="editorModalLabel" class="modal-title">Editor de Texto</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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

@once

    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inicializar o editor Quill
                const quill = new Quill('#quillEditor', {
                    modules: {
                        syntax: true,
                        toolbar: '#toolbar-container',
                    },
                    placeholder: 'Compose an epic...',
                    theme: 'snow',
                });

                // Obtenha o conteúdo dos spans
                let observationsContent = document.getElementById('spanObservations').innerHTML;
                let observationsExecutionContent = document.getElementById('spanObservationsExecution').innerHTML;

                // Variável para rastrear qual editor está aberto (observations ou observations_execution)
                let currentEditor = '';

                function debounce(func, delay) {
                    let timer;
                    return function(...args) {
                        clearTimeout(timer);
                        timer = setTimeout(() => func.apply(this, args), delay);
                    };
                }

                function saveContent(content) {
                    // Definir a URL para o campo correto com base no editor atual
                    var url = currentEditor === 'observations' ? 'observations' : 'observations_execution';
                    var span = currentEditor === 'observations' ? 'spanObservations' : 'spanObservationsExecution';

                    // Enviar o conteúdo via Axios para o backend
                    axios.put(`${base_url}/api/v1/rdse/${rdseId}`, {
                            collumn: url,
                            value: content,
                        })
                        .then(function(response) {
                            if (currentEditor === 'observations') {
                                document.getElementById('spanObservations').innerHTML = content;
                            } else {
                                document.getElementById('spanObservationsExecution').innerHTML = content;
                            }
                        })
                        .catch(error => {
                            toastr.error(error)
                        });
                }

                const debouncedSaveContent = debounce(function(content) {
                    saveContent(content);
                }, 1500);

                // Manipular a abertura da modal e definir o conteúdo dinamicamente
                $('#editorModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget); // Botão que disparou a modal
                    var editorType = button.data('editor'); // Obter o tipo de editor (observations ou observations_execution)

                    currentEditor = editorType; // Atualizar o editor atual para salvar corretamente

                    // Alterar o título da modal dinamicamente
                    var modalTitle = editorType === 'observations' ? 'Editar Observations' : 'Editar Observations Execution';
                    $('#editorModalLabel').text(modalTitle);

                    // Carregar o conteúdo correto no editor Quill baseado no botão clicado
                    if (editorType === 'observations') {
                        quill.root.innerHTML = observationsContent;
                    } else {
                        quill.root.innerHTML = observationsExecutionContent;
                    }
                });

                // Evento de mudança no conteúdo do editor
                quill.on('text-change', function() {
                    var content = quill.root.innerHTML; // Obter o conteúdo atual do editor

                    // Chama a função debounced para salvar após 1.5 segundos de inatividade
                    debouncedSaveContent(content);
                });
            });
        </script>
    @append
@endonce
