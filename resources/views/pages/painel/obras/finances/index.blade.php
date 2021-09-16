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
            <div class="table table-responsive">
                <table class='table table-hover table-centered table-condensed'>
                    <thead class='thead-light'>
                        <tr>
                            <th>Nome da Obra</th>
                            <th>Valor Negociado</th>
                            <th>Valor a Receber</th>
                            <th>Valor Recebido</th>
                            <th>Liberado Faturar</th>
                            <th>Vencidas / Data de vencimento</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($finances as $finance)
                            <tr>
                                <th> <a target="_blank" href="{{route('obras.finance', $finance->obraId)}}" class="">{{ $finance->name }}</a></th>
                                <th> R$ {{ maskPrice($finance->negociado) }}</th>
                                <th> R$ {{ maskPrice($finance->totalReceber) }}</th>
                                <th> R$ {{ maskPrice($finance->recebido) }}</th>
                                <th> R$ {{ maskPrice($finance->aFaturar) }}</th>
                                <th> {{ $finance->qntVencidas != 0 ? $finance->qntVencidas . ' - ' . $finance->dataVencimento : '' }}</th>
                                <th> R$ {{ maskPrice($finance->saldo) }}</th>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')


@endsection
