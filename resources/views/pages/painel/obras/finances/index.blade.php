@extends("app")

@section('title', 'Financeiro')

@section('content')
    <div class="card">
        <div class="card-body">
            <form id='form-search-finance' role='form' class='needs-validation' action='{{ route('finances.index') }}' method='get'>
                <div class="row">
                    <div class="col-6 col-md-4">
                        <div class='form-group'>
                            <label for='obr_name'>Nome da Obra</label>
                            <input type='text' class='form-control' name='obr_name' id='input--obr_name' value='{{ Request::input('obr_name') ?? old('obr_name') }}'>
                        </div>
                    </div>

                    <div class="col-6 col-md-4">
                        <div class='form-group'>
                            <label for=''>Cliente</label>
                            <select name='clients' class='form-control select2'>
                                <option value='' selected>Todos</option>
                                @foreach ($clients as $client)
                                    <option {{ request()->filled('clients') && request()->input('clients') == $client->id ? 'selected' : '' }} value='{{ $client->id }}'>
                                        {{ $client->company_name . ' - ' . $client->username }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4 col-md-auto align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="formCheckFaturar" name="faturar" {{ Request::input('faturar') == 'true' ? 'checked' : '' }} value="true">
                            <label class="form-check-label" for="formCheckFaturar">
                                Somente Obras á Faturar
                            </label>
                        </div>
                    </div>
                    <div class="col-4 col-md-auto align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="formCheckReceber" {{ Request::input('receber') == 'true' ? 'checked' : '' }} name="receber" value="true">
                            <label class="form-check-label" for="formCheckReceber">
                                Somente Obras á Receber
                            </label>
                        </div>
                    </div>

                    <div class="col-4 col-md-auto align-self-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="formCheckVencimento" {{ Request::input('vencimento') == 'true' ? 'checked' : '' }} name="vencimento" value="true">
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
                            <th>Valor Negociado</th>
                            <th>Valor a Receber</th>
                            <th>Valor Recebido</th>
                            <th>Liberado Faturar</th>
                            <th>Nº Nota</th>
                            <th>Vencidas</th>
                            <th>Data Vencimento</th>
                            <th>Saldo</th>
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
                                <th> R$ {{ maskPrice($finance['valor_negociado']) }}</th>
                                <th> R$ {{ maskPrice($finance['total_receber']) }}</th>
                                <th> R$ {{ maskPrice($finance['total_recebido']) }}</th>
                                <th> R$ {{ maskPrice($finance['total_a_faturar']) }}</th>
                                <th> {{ $finance['n_nota'] }}</th>
                                <th> {{ $finance['vencidas'] }}</th>
                                <th> {{ $finance['data_vencimento'] != '' ? formatDateAndTime($finance['data_vencimento']) : null }}</th>
                                <th> R$ {{ maskPrice($finance['saldo']) }}</th>
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
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')


@endsection
