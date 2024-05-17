@extends("app")

@section('title', 'Tarefas')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="text-center" id="preloader-content">
                <div class="spinner-border text-primary m-1 align-self-center" role="status">
                    <span class="sr-only"></span>
                </div>
            </div>

            <div class="table table-responsive d-none">
                <div id="toolbar">
                    <div class="form-inline" role="form">
                        <div class="btn-group mr-2">
                            <button type="button" data-toggle="modal" data-target="#modal-add-concessionaria" class="btn btn-dark waves-effect waves-light">
                                <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                            </button>
                        </div>
                    </div>
                </div>
                <table data-toggle="table" id="table-api" data-table="concessionarias" order="id">
                    <thead>
                        <tr>
                            <th data-field="id" data-sortable="true" data-visible="false">#</th>
                            <th data-field="name" data-width="80%" data-width-unit="%">Razão Social</th>
                            <th data-field="qnt_services" data-halign="center" data-align="center" class="mobile--hidden">Quantidade de Serviços</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    @section('scripts')@endsection
@endsection
