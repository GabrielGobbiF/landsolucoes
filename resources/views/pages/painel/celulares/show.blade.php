@extends('app')

@section('title', 'Celular - ' . ucfirst($celular->linha))

@section('content')
    <div class="box">
        <div class="box-body">
            <form id="form-celulares" role="form" class="needs-validation" novalidate autocomplete="off" action="{{ route('celulares.update', $celular->id) }}"
                  method="POST">
                @csrf
                @method('put')
                @include('pages.painel._partials.forms.form-celulares')
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <button type="button" class="btn btn-primary btn-submit">Salvar</button>
                        <a href="{{ route('celular.signature', $celular->id) }}" type="button" class="btn btn-outline-light">
                            Assinatura
                        </a>
                        <button type="button" class="btn btn-outline-primary d-none" data-toggle="modal" data-target="#modalId">
                            Novo arquivo
                        </button>
                    </div>
                </div>
            </form>

            <div class="mt-4">
                <div class="box-body">

                    <div class="row">
                        @foreach ($files as $file)
                            <div class="col-3">
                                <div class="card text-center">
                                    <div class="card-file-thumb ">
                                        <div class="dropdown-file" style="position: absolute;right: 4px;top: 8px;">
                                            <a class="dropdown-link" data-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <form id="form-delete-" role="form" class="needs-validation"
                                                      onSubmit="if(!confirm('Tem certeza que deseja excluir?')){return false;}"
                                                      action="{{ route('celular.file.destroy', [$celular->id, $file->token]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" data-btn-text="Deletando" class="dropdown-item delete">
                                                        <i data-feather="trash"></i>Deletar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-file-thumb mt-5">
                                        <i class="far fas fa-file-pdf" style="color:#d43030; font-size:2rem"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title"
                                            style="white-space: normal;
                                            width: 100%;
                                            overflow: hidden;
                                            text-overflow: ellipsis;">
                                            <a href="{{ $file->path }}" target="_blank">
                                                {{ limit($file->name, 25) }}
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalId" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalTitleId" class="modal-title">Novo arquivo</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="mb-3 d-none">
                            <label for="inputFileName" class="form-label">Nome do Arquivo</label>
                            <input id="inputFileName" type="text" class="form-control" name="file_name">
                        </div>

                        <div class="mt-3">
                            <div class="card ">
                                <div class="card-body">
                                    <div id="upload-container" class="text-center">
                                        <button id="browseFile" class="btn btn-primary">Selecione o Arquivo</button>
                                    </div>
                                    <div style="display: none" class="progress mt-3" style="height: 25px">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                             aria-valuemax="100" style="width: 75%; height: 100%">75%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')

    <script class=""></script>

    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

    <script type="text/javascript">
        let browseFile = $('#browseFile');
        let resumable = new Resumable({
            target: '{{ route('celular.file', $celular->id) }}',
            query: {
                _token: '{{ csrf_token() }}'
            }, // CSRF token
            chunkSize: 10 * 1024 * 1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
            headers: {
                'Accept': 'application/json'
            },
            testChunks: false,
            throttleProgressCallbacks: 1,
        });

        resumable.assignBrowse(browseFile[0]);

        resumable.on('fileAdded', function(file) { // trigger when file picked
            showProgress();
            resumable.upload() // to actually start uploading.
        });

        resumable.on('fileProgress', function(file) { // trigger when file progress update
            updateProgress(Math.floor(file.progress() * 100));
        });

        resumable.on('fileSuccess', function(file, response) { // trigger when file upload complete
            response = JSON.parse(response)
            window.location.reload();
        });

        resumable.on('fileError', function(file, response) { // trigger when there is any error
            alert('file uploading error.')
        });


        let progress = $('.progress');

        function showProgress() {
            progress.find('.progress-bar').css('width', '0%');
            progress.find('.progress-bar').html('0%');
            progress.find('.progress-bar').removeClass('bg-success');
            progress.show();
        }

        function updateProgress(value) {
            progress.find('.progress-bar').css('width', `${value}%`)
            progress.find('.progress-bar').html(`${value}%`)
        }

        function hideProgress() {
            progress.hide();
        }
    </script>
@append
