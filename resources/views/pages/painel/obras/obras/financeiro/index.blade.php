@extends("app")

@section('title', ucfirst($obra->razao_social) . ' - ' . $obra->last_note)

@section('content')
    <section class="invoice">
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
                                <th>Saldo à Faturar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $saldoAFaturar = 0;
                                $totalFaturado = 0;
                                $totalRecebido = 0;
                                $totalAReceber = 0;
                            @endphp
                            @foreach ($etapas as $etapa)
                                @php
                                    $status = $etapa->StatusEtapa;

                                    if ($status) {
                                        $etapaValor = $status['text'] != 'EM' ? $etapa->valor_receber : 0;
                                        $etapaFaturado = $etapa->faturado();
                                        $etapaRecebido = $etapa->recebido();

                                        $totalFaturado += $etapaFaturado;
                                        $saldoAFaturar += $etapaValor - $etapaFaturado;
                                        $totalRecebido += $etapaRecebido;
                                        $totalAReceber += $etapaFaturado - $etapaRecebido;
                                    }

                                @endphp
                                <tr>
                                    <th>{{ mb_strimwidth($etapa->nome_etapa, 0, 38, '...') }}</th>
                                    <th>R$ {{ maskPrice($etapa->valor_receber) }}</th>
                                    <th>R$ {{ maskPrice($etapaFaturado) }}</th>
                                    <th>R$ {{ maskPrice($etapaValor - $etapaFaturado) }}</th>
                                    <th>
                                        <a href="javascript:void(0)" class="{{ $status['text'] == 'C' ? 'btn-faturamento' : '' }}" data-id="{{ $etapa->id }}">
                                            <div class="badge badge-soft-{{ $status['label'] }}">
                                                {{ __('etapa.status.' . $status['text']) }}
                                            </div>
                                        </a>
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
                                        <td>R$ {{ maskPrice($obra->financeiro->valor_negociado - $totalFaturado - $totalRecebido) }}</td>
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
