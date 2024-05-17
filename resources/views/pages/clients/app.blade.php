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

</head>

<body data-topbar="dark" data-layout="horizontal">
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="container pd-0">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box d-none">
                            <a href="{{ url('/clientes/obras') }}" class="logo">
                                <span class="logo">
                                    <img src="{{ asset('panel/images/logo.png') }}" alt="img-logo" height="35">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect btn-sidebar" id="vertical-menu-btn">
                            <i class="ri-menu-2-line align-middle"></i>
                        </button>
                    </div>

                    <div class="d-flex">
                        <div>
                            <h4 class="text-white mobile--hidden">@yield("title", "")</h4>
                        </div>
                    </div>

                    <div class="d-flex">
                        @if (auth()->guard('clients')->check())
                            <div class="dropdown d-inline-block user-dropdown">
                                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @include("pages.painel._partials.avatar", [
                                    "avatar" => auth()->guard('clients')->user()->avatar,
                                    "name" => auth()->guard('clients')->user()->username,
                                    ])
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
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

        <div class="topnav">
            <div class="container">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('clients.obras') }}">
                                    <i class="fas fa-building mr-2"></i>
                                    <span style="vertical-align: top;">Obras</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>


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

    @yield("scripts")

</body>

</html>
