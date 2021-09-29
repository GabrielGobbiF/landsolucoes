@extends("app")

@section('title', ucfirst($obra->razao_social) . ' - ' . $obra->last_note)

@section('content')
    <section class="invoice">

        <div class="d-flex justify-content-between">
            <a href="{{ route('comercial.show', $obra->id) }}" class="btn btn-box-tool tx-20-f btn-lg"> <i class="fa fa-long-arrow-alt-left"></i> Comercial </a>
            <a href="{{ route('obras.show', $obra->id) }}" class="btn btn-box-tool tx-20-f btn-lg"> Obra <i class="fa fa-long-arrow-alt-right"></i> </a>
        </div>

        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fab fa-cc-apple-pay tx-20 mx-2"></i>
                <h3 class="card-title">Acesso BRPR - Rede 15kV</h3>
            </div>
            <div class="card-body">
                <h4 class="card-title">Descrição</h4>
                <p class="card-title-desc">
                    {{ $obra->description }}
                </p>
                <dl class="row mb-0">
                    <dt class="col-sm-3">CNPJ: </dt>
                    <dd class="col-sm-9">{{ $obra->cnpj }}</dd>

                    <dt class="col-sm-3 my-1">Ultima Nota: </dt>
                    <dd class="col-sm-9 my-1">{{ $obra->last_note }}</dd>

                    <dt class="col-sm-3">Endereço: </dt>
                    <dd class="col-sm-9">{{ $obra->AddressComplete }}</dd>
                </dl>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="table-responsive"></div>
                    <table class='table table-hover table-condensed'>
                        <thead class='thead-light'>
                            <tr>
                                <th>Etapa de faturamento</th>
                                <th>Valor Total Etapa</th>
                                <th>Total Faturado</th>
                                <th>Vencidas / Vencimento</th>
                                <th>Saldo à Faturar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $saldoAFaturar = 0;
                                $totalFaturado = 0;
                                $totalRecebido = 0;
                            @endphp

                            @foreach ($faturamento as $etapa)
                                @php
                                    $totalFaturado += $etapa['total_faturado'];
                                    $saldoAFaturar += $etapa['valor_etapa'] - $etapa['total_faturado'];
                                    $totalRecebido += $etapa['recebido'];
                                @endphp
                                <tr>
                                    <th>{{ mb_strimwidth($etapa['nome_etapa'], 0, 38, '...') }}</th>
                                    <th>R$ {{ maskPrice($etapa['valor_etapa']) }}</th>
                                    <th>R$ {{ maskPrice($etapa['total_faturado']) }}</th>
                                    <th>{{ $etapa['qnt_vencidas'] }} vencida(s) / {{ dateTournamentForHumans($etapa['dataVencimento']) }}</th>
                                    <th>R$ {{ $etapa['valor_etapa'] != '0' ? maskPrice($etapa['valor_etapa'] - $etapa['total_faturado']) : '0' }}</th>

                                    <th>
                                        @if ($etapa['total_faturado'] != '0' && $etapa['total_faturado'] == $etapa['valor_etapa'])
                                            @if ($etapa['total_receber'] != 0)
                                                @if ($etapa['dataVencimento'] <= date('Y-m-d'))
                                                    <a href="javascript:void(0)" class="{{ $etapa['status'] == 'C' ? 'btn-faturamento' : '' }}" data-id="{{ $etapa['id'] }}">
                                                        <div class="badge badge-soft-info">
                                                            Receber
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)" class="{{ $etapa['status'] == 'C' ? 'btn-faturamento' : '' }}" data-id="{{ $etapa['id'] }}">
                                                        <div class="badge badge-soft-success">
                                                            Faturado
                                                        </div>
                                                    </a>
                                                @endif
                                            @else
                                                <a href="javascript:void(0)" class="btn-faturamento" data-id="{{ $etapa['id'] }}">
                                                    <div class="badge badge-soft-success">
                                                        Recebido
                                                    </div>
                                                </a>
                                            @endif
                                        @else
                                            <a href="javascript:void(0)" class="{{ $etapa['status'] == 'C' ? 'btn-faturamento' : '' }}" data-id="{{ $etapa['id'] }}">
                                                <div class="badge badge-soft-{{ $etapa['label'] }}">
                                                    {{ __('etapa.status.' . $etapa['status']) }}
                                                </div>
                                            </a>
                                        @endif
                                    </th>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <hr class="my-5">
                <div class="row">
                    <div class="col-6">
                    </div>
                    <div class="col-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th style="width:50%">Valor Negociado: </th>
                                        <td>R$ {{ maskPrice($obra->financeiro->valor_negociado) }}</td>
                                    </tr>
                                    <tr>
                                        <th>A Faturar: </th>
                                        <td>R$ {{ maskPrice($saldoAFaturar) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Faturado: </th>
                                        <td>R$ {{ maskPrice($totalFaturado) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Recebido: </th>
                                        <td>R$ {{ maskPrice($totalRecebido) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Saldo: </th>
                                        <td>R$ {{ maskPrice($obra->financeiro->valor_negociado - $totalFaturado) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('pages.painel.obras._partials.modals.modal-etapas-financeiro')

@stop
@section('scripts')
    @yield("scripts")
    <script src="{{ asset('panel/js/pages/obras/financeiro.js') }}"></script>
    @if ($input = Request::input('etp'))
        <script>
            show(`{{ $input }}`)
        </script>
    @endif
@endsection
