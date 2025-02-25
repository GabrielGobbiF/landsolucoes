@extends('app')

@section('title', 'Dashboard')

@section('content')

    <style>
        .text-end {
            text-align: end;
        }

        .nav * .nav-link.active {
            background: #1d4038;
            color: #fff;
            border: 1px solid #eee;
            border-radius: 10%;
        }
    </style>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0" style="font-size:16px">Dashboard Obras</h4>

                {{--
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Nazox</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
--}}
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Total de Obras</p>
                                    <h4 class="mb-0">{{ $countObras }} Obras</h4>
                                </div>

                            </div>
                        </div>

                        <div class="card-body border-top py-3 d-none">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                                <span class="text-muted ms-2">From previous period</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Suas Obras</p>
                                    <h4 class="mb-0">{{ $countObrasByUser }} Obras</h4>
                                </div>

                            </div>
                        </div>

                        <div class="card-body border-top py-3 d-none">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                                <span class="text-muted ms-2">From previous period</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Obras com Atraso</p>
                                    <h4 class="mb-0">{{ $obrasComEtapasAtrasadas }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top py-3 d-none">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                                <span class="text-muted ms-2">From previous period</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Suas Obras com Atraso(s)</p>
                                    <h4 class="mb-0">{{ $obrasComEtapasAtrasadasByUser }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top py-3 d-none">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                                <span class="text-muted ms-2">From previous period</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Obras Sem Gestor</p>
                                    <h4 class="mb-0">{{ $countObrasNotUser }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top py-3 d-none">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                                <span class="text-muted ms-2">From previous period</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Etapas Atrasadas</p>
                                    <h4 class="mb-0">{{ $etapasAtrasadas->count() }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top py-3 d-none">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                                <span class="text-muted ms-2">From previous period</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Etapas Vencem Hoje</p>
                                    <h4 class="mb-0">{{ $etapasVencemHoje->count() }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top py-3 d-none">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                                <span class="text-muted ms-2">From previous period</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Etapas Vão Vencer</p>
                                    <h4 class="mb-0">{{ $etapasPrestesAVencer->count() }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top py-3 d-none">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                                <span class="text-muted ms-2">From previous period</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="text-truncate mb-4">Etapas </h4>


                            <ul id="myTab" class="nav nav-underline fs-9" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a id="home-tab" class="nav-link active" data-toggle="tab" href="#tab-home" role="tab" aria-controls="tab-home"
                                       aria-selected="true">Atrasadas</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a id="profile-tab" class="nav-link" data-toggle="tab" href="#tab-profile" role="tab" aria-controls="tab-profile"
                                       aria-selected="false" tabindex="-1">Vencem Hoje
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a id="contact-tab" class="nav-link" data-toggle="tab" href="#tab-contact" role="tab" aria-controls="tab-contact"
                                       aria-selected="false" tabindex="-1">Vão Vencer</a>
                                </li>
                            </ul>

                            <div id="myTabContent" class="tab-content mt-3">
                                <div id="tab-home" class="tab-pane fade active show" role="tabpanel" aria-labelledby="home-tab"
                                     style="max-height: 300px; overflow: auto;">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Etapa</th>
                                                    <th>Obra</th>
                                                    <th class="text-end"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($etapasAtrasadas as $etapaAtrasadas)
                                                    <tr>
                                                        <td>{{ $etapaAtrasadas->nome }}</td>
                                                        <td>{{ $etapaAtrasadas->obra->razao_social }}</td>
                                                        <td class="text-end">
                                                            <a href="{{ route('obras.show', $etapaAtrasadas->obra->id) }}" class="">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div id="tab-profile" class="tab-pane fade" role="tabpanel" aria-labelledby="profile-tab"
                                     style="max-height: 300px; overflow: auto;">

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Etapa</th>
                                                    <th>Obra</th>
                                                    <th class="text-end"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($etapasVencemHoje as $etapaVencemHoje)
                                                    <tr>
                                                        <td>{{ $etapaVencemHoje->nome }}</td>
                                                        <td>{{ $etapaVencemHoje->obra->razao_social }}</td>
                                                        <td class="text-end">
                                                            <a href="{{ route('obras.show', $etapaVencemHoje->obra->id) }}" class="">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div id="tab-contact" class="tab-pane fade" role="tabpanel" aria-labelledby="contact-tab"
                                     style="max-height: 300px; overflow: auto;">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Etapa</th>
                                                    <th>Obra</th>
                                                    <th class="text-end"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($etapasPrestesAVencer as $etapaPrestesAVencer)
                                                    <tr>
                                                        <td>{{ $etapaPrestesAVencer->nome }}</td>
                                                        <td>{{ $etapaPrestesAVencer->obra->razao_social }}</td>
                                                        <td class="text-end">
                                                            <a href="{{ route('obras.show', $etapaPrestesAVencer->obra->id) }}" class="">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </td>
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

            </div>
        </div>

        <div class="col-xl-6">
            <div class="card text-white ">
                <div class="card-body">
                    <h3 class="mb-3">Etapas Vencidas</h3>
                    <canvas id="naoAtualizadasChart"></canvas>

                </div>
            </div>

        </div>

    </div>


    <div class="row">

        <div class="col-12 col-md-6">
            <div class="card text-start">
                <div class="card-body">
                    <h3 class="mb-3">Etapas Não Atualizadas</h3>
                    <canvas id="etapasVencidasChart"></canvas>

                </div>
            </div>

        </div>

        <div class="col-12 col-md-6">
            <div class="card text-start">
                <div class="card-body">
                    <h3 class="mb-3">Etapas a Vencer</h3>
                    <canvas id="etapasAVencerChart"></canvas>
                </div>
            </div>

        </div>

        <div class="col-12 col-md-6 mt-2">

        </div>

        <div class="col-12 col-md-6 mt-2 d-none">
            <div class="card text-start">
                <div class="card-body">
                    <h3 class="mb-3">Etapas Sem Pendências</h3>
                    <canvas id="semPendenciasChart"></canvas>
                </div>
            </div>
        </div>

    </div>






@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        // Gráfico de Barras: Não Atualizadas
        var ctx1 = document.getElementById('naoAtualizadasChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Não Atualizadas',
                    data: @json($nao_atualizadas),
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {

                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Pizza: Etapas a Vencer
        // Gráfico de Pizza: Etapas a Vencer
        var ctx2 = document.getElementById('etapasAVencerChart').getContext('2d');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: @json($labels),
                datasets: [{
                    data: @json($etapas_a_vencer),
                    backgroundColor: ['#007bff', '#ff9800', '#28a745', '#6f42c1', '#dc3545']
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        color: 'white', // Cor do texto
                        font: {
                            weight: 'bold',
                            size: 16
                        },
                        anchor: 'center', // Posição do texto
                        align: 'center', // Alinhamento do texto
                        formatter: (value, context) => {
                            let sum = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = (value / sum * 100).toFixed(0) + '%';
                            return percentage; // Exibe a porcentagem em cada fatia
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Ativando o plugin
        });

        // Gráfico de Pizza: Etapas Vencidas
        var ctx3 = document.getElementById('etapasVencidasChart').getContext('2d');
        new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: @json($labels),
                datasets: [{
                    data: @json($etapas_vencidas),
                    backgroundColor: ['#007bff', '#ff9800', '#28a745', '#6f42c1', '#dc3545']
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        color: 'white', // Cor do texto
                        font: {
                            weight: 'bold',
                            size: 16
                        },
                        anchor: 'center', // Posição do texto
                        align: 'center', // Alinhamento do texto
                        formatter: (value, context) => {
                            let sum = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = (value / sum * 100).toFixed(0) + '%';
                            return percentage; // Exibe a porcentagem em cada fatia
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Ativando o plugin// Ativando o plugin

        });

        // Gráfico de Pizza: Sem Pendências
        var ctx4 = document.getElementById('semPendenciasChart').getContext('2d');
        new Chart(ctx4, {
            type: 'pie',
            data: {
                labels: @json($labels),
                datasets: [{
                    data: @json($sem_pendencias),
                    backgroundColor: ['#007bff', '#ff9800', '#28a745', '#6f42c1', '#dc3545']
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        color: 'white', // Cor do texto
                        font: {
                            weight: 'bold',
                            size: 16
                        },
                        anchor: 'center', // Posição do texto
                        align: 'center', // Alinhamento do texto
                        formatter: (value, context) => {
                            let sum = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = (value / sum * 100).toFixed(0) + '%';
                            return percentage; // Exibe a porcentagem em cada fatia
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Ativando o plugin
        });
    </script>
@endsection
