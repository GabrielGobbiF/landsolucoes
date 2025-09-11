
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta ref="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta ref="csrf-token" content="{{ csrf_token() }}">
    <meta ref="js-base_url" content="{{ env('APP_URL') }}">
    <meta ref="js-base_url_api" content="{{ env('APP_URL_API') }}">
    <meta ref="url" content="{{ str_replace([Request::getQueryString(), '?'], '', Request::getPathInfo()) }}">
    <meta ref="csrf-token" content="{{ csrf_token() }}">


    <title>Veiculos Land</title>

    <link href="{{ asset('mobile/css/app.css') }}" rel="stylesheet">

    <script>
        var BASE = `{{ env('APP_URL') }}`;
    </script>

    <script src="{{ asset('mobile/js/app.js') }}"></script>

    <style>
        body {
            font-size: 1.1rem !important;
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

        .card.active {
            border: 1px solid red !important;
        }

        .card {
            cursor: pointer;
        }

        table {
            font-size: 0.9rem !important;
        }
    </style>


    <script src="{{ asset('panel/js/bootstrap.js') }}"></script>
    <script>
        window.base_url_api = document.querySelector('meta[ref="js-base_url_api"]').content
        window.base_url = document.querySelector('meta[ref="js-base_url"]').content
        window.i_url = document.querySelector('meta[ref="url"]').content
    </script>

</head>

<body>
    <div id="app" class="container">

        <div class="row">

            <div class="col-12 col-md-12">
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

                @yield('content')
            </div>


            <div class="col-12 col-md-12">

                <div class="row">

                    <div class="col-12 mt-5">
                        <main role="main">
                            <div class="card">
                                <div class="card-header">Visitas de Hoje</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class='form-group'>
                                                <label>Buscar</label>
                                                <input name="search" type="text" class="form-control" data-search-table="visitors"
                                                       value="{{ request()->input('search') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div data-table="visitors" class="table-responsive table">
                                        <table class="table d-none">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Documento</th>
                                                    <th>Veiculo</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <nav id="pagination"></nav>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>


                    <div class="col-12">
                        <div class="table-responsive mt-4" data-simplebar style="max-height: 500px">
                            <div class="header">
                                <h4>Registros de hoje</h4>
                            </div>
                            <table class='table table-hover'>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Motorista</th>
                                        <th>Veiculo</th>
                                        <th>Data</th>
                                        <th>Tipo</th>
                                        <th>RMS</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($portarias as $portaria)
                                        <tr>
                                            <td>{{ $portaria['id'] }}</td>
                                            <td>{{ $portaria['motorista'] }}</td>
                                            <td>{{ $portaria['veiculo'] }}</td>
                                            <td>{{ $portaria['data'] }}</td>
                                            <td>{{ $portaria['type'] == 'retorno' ? 'entrada' : 'saida' }}</td>
                                            <td>{{ $portaria['rms'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</body>

<script src="{{ asset('panel/js/all.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

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

<script>
    const tableId = 'visitors';
    const $table = document.querySelector(`[data-table="${tableId}"]`);
    const tableTbody = $table.querySelector('tbody');
    const inputSearchs = document.querySelectorAll(`[data-search-table="${tableId}"]`);
    let page = 1;

    /**
     * Debounce
     */
    function debounce(fn, delay) {
        var timer = null;
        return function() {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                fn.apply(context, args);
            }, delay);
        };
    }

    const init = async () => {
        $table.querySelector('table').classList.add('d-none');
        tableTbody.innerHTML = '';
        $table.insertAdjacentHTML('afterend', preload());
        setListInDom();
    }

    const setListInDom = async () => {
        const list = await getVisitors();

        tableTbody.innerHTML += list.data.map((data) => `
            <tr data-id="${data.id}">
                <td>${data.name}</td>
                <td>${data.document}</td>
                <td>${data.vehicle}</td>
                <td data-js="status_label">${data.status_label}</td>
                <td>
                    <div class="dropdown">
                        <a type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i data-feather="more-vertical"></i>
                        </a>
                        <ul class="dropdown-menu">
                          ${gerarItensMenuDropdown(data)}
                        </ul>
                    </div>
                </td>
            </tr>`).join(' ')

        feather.replace();

        $table.querySelector('table').classList.remove('d-none');
        if (document.querySelector(`#preloader-content`)) {
            document.querySelector(`#preloader-content`).remove();
        }
        initButtons();
    }

    function gerarItensMenuDropdown(data) {
        const id = data.id;
        const optionsData = data.optionsToChange.map((({
            name,
            trans,
            value
        }) => `<li><a class="dropdown-item" data-js-id="${id}" data-value="${value}" onclick="updateStatusVisitor(this)">${trans}</a></li>`)).join('')

        return optionsData; // Retorna a string contendo o HTML dos itens do menu
    }

    const getVisitors = async () => {
        const today = new Date();

        // Formata a data como 'YYYY-MM-DD'
        const formattedDate = today.getFullYear() + '-' +
            ('0' + (today.getMonth() + 1)).slice(-2) + '-' + // Adiciona zero à esquerda se necessário e extrai os dois últimos dígitos
            ('0' + today.getDate()).slice(-2); // Adiciona zero

        const conditions = {
            conditions: [{
                field: "visitor_at",
                operator: "=",
                value: formattedDate,
                date: true
            }]
        };
        return await axios.get(`${base_url_api}visitors/all`, {
                params: {
                    filters: getFilter(),
                    page: page,
                    order: 'desc',
                    pageSize: 'all',
                    conditions
                }
            })
            .then(function(response) {
                return response.data;
            })
            .catch(function(error) {
                toastr.error(error.response.data.message);
            });
    }

    const getFilter = () => {
        let filter = {};
        inputSearchs.forEach(item => {
            let id = item.getAttribute('id');
            let value = item.value;
            let name = item.getAttribute('name');
            //let value = JSON.parse(localStorage.getItem(id));
            filter[name] = value;
        })
        return filter;
    }

    const initButtons = () => {
        document.querySelectorAll('.page').forEach(item => {
            item.addEventListener('click', changePage);
        })
    }

    inputSearchs.forEach(item => {
        item.addEventListener('keyup', debounce(function() {
            init();
        }, 900));
    })

    function changePage(e) {
        page = e.target.getAttribute('data-page');
        init();
    }

    function updateStatusVisitor(e) {
        const idVisitor = e.getAttribute('data-js-id');
        const status = e.getAttribute('data-value');
        axios.put(`${base_url_api}visitors/${idVisitor}/updateStatus`, {
                status: status,
            })
            .then(function(response) {
                const tr = document.querySelector(`tr[data-id="${idVisitor}"]`);
                const tableTbodyStatusLabel = tr.querySelector(`td[data-js="status_label"`);
                const tableUlDropMenu = tr.querySelector(`.dropdown-menu`);
                tableUlDropMenu.innerHTML = ''
                tableUlDropMenu.innerHTML = gerarItensMenuDropdown(response.data.data);
                tableTbodyStatusLabel.innerHTML = response.data.data.status_label
            })
            .catch(function(error) {
                console.log(error);
                toastr.error(error);
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        init();
    });

    setInterval(init, 40000);
</script>

</html>
