<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="js-base_url" content="{{ env('APP_URL') }}">
    <meta name="js-base_url_api" content="{{ env('APP_URL_API') }}">
    <meta name="url" content="{{ Request::getRequestUri() }}">

    <title>@yield("title", config("app.name", "Laravel"))</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link href="{{ asset('panel/css/bootstrap.css') }}" rel="stylesheet" id="bootstrap-style">
    <link href="{{ asset('panel/css/app.css') }}" rel="stylesheet" id="app-style">
    <link href="{{ asset('panel/icons/icons.min.css') }}" rel="stylesheet">

    <script src="{{ asset('panel/js/bootstrap.js') }}"></script>

    <script>
        const base_url = $('meta[name="js-base_url"]').attr('content');
        const base_url_api = $('meta[name="js-base_url_api"]').attr('content');
        const url = $('meta[name="url"]').attr('content');
    </script>

    <!-- todoFazer  -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <style>
        .form-group-money input {
            border-top: 1px solid #ced4da;
            border-bottom: 1px solid #ced4da;
            border-right: 1px solid #ced4da;
            border-left: none;
        }

        .input-group-text-cifr {
            padding: 0.5rem 0.47rem 0px 0.5rem;
            color: #505d69;
            border-top: 1px solid #ced4da;
            border-bottom: 1px solid #ced4da;
            border-left: 1px solid #ced4da;
            border-right: none;
            border-radius: 0.25rem 0 0 0.25rem;
        }

        .form-control-money {
            padding: 0px !important;
        }

        @media screen and (max-width: 600px) {
            .mobile--hidden {
                visibility: hidden;
                display: none;
            }
        }

    </style>

</head>

<body data-topbar="dark" data-layout="horizontal">
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="container pd-0">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box d-none">
                            <a href="{{ url('/') }}" class="logo">
                                <span class="logo">
                                    <img src="{{ asset('panel/images/logo.png') }}" alt="img-logo" height="35">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item btn-topnav" data-toggle="collapse" data-target="#topnav-menu-content">
                            <i class="ri-menu-2-line align-middle"></i>
                        </button>
                    </div>

                    <div class="d-flex mobile--hidden">
                        <div>
                            <h4 class="text-white mobile--hidden">@yield("title", "")</h4>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="dropdown d-inline-block d-lg-none ml-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-search-line"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                                aria-labelledby="page-header-search-dropdown">
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Buscar ...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <x-notification />

                        @if (auth()->check())
                            <div class="dropdown d-inline-block user-dropdown">
                                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @include("pages.painel._partials.avatar", [
                                    "avatar" => auth()->user()->avatar,
                                    "name" => auth()->user()->name,
                                    ])
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fas fa-user mr-1"></i> Perfil</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Sair
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </a>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </header>

        <x-menus />

        <!-- ============================================================== -->
        <!-- Start Content -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                @if (View::hasSection('content'))
                    <div class="container">
                        <div class="page-title-box d-none">
                            @section('sidebar') @show
                        </div>
                        @yield('content')
                    </div>
                @else
                    <div class="container-max-fluid">
                        @yield('content-max-fluid')
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('panel/js/all.js') }}"></script>
    <script src="{{ asset('panel/js/app.js') }}"></script>
    <script src="{{ asset('panel/js/lib/functions.js') }}"></script>

    @include('pages.painel._partials.modals.modal-search-global')

    <!-- todoFazer  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    @yield("scripts")

    <script>
        @include("components.toastr")


        $(document).ready(function() {

            $('select').on('select2:open', (event) => {
                if (!event.target.multiple) {
                    $('.select2-container--open .select2-search--dropdown .select2-search__field').last()[0].focus()
                }
            });

            let countClique = 0;

            function clicou() {
                countClique = 0
            }
            $(document).on('keyup', function(e) {
                e.preventDefault();
                if (e.wich == 17 || e.keyCode == 17) {
                    countClique++
                }
                if (countClique == 4) {
                    countClique = 0;
                    $('#modal-pesquisa__global').modal('show');
                }
            })
            setInterval(function() {
                clicou()
            }, 2000);
            setInterval(function() {
                countClique = 0
            }, 5000);
        })
    </script>

</body>

</html>
