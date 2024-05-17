<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Veiculos Land</title>

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
        <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column " style="    max-width: 42em; height: 100vh;">

            @if ($errors->any())
                @foreach ($errors->all() as $errors)
                    <div class="bg-danger p-1">
                        <span class="text-light">{{ $errors }}</span>
                    </div>
                @endforeach
            @endif

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
                <form id="form-register" role="form" class="needs-validation" action="{{ route('vehicles.portaria.create') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nome do Visitante</label>
                                    <input id="" type="text" class="form-control" name="name" required value="{{ old('name') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Veiculo</label>
                                <select id="vehicle_id" name="vehicle_id" class="select2" required>
                                    <option value="">Selecione</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }} required value="{{ $vehicle->id }}">
                                            {{ $vehicle->name }} - {{ $vehicle->board }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kilometragem</label>
                                    <input id="" type="number" class="form-control" name="km" required value="{{ old('km') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Motorista</label>
                                <select id="motorista_id" name="motorista_id" class="select2" required>
                                    <option value="">Selecione</option>
                                    @foreach ($drivers as $drive)
                                        <option
                                                {{ old('motorista_id') == $drive->id ? 'selected' : '' }} required value="{{ $drive->id }}">
                                            {{ $drive->re }} - {{ $drive->name }}

                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="images">Fotos</label>
                                <input id="images" type="file" class="form-control-file" name="attachments[]" multiple accept='image/*'>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3 d-flex justify-content-between">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input
                                               id="typeOption" {{ old('type') == 'saida' ? 'checked' : '' }} type="radio" name="type" value="saida"
                                               checked="checked">
                                    </div>
                                </div>
                                <span class="form-control">Saida</span>
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input
                                               id="typeOption" {{ old('type') == 'retorno' ? 'checked' : '' }} type="radio" name="type"
                                               value="retorno">
                                    </div>
                                </div>
                                <span class="form-control">Retorno</span>
                            </div>
                        </div>


                        <div class="col-md-12 mt-5 mb-4">
                            <label for="" class="">Departamento</label>
                            <div class="row" style="    gap: 1rem;">
                                @foreach (config('admin.departamentos_veiculos') as $depVeic)
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input id="" {{ old('departamento') == $depVeic ? 'checked' : '' }} class="form-check-input"
                                                   type="radio" name="departamento" value="{{ $depVeic }}" required />
                                            <label class="form-check-label" for=""> {{ $depVeic }} </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="form-group">
                                <label for="observations">Observações</label>
                                <textarea id="observations" name="observations" cols="30" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div id="div--button-submit" class="row justify-content-center mt-2">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>

                </form>


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
        const dataHora = zeroFill(now.getUTCDate()) + '/' + zeroFill((now.getMonth() + 1)) + '/' + now.getFullYear() + ' ' + zeroFill(now.getHours()) + ':' +
            zeroFill(now.getMinutes()) + ':' +
            zeroFill(now.getSeconds());
        $('.time').html(dataHora)
    }
</script>

</html>
