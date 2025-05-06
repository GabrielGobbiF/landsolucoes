@extends('app')

@section('title', 'Financeiro')

@section('content')

    <style>
        @media (min-width: 1200px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl {
                max-width: 1460px !important;
            }
        }
    </style>
    <div class="card">
        <div class="card-body">
            <form id='form-search-finance' role='form' class='needs-validation' action='{{ route('finances.index') }}' method='get'>
                <div class="row">
                    <div class="col-6 col-md-4">
                        <div class='form-group'>
                            <label for='obr_name'>Nome da Obra</label>
                            <input id='input--obr_name' type='text' class='form-control' name='obr_name'
                                   value='{{ Request::input('obr_name') ?? old('obr_name') }}'>
                        </div>
                    </div>

                    <div class="col-6 col-md-4">
                        <div class='form-group'>
                            <label for=''>Cliente</label>
                            <select name='clients' class='form-control select2'>
                                <option value='' selected>Todos</option>
                                @foreach ($clients as $client)
                                    <option {{ request()->filled('clients') && request()->input('clients') == $client->id ? 'selected' : '' }}
                                            value='{{ $client->id }}'>
                                        {{ $client->company_name . ' - ' . $client->username }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4 col-md-auto align-self-center">
                        <div class="form-check">
                            <input id="formCheckFaturar" class="form-check-input" type="checkbox" name="faturar"
                                   {{ Request::input('faturar') == 'true' ? 'checked' : '' }} value="true">
                            <label class="form-check-label" for="formCheckFaturar">
                                Somente Obras á Faturar
                            </label>
                        </div>
                    </div>
                    <div class="col-4 col-md-auto align-self-center">
                        <div class="form-check">
                            <input id="formCheckReceber" class="form-check-input" type="checkbox" {{ Request::input('receber') == 'true' ? 'checked' : '' }}
                                   name="receber" value="true">
                            <label class="form-check-label" for="formCheckReceber">
                                Somente Obras á Receber
                            </label>
                        </div>
                    </div>

                    <div class="col-4 col-md-auto align-self-center">
                        <div class="form-check">
                            <input id="formCheckVencimento" class="form-check-input" type="checkbox" {{ Request::input('vencimento') == 'true' ? 'checked' : '' }}
                                   name="vencimento" value="true">
                            <label class="form-check-label" for="formCheckVencimento">
                                Somente Faturamento Vencido
                            </label>
                        </div>
                    </div>
                    <div class="col-4 col-md-3 align-self-center">
                        <button id="apply-filters" type="submit" class='btn btn-primary'>Buscar</button>
                        <a href="{{ route('finances.export', request()->all()) }}" class="btn btn-outline-primary">
                            Exportar
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table table-responsive" style="font-size: 13px;">
                <table class='table table-hover table-centered table-condensed'>
                    <thead class='thead-light'>
                        <tr>
                            <th>Nº Nota</th>
                            <th>Nome da Obra</th>
                            <th>Cliente</th>
                            <th>Valor Negociado</th>
                            <th>Valor a Receber</th>
                            <th>Valor Recebido</th>
                            <th>Faturado</th>
                            <th>Liberado Faturar</th>
                            <th>Vencidas</th>
                            <th>Saldo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_negociado = 0;
                            $total_receber = 0;
                            $total_recebido = 0;
                            $total_a_faturar = 0;
                            $total_saldo = 0;
                            $total_faturado = 0;
                            $total_vencidas = 0;
                        @endphp
                        @foreach ($obras as $obra)
                            @php
                                $total_negociado += $obra->financeiro->valor_negociado;
                                $total_receber += $obra->financeiro->a_receber;
                                $total_recebido += $obra->financeiro->recebido;
                                $total_a_faturar += $obra->financeiro->total_a_faturar;
                                $total_saldo += $obra->financeiro->saldo;
                                $total_faturado += $obra->financeiro->faturado;
                                $total_vencidas += $obra->financeiro->vencidas;
                            @endphp
                            <tr class="">
                                <td>{{ $obra->last_note }}</td>
                                <td>{{ limit($obra->razao_social) }}</td>
                                <td>{{ limit($obra->client->company_name) }}</td>
                                <td>R$ {{ maskPrice($obra->financeiro->valor_negociado) }}</td>
                                <td>R$ {{ maskPrice($obra->financeiro->a_receber) }}</td>
                                <td>R$ {{ maskPrice($obra->financeiro->recebido) }}</td>
                                <td>R$ {{ maskPrice($obra->financeiro->faturado) }}</td>
                                <td>R$ {{ maskPrice($obra->financeiro->total_a_faturar) }}</td>
                                <td>{{ $obra->financeiro->vencidas }}</td>
                                <td>R$ {{ maskPrice($obra->financeiro->saldo) }}</td>
                                <td>
                                    <div class="d-flex gap-2" style="gap: 0.6rem">
                                        <a href="#!" class="open-activities" data-obraId="{{ $obra->id }}">
                                            <i class="fas fa-info-circle no-click"></i>
                                        </a>

                                        <a href="{{ route('obras.finance', $obra->id) }}" class="">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th> Total: </th>
                            <th> </th>
                            <th> </th>

                            <th> R$ {{ maskPrice($total_negociado) }}</th>
                            <th> R$ {{ maskPrice($total_receber) }}</th>
                            <th> R$ {{ maskPrice($total_recebido) }}</th>
                            <th> R$ {{ maskPrice($total_faturado) }}</th>
                            <th> R$ {{ maskPrice($total_a_faturar) }}</th>
                            <th> {{ $total_vencidas }} </th>
                            <th> R$ {{ maskPrice($total_saldo) }}</th>
                            <th> </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="page--obra-finance">
        <div id="activeRight" class="offcanvas offcanvas-end" tabindex="-1" aria-labelledby="offcanvasRightLabel" aria-modal="true" role="dialog">
            <input id="js-activity-id" type="hidden">

            <div id="div--activities" class="col-md-12 etp">
                <div class="box-header with-border mg-t-10">
                    <h3 class="box-title">Obra: </h3>

                    <button type='button' class='close close-right-bar ml-5'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class="box-body mt-3">
                    <div>
                        <ul id="pills-tab" class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a id="pills-home-tab" class="nav-link active" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home"
                                   aria-selected="true">Observações do Sistema</a>
                            </li>
                            @if (!auth()->guard('clients')->check())
                                <li class="nav-item d-none" role="presentation">
                                    <a id="pills-profile-tab" class="nav-link" data-toggle="pill" href="#pills-profile" role="tab"
                                       aria-controls="pills-profile" aria-selected="false">Pendências</a>
                                </li>
                            @endif
                        </ul>
                        <div id="pills-tabContent" class="tab-content">
                            <div id="pills-home" class="tab-pane fade show active" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="media mb-4">
                                            @include('pages.painel._partials.avatar', [
                                                'avatar' => '',
                                                'name' => Auth::user()->name ?? auth()->guard('clients')->user()->username,
                                            ])
                                            <div class="media-body align-self-center ml-2">
                                                <div id="comment-div" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                                                    <div class="wd-100p d-none">
                                                        <p contenteditable="true" style="height: auto !important;" class="form-control js-new-comment"></p>
                                                    </div>
                                                    <input id="input-new-comment" type="text" class="form-control" name="obs_texto">
                                                    <button id="button-submit" type="submit" class="btn btn-primary js-btn-new-comment align-self-start"
                                                            onclick="newComment(this)">Enviar</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="etapas-activities" style="height: 100vh;"></div>
                                    </div>
                                </div>
                            </div>
                            @if (!auth()->guard('clients')->check())
                                <div id="pills-profile" class="tab-pane fade" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div id="pills-home" class="tab-pane fade show active" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <div class="row mt-4">
                                            <h6 class="">Desenvolvendo</h6>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rightbar-activities-overlay" class="rightbar-etp-overlay"></div>
    </div>



@endsection


@section('scripts')

    <script class="">
        let currentPage = 1;
        let lastPage = null;
        let loading = false;

        let totals = {
            valor_negociado: 0,
            total_receber: 0,
            total_recebido: 0,
            total_a_faturar: 0,
            saldo: 0,
        };

        const tbody = document.getElementById('finance-body');
        const loader = document.getElementById('loader');

        function formatCurrency(value) {
            return `R$ ${Number(value).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`;
        }

        function getFilters() {
            const filters = {};
            const obrName = document.getElementById('obr_name')?.value;
            const clients = document.getElementById('clients')?.value;
            const faturar = document.getElementById('faturar')?.checked;
            const receber = document.getElementById('receber')?.checked;
            const vencimento = document.getElementById('vencimento')?.checked;

            if (obrName) filters.obr_name = obrName;
            if (clients) filters.clients = clients;
            if (faturar) filters.faturar = 1;
            if (receber) filters.receber = 1;
            if (vencimento) filters.vencimento = 1;

            return filters;
        }

        function buildQueryString(params) {
            return Object.entries(params)
                .map(([key, val]) => `${encodeURIComponent(key)}=${encodeURIComponent(val)}`)
                .join('&');
        }

        function renderTotalRow() {
            const totalRow = document.getElementById('totals-row');
            if (totalRow) totalRow.remove();

            const row = document.createElement('tr');
            row.id = 'totals-row';
            row.innerHTML = `
        <th>Total:</th>
        <th>${formatCurrency(totals.valor_negociado)}</th>
        <th>${formatCurrency(totals.total_receber)}</th>
        <th>${formatCurrency(totals.total_recebido)}</th>
        <th>${formatCurrency(totals.total_a_faturar)}</th>
        <th></th><th></th><th></th>
        <th>${formatCurrency(totals.saldo)}</th>
        <th></th>
    `;
            tbody.appendChild(row);
        }

        function appendRow(finance) {
            const row = document.createElement('tr');
            row.innerHTML = `
        <th><a target="_blank" href="/obras/${finance.obraId}/finance">${finance.nome_obra}</a></th>
        <th>${finance.client_name}</th>
        <th>${formatCurrency(finance.valor_negociado)}</th>
        <th>${formatCurrency(finance.total_receber)}</th>
        <th>${formatCurrency(finance.total_recebido)}</th>
        <th>${formatCurrency(finance.total_a_faturar)}</th>
        <th>${finance.n_nota ?? ''}</th>
        <th>${finance.vencidas}</th>
        <th>${finance.data_vencimento ?? ''}</th>
        <th>${formatCurrency(finance.saldo)}</th>
        <th><a href="#!" class="open-activities" data-obraId="${finance.obraId}">
            <i class="fas fa-info-circle no-click"></i>
        </a></th>
    `;
            tbody.appendChild(row);

            // Atualiza os totais
            totals.valor_negociado += Number(finance.valor_negociado);
            totals.total_receber += Number(finance.total_receber);
            totals.total_recebido += Number(finance.total_recebido);
            totals.total_a_faturar += Number(finance.total_a_faturar);
            totals.saldo += Number(finance.saldo);
        }

        function loadFinances(page = 1) {
            if (loading || (lastPage && page > lastPage)) return;

            loading = true;
            loader.style.display = 'block';

            const filters = getFilters();
            const queryString = buildQueryString({
                ...filters,
                page
            });

            axios.get(`${base_url}/api/v1/finances?${queryString}`)
                .then(response => {
                    const data = response.data.data;
                    const meta = response.data;

                    currentPage = meta.current_page;
                    lastPage = meta.last_page;

                    data.forEach(finance => appendRow(finance));

                    renderTotalRow();
                })
                .catch(error => {
                    console.error("Erro ao carregar dados:", error);
                })
                .finally(() => {
                    loading = false;
                    loader.style.display = 'none';
                });
        }

        function resetTable() {
            tbody.innerHTML = '';
            totals = {
                valor_negociado: 0,
                total_receber: 0,
                total_recebido: 0,
                total_a_faturar: 0,
                saldo: 0,
            };
            currentPage = 1;
            lastPage = null;
        }

        //document.getElementById('apply-filters').addEventListener('click', () => {
        //    resetTable();
        //    loadFinances();
        //});

        window.addEventListener('scroll', () => {
            const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 200;
            if (nearBottom) {
                loadFinances(currentPage + 1);
            }
        });

        // 🚀 Primeira carga
        //loadFinances();
    </script>

    <script class="">
        const BASE_URL_API = document.querySelector('meta[name=js-base_url]').getAttribute('content');

        document.querySelectorAll('.open-activities').forEach(item => {
            item.addEventListener('click', function(e) {
                let obraId = e.target.getAttribute('data-obraid');

                getActivitiesEtapa(obraId);
            });
        })

        function getActivitiesEtapa(obraId) {
            $.ajax({
                url: `${BASE_URL_API}/api/v1/comercial/${obraId}/activities`,
                type: "GET",
                ajax: true,
                dataType: "JSON",
                beforeSend: (jqXHR, settings) => {
                    $('.etapas-activities').html('');
                    $('#button-submit').attr('data-obraid', `${obraId}`);
                    //modal.find('.etapas-activities').html(preload('preload-activities'));
                },
                success: function(j) {
                    var data = j.data;
                    if (data.length > 0) {
                        var options = '';
                        $.each(data, function(index, value) {
                            const deletePermisson = value.deletu == true ?
                                `<a href="javascript:void(0)" onclick="deleteComment(${value.id}, ${value.tipyssable_id})"<i class="fas fa-trash ml-3"></i> </a>` :
                                '';
                            options += '<div class="media mt-4">';
                            options += '<div class="avatar-sm font-weight-bold d-inline-block">'
                            options += '    <span class="avatar-title rounded-circle bg-soft-purple tx-14">'
                            options += value.user_title
                            options += '    </span>'
                            options += '</div>'
                            options += '    <div class="media-body overflow-hidden ml-2">';
                            options += '        <h5 class="tx-black text-truncate mb-1 tx-14 ">' + value.user_name + '</h5>';
                            options +=
                                `        <div class="direct-chat-text"><span style="word-break: break-all; white-space: pre-line">  ${value.text}  </span></div>`
                            options += '    </div>';
                            options += `    <div class="font-size-11">${value.date} ${deletePermisson}</div>`;
                            options += '</div>';
                        });
                        $('.etapas-activities').html(options);

                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error('erro ao carregar os comentários');
                    $('#button-submit').attr('data-obraid', null);
                },
                complete: function() {
                    document.getElementById('activeRight').classList.add('show');
                    document.getElementById('rightbar-activities-overlay').classList.add('show');
                },
            });
        }

        function newComment(e) {
            var input = $('#input-new-comment').val();
            var obraId = e.getAttribute('data-obraid');
            var etp_id = $('#js-etapa-id').val();
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                url: `${BASE_URL_API}/api/v1/comercial/${obraId}/activities?type=finance`,
                type: 'POST',
                ajax: true,
                dataType: "JSON",
                data: {
                    text: input
                }
            }).done(function(response) {
                $('#input-new-comment').val('').focus();
                $('.js-btn-new-comment').attr('disabled', false);
                $('.js-new-comment').html('');
                getActivitiesEtapa(obraId)
            });
        }

        function deleteComment(commentId, obraId) {
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                url: `${BASE_URL_API}/api/v1/activities/${commentId}`,
                type: 'DELETE',
                ajax: true,
                dataType: "JSON",
                success: function(j) {
                    getActivitiesEtapa(obraId)
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error('Não foi possivel Deletar');
                }
            });
        }

        document.querySelector('.close-right-bar').addEventListener('click', () => {
            $('#button-submit').attr('data-obraid', null);
            document.getElementById('activeRight').classList.remove('show');
            document.getElementById('rightbar-activities-overlay').classList.remove('show');
        })

        $(document).on('click', 'body', function(e) {

            if ($(e.target).closest('.offcanvas').length > 0) {
                return;
            }

            $('body').removeClass('right-bar-enabled');
            $('#activeRight').removeClass('show');
            $('#rightbar-activities-overlay').removeClass('show');
            return;
        });
    </script>

@append
