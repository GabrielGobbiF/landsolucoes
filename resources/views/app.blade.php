<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="js-base_url" content="{{ config('app.url') }}">
    <meta name="js-base_url_api" content="{{ config('app.url') . '/v1/api/' }}">
    <meta name="url" content="{{ str_replace([Request::getQueryString(), '?'], '', Request::getPathInfo()) }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link id="bootstrap-style" href="{{ _mix('panel/css/bootstrap.css') }}" rel="stylesheet">
    <link id="app-style" href="{{ _mix('panel/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/icons/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/css/notifications-toast.css') }}" rel="stylesheet">

    <script src="{{ _mix('panel/js/bootstrap.js') }}"></script>

    <script>
        const base_url = $('meta[name="js-base_url"]').attr('content');
        const base_url_api = $('meta[name="js-base_url_api"]').attr('content');
        const url = $('meta[name="url"]').attr('content');
    </script>

    <!-- todoFazer  -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://unpkg.com/jquery-datetimepicker"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

        @media print {

            .fixed-table-toolbar,
            .fixed-table-pagination,
            .no-print {
                display: none !important;
            }

            .fixed-table-body {
                overflow: hidden !important;
                overscroll-behavior: none !important;
            }
        }

        @media (min-width: 1200px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl {
                max-width: 1300px !important;
            }
        }
    </style>

</head>

