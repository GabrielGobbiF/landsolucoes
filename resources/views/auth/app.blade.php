<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title', config('app.name', ''))</title>

    <meta name="description" content="{{ config('app.description', '') }}">
    <meta name="image" content="{{ asset('panel/images/logo-sm.png') }}">
    <meta name="author" content="Gabriel Gobbi">

    <link rel="canonical" href="{{ env('APP_URL') }}" data-baseprotocol="https:" data-basehost="site.com.br">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="MobileOptimized" content="320">
    <meta name="HandheldFriendly" content="True">
    <meta name="theme-color" content="#8257e5">
    <meta name="referrer" content="no-referrer-when-downgrade">
    <meta name="msapplication-TileColor" content="#8257e5">
    <meta name="google" content="notranslate">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ config('app.name', '') }}">
    <meta property="og:description" content="{{ config('app.description', '') }}">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="{{ config('app.name', '') }}">

    <meta property="og:image" content="{{ env('APP_URL') }}">
    <meta property="og:image:secure_url" content="{{ asset('panel/images/logo-sm.png') }}">
    <meta property="og:image:alt" content="Boost yourself">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('app.name', '') }}">
    <meta name="twitter:site" content="@gabrielvgobbi">
    <meta name="twitter:creator" content="@gabrielvgobbi">
    <meta name="twitter:image" content="{{ asset('panel/images/logo-sm.png') }}">
    <meta name="twitter:image:src" content="{{ asset('panel/images/logo-sm.png') }}">
    <meta name="twitter:image:alt" content="Boost yourself">
    <meta name="twitter:image:width" content="1200">
    <meta name="twitter:image:height" content="630">

    <!-- CSS -->
    <link href="{{ asset('panel/css/bootstrap.css') }}" rel='stylesheet'>
    <link href="{{ asset('web/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/icons/icons.min.css') }}" rel="stylesheet">

    <script src="{{ asset('panel/js/bootstrap.js') }}"></script>

</head>

<body>
    <div class="container">

        @yield('content')

    </div>
</body>

<script src="{{ asset('panel/js/lib/functions.js') }}"></script>

@yield('scripts')

</html>
