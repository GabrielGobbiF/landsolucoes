@extends('app')

@section('title', 'Obras')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nome Obra</th>
                                        <th scope="col">Etapa</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($obrasEtapasVencidas as $obra)
                                        <tr class="">
                                            <td scope="row">{{ $obra['obra_name'] }}</td>
                                            <td>{{ $obra['etapa_name'] }}</td>
                                            <td>
                                                <a target="_blank" href="{{ route('obras.show', $obra['obra_id']) . '?etp=' . $obra['etapa_id'] }}" class="">
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

@endsection
