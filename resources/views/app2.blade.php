<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('panel/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/adminlte/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/adminlte/dist/css/skins/skin-blue.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/adminlte/dist/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/adminlte/dist/css/helpers.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/icons/icons.min.css') }}">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">

    <script src="{{ asset('panel/js/bootstrap.js') }}"></script>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <nav class="navbar navbar-static-top pd-4">
                <div class="container">
                    <div class="navbar-header">
                        <a href="#" class="navbar-brand"><b>Admin</b>LTE</a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <x-package-menus />
                    </div>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown1">
                                    <img src="{{ asset('panel/adminlte/dist/img/user2-160x160.jpg') }}" class="user-image d-none" alt="User Image">
                                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-default btn-flat">Sair</a>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <div class="content-wrapper">
            <div class="container">
                <section class="content-header mg-y-15">
                    <h1>
                        @yield('title', '')
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Layout</a></li>
                        <li class="active">Top Navigation</li>
                    </ol>
                </section>

                <section class="content">

                    @yield('content')

                </section>
            </div>
        </div>

        <footer class="main-footer">
            <div class="container">
                <div class="pull-right hidden-xs">
                    <b>Versão</b> 0.0.1
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('panel/js/app.js') }}"></script>
    <script src="{{ asset('panel/js/functions.js') }}"></script>
    <script src="{{ asset('panel/js/lib.js') }}"></script>

    <script>
        @include('pages.layouts.notification')

    </script>

    @include('pages.layouts.modal_delete')

    @yield('scripts')

</body>

</html>
