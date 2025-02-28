@extends('app')

@section('title', ucfirst($obra->razao_social) . ' - ' . $obra->last_note)

@section('content')
    <style class="">
        .badge-soft-receber {
            color: #5c6119;
            background-color: #ffad1169 !important;
        }

        .badge-soft-faturar {
            color: #b34e4e;
            background-color: rgb(211 22 22 / 28%);
        }

        .cross-line {
            text-decoration: line-through;
        }
    </style>
    <section class="invoice">

        <div class="d-flex justify-content-between">
            <a href="{{ route('comercial.show', $obra->id) }}" class="btn btn-box-tool tx-20-f btn-lg"> <i class="fa fa-long-arrow-alt-left"></i> Comercial </a>
            <a href="{{ route('obras.show', $obra->id) }}" class="btn btn-box-tool tx-20-f btn-lg"> Obra <i class="fa fa-long-arrow-alt-right"></i> </a>
        </div>

        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fab fa-cc-apple-pay tx-20 mx-2"></i>
                <h3 class="card-title">{{ ucfirst($obra->razao_social) }}</h3>
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
                                <th>Total</th>
                                <th>Total Faturado</th>
                                <th>À Faturar</th>
                                <th>À Receber</th>
                                <th>Recebido</th>
                                <th>Vencidas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($dadosFinanceirosCollection as $dadosEtapa)
                                <tr class="{{ $dadosEtapa['recebido'] == $dadosEtapa['valor_total'] ? 'cross-line' : '' }}">

                                    {{-- Etapa de faturamento --}}
                                    <th>{{ $dadosEtapa['nome'] }}</th>

                                    {{-- Total --}}
                                    <th>{{ currency($dadosEtapa['valor_total']) }}</th>

                                    {{-- Total Faturado --}}
                                    <th>{{ currency($dadosEtapa['total_faturado']) }}</th>

                                    {{-- A Faturado --}}
                                    <th>
                                        <span class="text-{{ $dadosEtapa['a_faturar'] > 0 ? 'success' : '' }}">
                                            {{ currency($dadosEtapa['a_faturar']) }}
                                        </span>
                                    </th>

                                    {{-- A Receber --}}
                                    <th>
                                        <span class="text-{{ $dadosEtapa['a_receber'] > 0 ? 'success' : '' }}">
                                            {{ currency($dadosEtapa['a_receber']) }}
                                        </span>
                                    </th>

                                    {{-- A Recebido --}}
                                    <th>{{ currency($dadosEtapa['recebido']) }}</th>

                                    {{-- Vencidas --}}
                                    <th>
                                        <span class="text-{{ $dadosEtapa['vencidas']['quantidade'] > 0 ? 'danger' : '' }}">
                                            {{ $dadosEtapa['vencidas']['quantidade'] }}
                                        </span>
                                    </th>

                                    <th>
                                        @if ($dadosEtapa['total_faturado'] != '0' && $dadosEtapa['total_faturado'] == $dadosEtapa['valor_total'])
                                            @if ($dadosEtapa['a_receber'] != 0)
                                                @if ($dadosEtapa['proximo_vencimento'] <= date('Y-m-d'))
                                                    <a href="javascript:void(0)" class="{{ $dadosEtapa['status_etapa'] == 'C' ? 'btn-faturamento' : '' }}"
                                                       data-id="{{ $dadosEtapa['id'] }}">
                                                        <div class="badge badge-soft-receber">
                                                            Receber
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)" class="{{ $dadosEtapa['status_etapa'] == 'C' ? 'btn-faturamento' : '' }}"
                                                       data-id="{{ $dadosEtapa['id'] }}">
                                                        <div class="badge badge-soft-success">
                                                            Faturado
                                                        </div>
                                                    </a>
                                                @endif
                                            @else
                                                <a href="javascript:void(0)" class="btn-faturamento" data-id="{{ $dadosEtapa['id'] }}">
                                                    <div class="badge badge-soft-success">
                                                        Recebido
                                                    </div>
                                                </a>
                                            @endif
                                        @else
                                            <a href="javascript:void(0)" class="{{ $dadosEtapa['status_etapa'] == 'C' ? 'btn-faturamento' : '' }}"
                                               data-id="{{ $dadosEtapa['id'] }}">
                                                <div class="badge badge-soft-{{ $dadosEtapa['label_etapa'] }}">
                                                    {{ __('etapa.status.' . $dadosEtapa['status_etapa']) }}
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
                                        <td>{{ currency($obra->financeiro->valor_negociado) }}</td>
                                    </tr>
                                    <tr>
                                        <th>A Faturar: </th>
                                        <td>{{ currency($dadosFinanceirosCollection->sum('a_faturar')) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Faturado: </th>
                                        <td>{{ currency($dadosFinanceirosCollection->sum('total_faturado')) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Recebido: </th>
                                        <td>{{ currency($dadosFinanceirosCollection->sum('recebido')) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Saldo: </th>
                                        <td>{{ currency($obra->financeiro->valor_negociado - $dadosFinanceirosCollection->sum('total_faturado')) }}</td>
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
    @yield('scripts')
    <script src="{{ asset('panel/js/pages/obras/financeiro.js') }}"></script>
    @if ($input = Request::input('etp'))
        <script>
            show(`{{ $input }}`)
        </script>
    @endif
@append
