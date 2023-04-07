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
                    action="{{ route('epi.files.register.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            REGISTRO DE IMAGENS EPI
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>EPI</label>
                                <select name="epi" id="epi" class="select2" required>
                                    <option value="">Selecione a EPI</option>
                                    @foreach ($epis as $epi)
                                        <option required value="{{ $epi->id }}">{{ $epi->name }} -
                                            {{ $epi->board }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="images">Fotos</label>
                                <input type="file" class="form-control-file" id="images" name="attachments[]"
                                    multiple accept='image/*'>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="form-group">
                                <label for="observations">Observações</label>
                                <textarea name="observations" id="observations" cols="30" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-2" id="div--button-submit">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>

                </form>

                <div class="table-responsive mt-4">
                    <div class="header">
                        <h4>Registros de hoje</h4>
                    </div>
                    <table class='table table-hover'>
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Epi</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($filesNow as $fileNow)
                                @php
                                    $epi = getEpi($fileNow->service_id);
                                @endphp
                                <tr>
                                    <td>{{ $fileNow->user->name }}</td>
                                    <td>{{ $epi->name }}</td>
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
