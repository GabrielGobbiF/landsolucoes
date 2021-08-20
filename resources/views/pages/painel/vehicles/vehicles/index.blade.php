@extends("app")

@section('title', 'Veiculos')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="form-inline" role="form">
                            <div class="btn-group mr-2">
                                <a href="{{ route('vehicles.create') }}" data-toggle="tooltip" data-placement="top" title="Novo" class="btn btn-dark waves-effect waves-light"><i
                                        class="ri-add-circle-line align-middle mr-2"></i>
                                    Novo
                                </a>
                            </div>
                        </div>
                    </div>
                    <table data-toggle="table" id="table-api" data-table="vehicles">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="name" data-align="left">Nome</th>
                                <th data-field="board" class="mobile--hidden">Placa</th>
                                <th data-field="year" class="mobile--hidden">Ano</th>

                                <th data-field="renavam" class="mobile--hidden" data-visible="false">Renavam</th>
                                <th data-field="tracker" class="mobile--hidden" data-visible="false">Seguro</th>
                                <th data-field="type" class="mobile--hidden" data-visible="false">Tipo</th>

                                <th data-field="statusButton" data-halign="center" data-align="center">Ação</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@section('scripts')

@endsection
@endsection
