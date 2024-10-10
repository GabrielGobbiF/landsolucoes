@extends('app')

@section('title', 'Financeiro')

@section('content')
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
                        <button type="submit" class='btn btn-primary'>Buscar</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table table-responsive" style="font-size: 13px;">
                <table class='table table-hover table-centered table-condensed'>
                    <thead class='thead-light'>
                        <tr>
                            <th>Nome da Obra</th>
                            <th>Cliente</th>
                            <th>Valor Negociado</th>
                            <th>Valor a Receber</th>
                            <th>Valor Recebido</th>
                            <th>Liberado Faturar</th>
                            <th>Nº Nota</th>
                            <th>Vencidas</th>
                            <th>Data Vencimento</th>
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
                        @endphp
                        @foreach ($finances as $finance)
                            @php
                                $total_negociado += $finance['valor_negociado'];
                                $total_receber += $finance['total_receber'];
                                $total_recebido += $finance['total_recebido'];
                                $total_a_faturar += $finance['total_a_faturar'];
                                $total_saldo += $finance['saldo'];
                            @endphp

                            <tr>
                                <th>
                                    <a target="_blank" href="{{ route('obras.finance', $finance['obraId']) }}">{{ limit($finance['nome_obra']) }}
                                    </a>
                                </th>
                                <th> {{ $finance['client_name'] }}</th>
                                <th> R$ {{ maskPrice($finance['valor_negociado']) }}</th>
                                <th> R$ {{ maskPrice($finance['total_receber']) }}</th>
                                <th> R$ {{ maskPrice($finance['total_recebido']) }}</th>
                                <th> R$ {{ maskPrice($finance['total_a_faturar']) }}</th>
                                <th> {{ $finance['n_nota'] }}</th>
                                <th> {{ $finance['vencidas'] }}</th>
                                <th> {{ $finance['data_vencimento'] != '' ? formatDateAndTime($finance['data_vencimento']) : null }}</th>
                                <th> R$ {{ maskPrice($finance['saldo']) }}</th>
                                <th>
                                    <a href="#!" class="open-activities" data-obraId="{{ $finance['obraId'] }}">
                                        <i class="fas fa-info-circle no-click"></i>
                                    </a>
                                </th>
                            </tr>
                        @endforeach
                        <tr>
                            <th> Total: </th>
                            <th> R$ {{ maskPrice($total_negociado) }}</th>
                            <th> R$ {{ maskPrice($total_receber) }}</th>
                            <th> R$ {{ maskPrice($total_recebido) }}</th>
                            <th> R$ {{ maskPrice($total_a_faturar) }}</th>
                            <th> </th>
                            <th> </th>
                            <th> </th>
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
        const BASE_URL_API = document.querySelector('meta[name=js-base_url]').getAttribute('content');

        document.querySelectorAll('.open-activities').forEach(item => {
            item.addEventListener('click', function(e) {
                $('.etapas-activities').html('');
                let obraId = e.target.getAttribute('data-obraid');

                getActivitiesEtapa(obraId);
            });
        })

        function getActivitiesEtapa(obraId) {
            console.log(obraId);
            $.ajax({
                url: `${BASE_URL_API}/api/v1/comercial/${obraId}/activities`,
                type: "GET",
                ajax: true,
                dataType: "JSON",
                beforeSend: (jqXHR, settings) => {
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

@endsection
