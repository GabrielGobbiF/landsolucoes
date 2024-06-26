<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CENA</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('panel/icons/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons/typicons.css') }}" rel="stylesheet">


    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0;
            background-color: #1a202c;
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5;
            color: #fff;
        }

        a {
            text-decoration: none;
            color: #fff !important;
        }

        *,
        :after,
        :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        svg,
        video {
            display: block;
            vertical-align: middle
        }

        video {
            max-width: 100%;
            height: auto
        }

        .grid_itens {
            font-size: 1rem;
            margin: 2.5rem;
            text-align: initial;
        }

        .bg-white {
            --bg-opacity: 1;
            background-color: #fff;
            background-color: rgba(255, 255, 255, var(--bg-opacity))
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity))
        }

        .border-gray-200 {
            --border-opacity: 1;
            border-color: #edf2f7;
            border-color: rgba(237, 242, 247, var(--border-opacity))
        }

        .border-t {
            border-top-width: 1px
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .font-semibold {
            font-weight: 600
        }

        .h-5 {
            height: 1.25rem
        }

        .h-8 {
            height: 2rem
        }

        .h-16 {
            height: 4rem
        }

        .text-sm {
            font-size: .875rem
        }

        .text-lg {
            font-size: 1.125rem
        }

        .leading-7 {
            line-height: 1.75rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .ml-1 {
            margin-left: .25rem
        }

        .mt-2 {
            margin-top: .5rem
        }

        .mr-2 {
            margin-right: .5rem
        }

        .ml-2 {
            margin-left: .5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .ml-12 {
            margin-left: 3rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .max-w-6xl {
            max-width: 72rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .overflow-hidden {
            overflow: hidden
        }

        .p-6 {
            padding: 1.5rem;
            display: flex;
            justify-content: flex;
            align-items: center;
            align-self: center;
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .pt-8 {
            padding-top: 2rem
        }

        .fixed {
            position: fixed
        }

        .relative {
            position: relative
        }

        .top-0 {
            top: 0
        }

        .right-0 {
            right: 0
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)
        }

        .text-center {
            text-align: center
        }

        .text-gray-200 {
            --text-opacity: 1;
            color: #edf2f7;
            color: rgba(237, 242, 247, var(--text-opacity))
        }

        .text-gray-300 {
            --text-opacity: 1;
            color: #e2e8f0;
            color: rgba(226, 232, 240, var(--text-opacity))
        }

        .text-gray-400 {
            --text-opacity: 1;
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--text-opacity))
        }

        .text-gray-500 {
            --text-opacity: 1;
            color: #a0aec0;
            color: rgba(160, 174, 192, var(--text-opacity))
        }

        .text-gray-600 {
            --text-opacity: 1;
            color: #718096;
            color: rgba(113, 128, 150, var(--text-opacity))
        }

        .text-gray-700 {
            --text-opacity: 1;
            color: #4a5568;
            color: rgba(74, 85, 104, var(--text-opacity))
        }

        .text-gray-900 {
            --text-opacity: 1;
            color: #fff;
            color: rgba(26, 32, 44, var(--text-opacity))
        }



        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .w-5 {
            width: 1.25rem
        }

        .w-8 {
            width: 2rem
        }

        .w-auto {
            width: auto
        }

        i {
            font-size: 1.87rem;
            color: #e2e8f0;

        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        @media (min-width:640px) {
            .sm\:rounded-lg {
                border-radius: .5rem
            }

            .sm\:block {
                display: block
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:h-20 {
                height: 5rem
            }

            .sm\:ml-0 {
                margin-left: 0
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width:768px) {
            .md\:border-t-0 {
                border-top-width: 0
            }

            .md\:border-l {
                border-left-width: 1px
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(3, minmax(0, 1fr))
            }
        }

        @media (min-width:1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme:dark) {
            .dark\:bg-gray-800 {
                --bg-opacity: 1;
                background-color: #2d3748;
            }

            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #1a202c;
            }

            .dark\:border-gray-700 {
                --border-opacity: 1;
                border-color: #4a5568;
            }

            .dark\:text-white {
                --text-opacity: 1;
                color: #fff;
            }

            .dark\:text-gray-400 {
                --text-opacity: 1;
                color: #cbd5e0;
            }
        }
    </style>

    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>

<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen sm:items-center sm:pt-0">

        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <a class="text-sm text-gray-200 underline" href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    {{ __('Sair') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endauth
        </div>

        <div class="max-w-12xl mx-auto sm:px-12 lg:px-8">
            <div class="mt-8 overflow-hidden text-center">
                <div class="grid grid-cols-1 md:grid-cols-2">

                    @if (auth()->user()->hasRole('frotas') || auth()->user()->hasRole('admin'))
                        <div class="grid_itens">
                            <a href="{{ route('vehicles.index') }}" class="underline text-gray-900 ">
                                <i class="fas fa-truck mr-2"></i>
                                Frotas
                            </a>
                        </div>
                    @endif

                    @if (auth()->user()->hasRole('admin'))
                        <div class="grid_itens">
                            <a href="{{ route('users.index') }}" class="underline text-gray-900 ">
                                <i class="fas fa-users mr-2"></i>
                                Usuários
                            </a>
                        </div>
                    @endif

                    @if (auth()->user()->hasRole('builds') || auth()->user()->hasRole('admin'))
                        <div class="grid_itens">
                            <a href="{{ route('obras.index') }}" class="underline text-gray-900 ">
                                <i class="fas fa-city mr-2"></i>
                                Obras
                            </a>
                        </div>
                    @endif

                    @if (auth()->user()->hasRole('portaria') || auth()->user()->hasRole('admin'))
                        <div class="grid_itens">
                            <a href="{{ route('vehicles.portaria.register') }}" class="underline text-gray-900 ">
                                <i class="fas fa-door-open mr-2"></i>
                                Controle de Acesso
                            </a>
                        </div>
                    @endif

                    @if (auth()->user()->hasRole('vehicles') || auth()->user()->hasRole('admin'))
                        <div class="grid_itens">
                            <a href="{{ route('vehicles.index') }}" class="underline text-gray-900 ">
                                <i class="fas fa-truck mr-2"></i>
                                Veiculos
                            </a>
                        </div>
                    @endif

                    @if (auth()->user()->hasRole('financer') || auth()->user()->hasRole('admin'))
                        <div class="grid_itens">
                            <a href="{{ route('finances.index') }}" class="underline text-gray-900 ">
                                <i class="fas fa-wallet mr-2"></i>
                                Financeiro
                            </a>
                        </div>
                    @endif

                    @if (auth()->user()->hasRole('rh') || auth()->user()->hasRole('admin'))
                        <div class="grid_itens">
                            <a href="{{ route('employees.index') }}" class="underline text-gray-900 ">
                                <i class="fas fa-file-signature mr-2"></i>
                                RH
                            </a>
                        </div>
                    @endif

                    @if (auth()->user()->hasRole('admin'))
                        <div class="grid_itens">
                            <a href="{{ route('celulares.index') }}" class="underline text-gray-900 ">
                                <i class="fas fa-mobile-alt mr-2"></i>
                                Celulares
                            </a>
                        </div>
                    @endif


                    {{-- @if (auth()->user()->hasRole('rh') || auth()->user()->hasRole('admin'))
                        <div class="grid_itens">
                            <a href="{{ route('fornecedor.index') }}" class="underline text-gray-900 ">
                                <i class="fas fa-wallet mr-2"></i>
                                Compras
                            </a>
                        </div>
                    @endif --}}

                    @if (auth()->user()->hasRole('rdse') || auth()->user()->hasRole('admin'))
                        <div class="grid_itens">
                            <a href="{{ route('rdse.index') }}" class="underline text-gray-900 ">
                                <i class="fas fa-file-invoice mr-2"></i>
                                RDSE
                            </a>
                        </div>
                    @endif


                    <div class="grid_itens">
                        <a href="#" class="underline text-gray-900 ">
                            <i class="fas fa-user-lock mr-2"></i>
                            Segurança do Trabalho
                        </a>
                    </div>

                    <div class="grid_itens">
                        <a href="#" class="underline text-gray-900 ">
                            <i class="fas fa-recycle mr-2"></i>
                            Meio Ambiente
                        </a>
                    </div>

                    @if (auth()->user()->hasRole('etds') || auth()->user()->hasRole('admin'))
                        <div class="grid_itens">
                            <a href="{{ route('etd.index') }}" class="underline text-gray-900 ">
                                <i class="fas fa-file-invoice mr-2"></i>
                                ETD's
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</body>

</html>
