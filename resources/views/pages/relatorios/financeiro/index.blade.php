@extends('app')

@section('title', 'Relatórios Financeiros')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4 class="card-title mb-4">Relatórios Financeiros - Obras</h4>

                            <!-- Filtros -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Tipo de Relatório</label>
                                    <select id="tipo-relatorio" class="form-control">
                                        <option value="a_receber">A Receber</option>
                                        <option value="a_faturar">A Faturar</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label>Buscar</label>
                                    <input id="search" type="text" class="form-control" placeholder="Nome da obra ou NFE...">
                                </div>

                                <div class="col-md-3">
                                    <label>Obra</label>
                                    <select id="filter-obra" class="form-control select2">
                                        <option value="">Todas as obras</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label>Agrupar por Obra</label>
                                    <div class="custom-control custom-switch mt-2">
                                        <input id="agrupar-obra" type="checkbox" class="custom-control-input">
                                        <label class="custom-control-label" for="agrupar-obra">Sim</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Itens por página</label>
                                    <select id="per-page" class="form-control">
                                        <option value="15">15</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>

                                <div class="col-md-3 d-flex align-items-end">
                                    <button id="btn-filtrar" class="btn btn-primary">
                                        <i class="ri-filter-line"></i> Filtrar
                                    </button>
                                    <button id="btn-limpar" class="btn btn-secondary ml-2">
                                        <i class="ri-refresh-line"></i> Limpar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cards de Totais -->
                    <div id="cards-totais" class="row mb-4">
                        <!-- Cards serão inseridos aqui dinamicamente -->
                    </div>

                    <!-- Loading -->
                    <div id="loading" class="text-center py-5" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Carregando...</span>
                        </div>
                        <p class="mt-2">Carregando dados...</p>
                    </div>

                    <!-- Tabela -->
                    <div id="tabela-container" class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead id="tabela-header">
                                <!-- Header será inserido dinamicamente -->
                            </thead>
                            <tbody id="tabela-body">
                                <!-- Dados serão inseridos dinamicamente -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    <div id="pagination-container" class="d-flex justify-content-between align-items-center mt-4">
                        <div id="pagination-info"></div>
                        <nav>
                            <ul id="pagination" class="pagination mb-0">
                                <!-- Paginação será inserida dinamicamente -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let currentPage = 1;
            let currentFilters = {};

            // Inicializar Select2
            $('#filter-obra').select2({
                placeholder: 'Selecione uma obra',
                allowClear: true,
                ajax: {
                    url: '{{ route('relatorios.financeiro.obras') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(item => ({
                                id: item.id,
                                text: `${item.razao_social} - NFE: ${item.last_note || 'N/A'}`
                            }))
                        };
                    }
                }
            });

            // Carregar dados
            function loadData(page = 1) {
                $('#loading').show();
                $('#tabela-container').hide();

                const filters = {
                    tipo: $('#tipo-relatorio').val(),
                    search: $('#search').val(),
                    obra_id: $('#filter-obra').val(),
                    agrupar_por_obra: $('#agrupar-obra').is(':checked') ? true : false,
                    per_page: $('#per-page').val(),
                    page: page
                };

                currentFilters = filters;
                currentPage = page;

                axios.get('{{ route('relatorios.financeiro.data') }}', {
                        params: filters
                    })
                    .then(response => {
                        renderCards(response.data.totais, filters.tipo);
                        renderTable(response.data.data, filters.tipo, filters.agrupar_por_obra);
                        renderPagination(response.data.pagination);
                        $('#loading').hide();
                        $('#tabela-container').show();
                    })
                    .catch(error => {
                        console.error('Erro ao carregar dados:', error);
                        $('#loading').hide();
                        alert('Erro ao carregar dados. Tente novamente.');
                    });
            }

            // Renderizar cards de totais
            function renderCards(totais, tipo) {
                let html = '';

                if (tipo === 'a_receber') {
                    html = `
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Total a Receber</p>
                                    <h4 class="mb-0">R$ ${formatMoney(totais.total_a_receber || 0)}</h4>
                                </div>
                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="ri-money-dollar-circle-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Vencidas</p>
                                    <h4 class="mb-0 text-danger">R$ ${formatMoney(totais.total_vencidas || 0)}</h4>
                                </div>
                                <div class="avatar-sm rounded-circle bg-danger align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-danger">
                                        <i class="ri-alert-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Quantidade</p>
                                    <h4 class="mb-0">${totais.qtd_faturas || totais.qtd_obras || 0}</h4>
                                </div>
                                <div class="avatar-sm rounded-circle bg-info align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-info">
                                        <i class="ri-file-list-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                } else {
                    html = `
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Total a Faturar</p>
                                    <h4 class="mb-0">R$ ${formatMoney(totais.total_a_faturar || 0)}</h4>
                                </div>
                                <div class="avatar-sm rounded-circle bg-warning align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-warning">
                                        <i class="ri-file-text-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Quantidade</p>
                                    <h4 class="mb-0">${totais.qtd_etapas || totais.qtd_obras || 0}</h4>
                                </div>
                                <div class="avatar-sm rounded-circle bg-info align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-info">
                                        <i class="ri-file-list-line font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                }

                $('#cards-totais').html(html);
            }

            // Renderizar tabela
            function renderTable(data, tipo, agrupar) {
                let headerHtml = '';
                let bodyHtml = '';

                if (tipo === 'a_receber') {
                    if (agrupar) {
                        headerHtml = `
                    <tr>
                        <th>Obra</th>
                        <th>NFE</th>
                        <th>Total a Receber</th>
                        <th>Vencidas</th>
                        <th>Próximo Vencimento</th>
                        <th>Qtd Etapas</th>
                    </tr>
                `;

                        data.forEach(item => {
                            bodyHtml += `
                        <tr>
                            <td><a target="_blank" href="/l/obras/${item.obra_id}">${item.obra_nome}</a></td>
                            <td>${item.nfe || ''}</td>
                            <td class="text-success font-weight-bold">R$ ${formatMoney(item.total_a_receber)}</td>
                            <td class="text-danger">R$ ${formatMoney(item.vencidas)}</td>
                            <td>${formatDate(item.proximo_vencimento)}</td>
                            <td>${item.qtd_etapas}</td>
                        </tr>
                    `;
                        });
                    } else {
                        headerHtml = `
                    <tr>
                        <th>NFE</th>
                        <th>Obra</th>
                        <th>Etapa</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                        <th>Status</th>
                    </tr>
                `;

                        data.forEach(item => {
                            const statusClass = getStatusClass(item.status_vencimento);
                            const statusText = getStatusText(item.status_vencimento);

                            bodyHtml += `
                        <tr>
                            <td>${item.nfe || ''}</td>
                            <td><a target="_blank" href="/l/obras/${item.obra_id}">${item.obra_nome}</a></td>
                            <td>${item.nome_etapa}</td>
                            <td class="font-weight-bold">R$ ${formatMoney(item.valor)}</td>
                            <td>${formatDate(item.data_vencimento)}</td>
                            <td><span class="badge badge-soft-${statusClass}">${statusText}</span></td>
                        </tr>
                    `;
                        });
                    }
                } else {
                    if (agrupar) {
                        headerHtml = `
                    <tr>
                        <th>NFE</th>
                        <th>Obra</th>
                        <th>Total a Faturar</th>
                        <th>Qtd Etapas</th>
                    </tr>
                `;

                        data.forEach(item => {
                            bodyHtml += `
                        <tr>
                            <td>${item.nfe || ''}</td>
                            <td><a target="_blank" href="/l/obras/${item.obra_id}">${item.obra_nome}</a></td>
                            <td class="text-warning font-weight-bold">R$ ${formatMoney(item.total_a_faturar)}</td>
                            <td>${item.qtd_etapas}</td>
                        </tr>
                    `;
                        });
                    } else {
                        headerHtml = `
                    <tr>
                        <th>Obra</th>
                        <th>NFE</th>
                        <th>Etapa</th>
                        <th>Valor Total</th>
                        <th>Faturado</th>
                        <th>A Faturar</th>
                        <th>Status</th>
                    </tr>
                `;

                        data.forEach(item => {
                            bodyHtml += `
                        <tr>
                            <td><a target="_blank" href="/l/obras/${item.obra_id}">${item.obra_nome}</a></td>
                            <td>${item.nfe || 'N/A'}</td>
                            <td>${item.nome_etapa}</td>
                            <td>R$ ${formatMoney(item.valor_total)}</td>
                            <td>R$ ${formatMoney(item.valor_faturado)}</td>
                            <td class="text-warning font-weight-bold">R$ ${formatMoney(item.valor_a_faturar)}</td>
                            <td><span class="badge badge-soft-warning">${item.status}</span></td>
                        </tr>
                    `;
                        });
                    }
                }

                if (data.length === 0) {
                    bodyHtml = `
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <i class="ri-file-list-line font-size-48 text-muted"></i>
                        <p class="mt-2 text-muted">Nenhum registro encontrado</p>
                    </td>
                </tr>
            `;
                }

                $('#tabela-header').html(headerHtml);
                $('#tabela-body').html(bodyHtml);
            }

            // Renderizar paginação
            function renderPagination(pagination) {
                let html = '';

                if (pagination.last_page > 1) {
                    // Botão anterior
                    html += `
                <li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${pagination.current_page - 1}">Anterior</a>
                </li>
            `;

                    // Páginas
                    for (let i = 1; i <= pagination.last_page; i++) {
                        if (i === 1 || i === pagination.last_page || (i >= pagination.current_page - 2 && i <= pagination.current_page + 2)) {
                            html += `
                        <li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                        } else if (i === pagination.current_page - 3 || i === pagination.current_page + 3) {
                            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                        }
                    }

                    // Botão próximo
                    html += `
                <li class="page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${pagination.current_page + 1}">Próximo</a>
                </li>
            `;
                }

                $('#pagination').html(html);
                $('#pagination-info').html(`Mostrando ${pagination.from || 0} a ${pagination.to || 0} de ${pagination.total} registros`);
            }

            // Funções auxiliares
            function formatMoney(value) {
                return parseFloat(value || 0).toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function formatDate(date) {
                if (!date) return 'N/A';
                return new Date(date).toLocaleDateString('pt-BR');
            }

            function getStatusClass(status) {
                const classes = {
                    'vencido': 'danger',
                    'vence_em_breve': 'warning',
                    'a_vencer': 'success',
                    'sem_data': 'secondary'
                };
                return classes[status] || 'secondary';
            }

            function getStatusText(status) {
                const texts = {
                    'vencido': 'Vencido',
                    'vence_em_breve': 'Vence em breve',
                    'a_vencer': 'A vencer',
                    'sem_data': 'Sem data'
                };
                return texts[status] || 'N/A';
            }

            // Event listeners
            $('#btn-filtrar').click(function() {
                loadData(1);
            });

            $('#btn-limpar').click(function() {
                $('#search').val('');
                $('#filter-obra').val(null).trigger('change');
                $('#agrupar-obra').prop('checked', false);
                $('#per-page').val('15');
                loadData(1);
            });

            $('#tipo-relatorio, #agrupar-obra').change(function() {
                loadData(1);
            });

            $('#search').on('keypress', function(e) {
                if (e.which === 13) {
                    loadData(1);
                }
            });

            $(document).on('click', '#pagination a', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page && !$(this).parent().hasClass('disabled')) {
                    loadData(page);
                }
            });

            // Carregar dados iniciais
            loadData(1);
        });
    </script>
@endsection
