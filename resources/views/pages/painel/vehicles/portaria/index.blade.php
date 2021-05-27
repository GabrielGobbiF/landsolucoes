@extends('app')

@section('title', 'Portaria')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h1 class="h2">Portaria</h1>
                    <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right"></div>
                </div>

                <table data-toggle="table" id="table" class="table table-hover table-striped" data-search="true" data-show-refresh="true" data-show-fullscreen="true"
                    data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true"
                    data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-cookie="true"
                    data-cookie-id-table="employee" data-toolbar="#toolbar" data-buttons-class="dark">
                    <thead>

                        <tr class="text-center">
                            <th data-align="left">Porteiro</th>
                            <th class="mobile--hidden">Motorista</th>
                            <th class="mobile--hidden">Veiculo</th>
                            <th class="mobile--hidden">Data</th>
                            <th class="mobile--hidden">Tipo</th>

                            <th class="mobile--hidden" data-visible="false">Observações</th>

                            <th class="mobile--hidden" data-width="300">Files</th>

                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($portarias as $portaria)
                            <tr class="text-center">
                                <td style="text-align:left">{{ $portaria->porteiro }}</td>
                                <td class="mobile--hidden">{{ $portaria->motorista }}</td>
                                <td class="mobile--hidden">{{ $portaria->veiculo }}</td>

                                <td class="mobile--hidden">{{ $portaria->data }}</td>
                                <td class="mobile--hidden">{{ $portaria->type }}</td>
                                <td class="mobile--hidden">{{ $portaria->observations }}</td>

                                <td class="mobile--hidden">
                                    @if ($portaria->files != '')
                                        @foreach ($portaria->images as $image)
                                            <a href="{{ asset('storage/' . $image) }}" class=""> <img src="{{ asset('storage/' . $image) }}" width="20%"></a>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
