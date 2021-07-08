<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link href="{{ asset('panel/css/bootstrap.css') }}" rel="stylesheet" id="bootstrap-style">
    <link href="{{ asset('panel/css/app.css') }}" rel="stylesheet" id="app-style">
    <link href="{{ asset('panel/icons/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/icons/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">

    <script src="{{ asset('panel/js/bootstrap.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />


    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <script>
        var BASE_URL = `{{ env('APP_URL') }}`;
        var BASE_URL_API = `{{ env('APP_URL_API') }}`;
    </script>

</head>

<body data-sidebar="dark" data-topbar="dark" data-layout="{{ Config::get('admin.dataLayout') }}">
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="container pd-0">
                <!-- todoFazer  -->
                <div class="navbar-header-mudar" style="display: flex;
                justify-content: space-between;
                align-items: center;
                height: 70px;">
                    <div class="d-flex">
                        <div class="navbar-brand-box">
                            <a href="{{ url('/') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ asset('panel/images/logo.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('panel/images/logo.png') }}" alt="" height="20">
                                </span>
                            </a>
                            <a href="{{ url('/') }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ asset('panel/images/logo.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('panel/images/logo.png') }}" alt="" height="30">
                                </span>
                            </a>
                        </div>
                        <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item collapsed" data-toggle="collapse" data-target="#topnav-menu-content" aria-expanded="false">
                            <i class="ri-menu-2-line align-middle"></i>
                        </button>
                        @if (Request::segment(3) != '')
                            <a href="{{ route(Request::segment(2) . '.index') }}" class="btn btn-sm px-3 font-size-24 d-lg-none header-item d-flex align-items-center">
                                <i class="ri-arrow-left-line align-middle align-self-center"></i>
                            </a>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-white mobile--hidden">@yield('title', config('app.name', 'Cena'))</h4>
                    </div>
                    <div class="d-flex">
                        <div class="dropdown d-none ml-2">
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

                        @include('pages.painel._partials.notifications')

                        <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @include('pages.painel._partials.avatar', [
                                'avatar' => '',
                                'name' => Auth::user()->name,
                                ])
                            </button>
                            <div class="d-none dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="ri-user-line align-middle mr-1"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="ri-wallet-2-line align-middle mr-1"></i> My Wallet</a>
                                <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-right mt-1">11</span><i class="ri-settings-2-line align-middle mr-1"></i> Settings</a>
                                <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle mr-1"></i> Lock screen</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#"><i class="ri-shut-down-line align-middle mr-1 text-danger"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>

        <x-package-menus />

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

    <script src="{{ asset('panel/js/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('panel/js/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('panel/js/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('panel/js/app.js') }}"></script>
    <script src="{{ asset('panel/js/functions.js') }}"></script>
    <script src="{{ asset('panel/js/lib.js') }}"></script>
    <script src="{{ asset('panel/js/bootstrap-table.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <script>
        @include('pages.layouts.notification')
    </script>

    <script class="">
        $(document).ready(function() {
            $(".select--users").select2({
                multiple: true,
                placeholder: "Buscar",
                minimumInputLength: 3,
                language: "pt-br",
                formatNoMatches: function() {
                    return "Pesquisa não encontrada";
                },
                inputTooShort: function() {
                    return "Digite para Pesquisar";
                },
                ajax: {
                    url: `{{ route('users.all') }}`,
                    dataType: 'json',
                    data: function(term, page) {
                        return {
                            q: term, //search term
                        };
                    },
                    results: function(data, page) {
                        return {
                            results: data.data,
                        };
                    }
                },
                escapeMarkup: function(m) {
                    return m;
                }
            });
        })
    </script>

    @include('pages.layouts.modal_delete')

    @yield('scripts')

</body>

</html>
