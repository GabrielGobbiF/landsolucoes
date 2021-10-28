@extends("app")

@section('title', 'Fornecedores')

@section('content')

    <div class="card">
        <div class="card-body">

            <div class="table table-api">
                <div class="table-responsive d-none">
                    <div id="toolbar">
                        <div class="form-inline" role="form">
                            <div class="btn-group mr-2">
                                <a  href="{{ route('fornecedor.create') }}" class="btn btn-dark waves-effect waves-light">
                                    <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                                </a>
                            </div>
                        </div>
                    </div>
                    <table data-toggle="table" id="table-api" data-table="fornecedores">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="razao_social" data-sortable="true">Razão Social</th>
                                <th data-field="cnpj">CNPJ</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')

@stop
