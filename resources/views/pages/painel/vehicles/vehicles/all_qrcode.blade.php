<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Veiculos Land</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

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
        <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column " style="height: 100vh;">
            <main>
                <div class="row">
                    @foreach ($vehicles as $vehicle)
                        <div class="col-md-2 mt-2">
                            <div class="card">
                                <div class="card-body text-center" style="justify-content: center;
                                display: grid;">
                                    @php
                                        $veiId = $vehicle->id;
                                    @endphp

                                    <img src="data:image/png;base64, {!! base64_encode(
    QrCode::format('png')->size(150)->generate("app.landsolucoes.com.br/v/$veiId/qr"),
) !!} ">
                                    <div class="mt-2">
                                        {{ $vehicle->board }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </div>
</body>


</html>
