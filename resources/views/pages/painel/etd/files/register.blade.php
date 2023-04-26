<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Epi Registro de Arquivo</title>

    <link href="{{ asset('mobile/css/app.css') }}" rel="stylesheet">

    <script>
        var BASE = `{{ env('APP_URL') }}`;
    </script>

    <script src="{{ asset('mobile/js/app.js') }}"></script>

    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
        }

        .select2-container .select2-selection--single {
            height: 35px !important;
        }

        .select2-selection__arrow {
            height: 34px !important;
        }
    </style>

</head>

<body>
    <div id="app">
        <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column "
            style="    max-width: 42em; height: 100vh;">
            <header class="masthead mb-3 mt-2">
                <div class="justify-content-between d-flex mb-4">
                    <span>{{ Auth::user()->name }} </span>
                    <span class="time"> </span>

                </div>
                <div class="text-center">
                    <h4 class="cover-heading "></h4>
                    <span></span>
                </div>
            </header>

            <main role="main">
                <form id="form-register" role="form" class="needs-validation"
                    action="{{ route('etd.files.register.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            REGISTRO DE IMAGENS ETDs
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>ETDs</label>
                                <select name="etd" id="etd" class="select2" required>
                                    <option value="">Selecione a ETDs</option>
                                    @foreach ($etds as $etd)
                                        <option required value="{{ $etd->id }}">{{ $etd->nome }} -
                                            {{ $etd->board }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{--
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="images">Fotos</label>
                                    <input type="file" class="form-control-file" id="images" name="attachments[]"
                                        multiple accept='image/*'>
                                </div>
                            </div>
                        --}}
                    </div>
                    <div class="upload d-none">
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <div class="form-group">
                                    <label for="observations">Observações</label>
                                    <textarea name="observations" id="observations" cols="30" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div style="display: none" class="progress mt-3" style="height: 25px">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 75%; height: 100%">75%</div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <div id="upload-container" class="text-center mb-5">
                                    <button type="button" id="browseFile" class="btn btn-primary">Adicionar
                                        Arquivo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-success p-3 d-none">
                        <span class="text-light">Sucesso</span>
                    </div>
                </form>
            </main>

            {{--
            <div class="row">
                <div class="table-responsive mt-5">
                    <div class="header">
                        <h4>Registros de hoje</h4>
                    </div>
                    <table class='table table-hover'>
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Local</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($filesNow as $fileNow)
                                @php
                                    $etd = getEpi($fileNow->service_id);
                                @endphp
                                <tr>
                                    <td>{{ $fileNow->user->name }}</td>
                                    <td>{{ $etd->nome }}</td>
                                    <td>{{ $fileNow->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            --}}
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
<script type="text/javascript">
    $('#etd').on('select2:select', function(e) {
        $(".bg-success").addClass('d-none');
        init();
    });
    const init = () => {
        let message = localStorage.getItem('success');
        if (message == 'true') {
            $(".bg-success").removeClass('d-none');
            localStorage.setItem("success", "false");
        }

        $('.upload').addClass('d-none');

        let etdValue = $('#etd').val();
        if (etdValue) {
            $('.upload').removeClass('d-none');

            let browseFile = $('#browseFile');
            let resumable = new Resumable({
                target: '{{ route('etd.files.register.store') }}',
                query: {
                    _token: '{{ csrf_token() }}',
                    etd: $('#etd').val(),
                    observations: $('#observations').val()
                }, // CSRF token
                fileType: ['jpeg', 'jpg', 'png'],
                chunkSize: 10 * 1024 * 1024 *
                    2048, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
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
                //window.location.reload();
            });

            resumable.on('complete', function(file, response) { // trigger when file upload complete
                localStorage.setItem("success", "true");
                window.location.reload();
                //$(".bg-success").removeClass('d-none');
                //$('.upload').addClass('d-none');
                //$('#etd').val('').trigger('change');
                hideProgress();
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

        } else {
            $('.upload').addClass('d-none');
        }
    }
    init();
</script>

<script>
    $(document).ready(function() {
        setInterval(relogio, 1000);
    })

    const zeroFill = n => {
        return ('0' + n).slice(-2);
    }

    function relogio() {
        const now = new Date();
        const dataHora = zeroFill(now.getUTCDate()) + '/' + zeroFill((now.getMonth() + 1)) + '/' + now.getFullYear() +
            ' ' + zeroFill(now.getHours()) + ':' + zeroFill(now.getMinutes()) + ':' +
            zeroFill(now.getSeconds());
        $('.time').html(dataHora)
    }
</script>

</html>
