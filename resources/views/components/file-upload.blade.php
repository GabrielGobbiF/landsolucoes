<div id="fileUploadModal" class="modal fade" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="fileUploadModalLabel" class="modal-title">Upload de Arquivos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <input id="parentModel" type="hidden" value="">
                <input id="parentId" type="hidden" value="">

                <div id="upload-container" class="text-center">
                    <button id="browseFile" class="btn btn-primary">Selecionar Arquivo</button>
                </div>
                <div class="progress mt-3" style="height: 25px; display: none;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                         aria-valuemax="100" style="width: 0%; height: 100%">
                        0%
                    </div>
                </div>

                <div id="uploaded-files" class="mt-4 arquivos">
                    <div class="row"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

@once
    @section('components-scripts')

        {{--
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let resumable = new Resumable({
                    target: '/api/v1/upload',
                    query: function() {
                        return {
                            _token: '{{ csrf_token() }}',
                            parent_model: $('#parentModel').val(),
                            parent_id: $('#parentId').val(),
                        };
                    },
                    chunkSize: 10 * 1024 * 1024,
                    headers: {
                        'Accept': 'application/json'
                    },
                    testChunks: false,
                    throttleProgressCallbacks: 1,
                });

                resumable.assignBrowse($('#browseFile')[0]);

                resumable.on('fileAdded', function(file) {
                    showProgress();
                    resumable.upload();
                });

                resumable.on('fileProgress', function(file) {
                    updateProgress(Math.floor(file.progress() * 100));
                });

                resumable.on('fileSuccess', function(file, response) {
                    toastr.success('Arquivo(s) enviado com sucesso.');
                    response = JSON.parse(response);
                    addUploadedFileCard(response);
                    hideProgress();
                });

                resumable.on('fileError', function(file, response) {
                    toastr.error('Erro ao fazer o upload do arquivo.');
                    hideProgress();
                });

                let progress = $('.progress');

                function showProgress() {
                    progress.find('.progress-bar').css('width', '0%');
                    progress.find('.progress-bar').html('0%');
                    progress.find('.progress-bar').removeClass('bg-success');
                    progress.show();
                }

                function updateProgress(value) {
                    progress.find('.progress-bar').css('width', `${value}%`);
                    progress.find('.progress-bar').html(`${value}%`);
                }

                function hideProgress() {
                    progress.hide();
                }

                function addUploadedFileCard(fileData) {
                    let uploadedFilesContainer = $('#uploaded-files .row');
                    let cardHtml = `
                        <div class="col-6 col-sm-3 col-md-3">
                            <div id="card-file" class="card card-file">
                                <div class="card-file-thumb">
                                    <i class="far fas fa-file" style="color:#d43030"></i>
                                </div>
                                <div class="card-body">
                                    <span>${fileData.name}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    uploadedFilesContainer.append(cardHtml);
                }

                // Abrir a modal com os valores dinâmicos
                window.openFileUploadModal = function(parentModel, parentId) {
                    $('#parentModel').val(parentModel);
                    $('#parentId').val(parentId);
                    $('#fileUploadModal').modal('show');
                };

                document.querySelectorAll('.button-open-file').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const parentModel = button.getAttribute('data-parentModel');
                        const parentId = button.getAttribute('data-parentId');
                        openFileUploadModal(parentModel, parentId);
                    });
                })

            });
        </script>
        --}}
    @append
@endonce