<body data-topbar="dark" data-layout="horizontal" class="">
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

                        <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item btn-topnav no-print" data-toggle="collapse"
                                data-target="#topnav-menu-content">
                            <i class="ri-menu-2-line align-middle"></i>
                        </button>
                    </div>

                    <div class="d-flex mobile--hidden ">
                        <div>
                            <h4 class="text-white mobile--hidden">@yield('title', '')</h4>
                        </div>
                    </div>



                    <div class="d-flex no-print">

                        <div class="dropdown d-inline-block no-print">
                            <button id="page-header-menu-dropdown" type="button" class="btn header-item  waves-effect" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                Atalhos
                                <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" style="width: 481px"
                                 aria-labelledby="page-header-menu-dropdown">
                                <div class="row p-4">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="font-size-22 tx-bold">Arquivos</h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <a href="{{ route('arquivos.index') }}">Todos</a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('arquivos.my.favorites') }}">Favoritos</a>
                                                    </li>

                                                </ul>
                                            </div>

                                            <div class="col-md-6">
                                                <h5 class="font-size-22 tx-bold">Obras</h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <a href="{{ route('obras.index') }}">Todas</a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('clients.index') }}">Clientes</a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('finances.index') }}">Financeiro</a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('services.index') }}">Serviço</a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="col-md-4">
                                                <h5 class="font-size-22 tx-bold">Frotas</h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <a href="{{ route('visitors.index') }}">Novo Visitante</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('vehicles.portaria.visitors.create') }}">Controle de Acesso</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('vehicles.create') }}">Novo Veiculo</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('drivers.index') }}">Novo Motorista</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <x-notification />

                        @if (auth()->check())
                            <div class="dropdown d-inline-block user-dropdown no-print">
                                <button id="page-header-user-dropdown" type="button" class="btn header-item waves-effect" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    @include('pages.painel._partials.avatar', [
                                        'avatar' => auth()->user()->avatar,
                                        'name' => auth()->user()->name,
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

                        <div class="dropdown d-inline-block no-print">
                            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                                <i class="ri-settings-2-line"></i>
                            </button>
                        </div>
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
                    <div class="container-fluid">
                        @yield('content-max-fluid')
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title px-3 py-4">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
                <h5 class="m-0">Configurações</h5>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />

            <div class="p-4">
                <div class="custom-control custom-switch mb-3">
                    <input id="light-mode-switch" type="checkbox" class="custom-control-input theme-choice" checked />
                    <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="custom-control custom-switch mb-3">
                    <input id="dark-mode-switch" type="checkbox" class="custom-control-input theme-choice" data-bsStyle="assets/css/bootstrap-dark.min.css"
                           data-appStyle="assets/css/app-dark.min.css" />
                    <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <hr class="mt-1" />

                <h6 class="text-muted mb-3">Notificações</h6>

                <div class="custom-control custom-switch mb-3">
                    <input id="browser-notification-switch" type="checkbox" class="custom-control-input " />
                    <label class="custom-control-label" for="browser-notification-switch">Notificações do navegador</label>
                </div>


                <small class="text-muted d-block mb-2">Receba notificações mesmo quando não estiver com o sistema aberto.</small>

                <div class="notification-btn-group mt-2 mb-3">
                    <button id="enable-notification-btn" class="btn btn-sm btn-success mr-2">
                        Ativar notificações
                    </button>
                    <button id="disable-notification-btn" class="btn btn-sm btn-light border">
                        Desativar
                    </button>
                </div>

                <button id="test-notification-btn" class="btn btn-sm btn-light border">
                    Testar notificação
                </button>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const notificationSwitch = document.getElementById('browser-notification-switch');
                        const enableBtn = document.getElementById('enable-notification-btn');
                        const disableBtn = document.getElementById('disable-notification-btn');
                        const storageKey = 'browser_notifications_enabled';

                        // Função para atualizar a UI baseado no status das notificações
                        function updateNotificationUI() {
                            const savedPreference = localStorage.getItem(storageKey);
                            const isEnabled = (savedPreference === 'granted' && Notification.permission === 'granted');

                            // Atualiza o switch
                            if (notificationSwitch) {
                                notificationSwitch.checked = isEnabled;
                            }

                            // Atualiza os botões
                            if (enableBtn && disableBtn) {
                                enableBtn.disabled = isEnabled;
                                disableBtn.disabled = !isEnabled;
                            }
                        }

                        // Configura os botões de ativar/desativar
                        if (enableBtn) {
                            enableBtn.addEventListener('click', function() {
                                if (Notification.permission !== 'granted') {
                                    Notification.requestPermission().then(permission => {
                                        if (permission === 'granted') {
                                            localStorage.setItem(storageKey, 'granted');
                                            updateNotificationUI();

                                            // Mostra notificação de teste
                                            const notification = new Notification('Notificações ativadas!', {
                                                body: 'Você receberá notificações mesmo quando não estiver com o sistema aberto.',
                                                icon: `${base_url}/favicon.ico`
                                            });
                                        }
                                    });
                                } else {
                                    localStorage.setItem(storageKey, 'granted');
                                    updateNotificationUI();
                                }
                            });
                        }

                        if (disableBtn) {
                            disableBtn.addEventListener('click', function() {
                                localStorage.setItem(storageKey, 'denied');
                                updateNotificationUI();
                            });
                        }

                        $("#browser-notification-switch").on("click", function(e) {
                            alert('ipo');
                            $("#browser-notification-switch").prop("checked", true);

                        });

                        // Inicializa o estado da UI
                        updateNotificationUI();
                    });
                </script>

            </div>

        </div>
    </div>

    <x-file-upload />

    <div class="rightbar-overlay"></div>

    <!-- Componente de Notificações Toast -->
    @include('components.notifications-toast')

    <script src="{{ _mix('panel/js/all.js') }}"></script>
    <script src="{{ _mix('panel/js/app.js') }}"></script>
    <script src="{{ asset('panel/js/lib/select2/select2.js') }}"></script>
    <script src="{{ asset('panel/js/lib/functions.js') }}"></script>
    <script src="{{ asset('panel/js/notifications-toast.js') }}"></script>
    {{--
    <script src="https://cdn.tiny.cloud/1/rxt6gu66oa6gavl0hljt0k37ibd9qw3l0fev1vtpsexwx573/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
            --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    @include('pages.painel._partials.modals.modal-search-global')

    <!-- todoFazer  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    @yield('scripts')

    @yield('components-scripts')

    <script>
        @include('components.toastr')

        $(document).ready(function() {

            $('select').on('select2:open', (event) => {
                if (!event.target.multiple) {
                    $('.select2-container--open .select2-search--dropdown .select2-search__field').last()[0]
                        .focus()
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

            const addModalConfirmInTheDom = btn => {
                let token = document.querySelector('meta[name="csrf-token"]').content;
                let route = btn.dataset.route;
                let text = btn.dataset.text || 'Deletar';
                let action = btn.dataset.action || 'POST';
                let btnClass = btn.dataset.btnClass || btn.getAttribute('class');

                let htmlModalEl = `
                    <div class="modal fade effect-scale" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content">
                                <form id="form-confirm" role="form" class="needs-validation" action="${route}" method="POST">
                                    <div class="modal-header">
                                        <h6 class="modal-title"></h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <span class="mg-b-0 modal-text-body"></span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <input type="hidden" name="_token" value="${token}">
                                        <input type="hidden" name="_method" value="${action}">
                                        <button type="submit" data-btn-text="" class="btn-modal ${btnClass}">
                                            ${text}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>`
                document.body.insertAdjacentHTML('beforeend', htmlModalEl);

                //let actionModalEl = new bootstrap.Modal(document.querySelector('#modal-delete'))
                let modalEl = $('#modal-delete');

                $('.modal-title').html(text);
                $('.modal-text-body').html(`Tem certeza que deseja ${text}?`);
                modalEl.modal('show');
                modalEl.addEventListener('hidden.bs.modal', function(event) {
                    modalEl.remove();
                })
            }

            window.btn_delete = (v) => {

                addModalConfirmInTheDom(v);

                //var href = $(v).attr('data-href');
                //console.log(href);
                //var title = $(v).attr('data-title');
                //var text = $(v).attr('data-original-title');
                //if (text != null && title != null) {
                //    $('.modal-title').html(title);
                //    $('#modal-confirm').html(text);
                //    $('.modal-text-body').html('Tem certeza que deseja ' + text + '?');
                //}
                //$('#form-modal-action').attr('action', href)
                //$('#modal-delete').modal('show');
            }

        })

        function checkAndClearCache() {
            axios.get(`${base_url}/api/check-reset-cache`)
                .then(response => {
                    const {
                        reset_cache
                    } = response.data;

                    if (reset_cache) {
                        clearBrowserCache();
                        disableResetCache();
                    }
                })
                .catch(error => {
                    console.error('Erro ao verificar o reset_cache:', error);
                });
        }

        function clearBrowserCache() {
            const links = document.querySelectorAll('link[rel="stylesheet"]');
            links.forEach(link => {
                const href = link.getAttribute('href');
                if (href) {
                    const newHref = href.split('?')[0] + '?v=' + new Date().getTime(); // Força o recarregamento adicionando um timestamp
                    link.setAttribute('href', newHref);
                }
            });

            // Limpar todos os cookies
            document.cookie.split(';').forEach(cookie => {
                const eqPos = cookie.indexOf('=');
                const name = eqPos > -1 ? cookie.substring(0, eqPos) : cookie;
                document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/';
            });

            // Marca no localStorage que a ação foi realizada
            localStorage.setItem('hasReloaded', 'true');

            // Recarregar a página (Ctrl + F5 simulado)
            location.reload(true); // Força um reload total
        }

        function disableResetCache() {
            axios.post(`${base_url}/api/disable-reset-cache`)
                .then(() => {
                    console.log('reset_cache desativado para o usuário:', userId);
                })
                .catch(error => {
                    console.error('Erro ao desativar reset_cache:', error);
                });
        }


        // Verifica periodicamente o cache para o usuário logado
        //setInterval(() => {
        checkAndClearCache();
        //}, 60000); // Verifica a cada 60 segundos
    </script>

</body>

</html>
