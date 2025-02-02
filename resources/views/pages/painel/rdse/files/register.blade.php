<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RDSE Registro de Arquivo</title>

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
                    @if (session('message'))
                        <div class="bg-success p-1">
                            <span class="text-light">{{ session('message') }}</span>
                        </div>
                    @endif
                </div>
                <div class="text-center">
                    <h4 class="cover-heading "></h4>
                    <span></span>
                </div>
            </header>

            <main role="main">
                <form id="form-register" role="form" class="needs-validation"
                    action="{{ route('rdse.files.register.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            REGISTRO DE IMAGENS - PROJETO E MANUTEÇÃO ELÉTRICA.
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>RDSE</label>
                                <select name="rdse" id="rdse" class="select2" required>
                                    <option value="">Selecione a RDSE</option>
                                    @foreach ($rdses as $rdse)
                                        <option required value="{{ $rdse->id }}">{{ $rdse->nome }} -
                                            {{ $rdse->board }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-12 mt-4">
                            <div class="form-group">
                                <label for="observations">Observações</label>
                                <textarea name="observations" id="observations" cols="30" rows="4" class="form-control"></textarea>
                            </div>
                        </div>

                        <style>
                            .picker-content {
                                height: 300px;
                                width: 200px;
                            }
                        </style>
                        <script src="//static.filestackapi.com/filestack-js/2.x.x/filestack.min.js"></script>
                        <script type="text/javascript">
                            document.addEventListener("DOMContentLoaded", function(event) {
                                const client = filestack.init('AqTLajjHeT2i0atkpmEgEz');

                                let options = {
                                    "displayMode": "inline",
                                    "container": ".picker-content",
                                    "accept": [
                                        "image/jpeg",
                                        "image/jpg",
                                        "image/png"
                                    ],
                                    "fromSources": [
                                        "local_file_system"
                                    ],
                                    "uploadInBackground": false,
                                    "onUploadDone": (res) => console.log(res),
                                };

                                picker = client.picker(options);
                                picker.open();
                            });
                        </script>
                        <div class="col-md-12 mt-4">

                            <div class="picker-content"></div>
                        </div>
                    </div>


                </form>

                <div class="table-responsive mt-4 d-none">
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
                                    $rdse = getEpi($fileNow->service_id);
                                @endphp
                                <tr>
                                    <td>{{ $fileNow->user->name }}</td>
                                    <td>{{ $rdse->nome }}</td>
                                    <td>{{ $fileNow->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
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
