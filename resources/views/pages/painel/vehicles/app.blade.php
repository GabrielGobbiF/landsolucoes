<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Veiculos Land</title>

    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}" sync></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    <link href="{{ asset('css/painel/css/app.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">


    <script>
        var BASE = `{{ env('APP_URL') }}`;

    </script>
    <script src="{{ asset('js/app.js') }}"></script>

    <style class="">
        @media only screen and (max-width: 900px) {
            .mobile--hidden {
                display: none;
            }

            .title_table--mensal {
                text-align: center
            }
        }

        .bootstrap-table {
            width: 100%;
        }

        .table-borderless {
            border: 0px;
        }

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
        @if (Auth::check())
            <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        Veiculos Land
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link nav-header" id="funcionarios" href="{{ route('vehicles.index') }}">Veiculos</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link nav-header" href="{{ route('vehicles.drivers') }}">Motoristas</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link nav-header" href="{{ route('vehicles.portaria') }}">Portaria</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link nav-header" href="#">Relátorio</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        @endif
        <main class="py-4">
            @yield('content')
        </main>
        @include('pages.layouts.modal_delete')
    </div>
</body>

<script>
    @include('pages.layouts.notification')

    function btn_delete(v) {
        var href = $(v).attr('data-href');
        var title = $(v).attr('data-title');
        var text = $(v).attr('data-original-title');
        if (text != null && title != null) {
            $('.modal-title').html(title);
            $('#modal-confirm').html(text);
            $('.modal-text-body').html('Tem certeza que deseja ' + text + '?');
        }
        $('#form-modal-action').attr('action', href)
        $('#modal-delete').modal('show');
    }

</script>

</html>
