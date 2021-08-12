@extends("app")

@section('title', 'Portaria')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table table-api">
                <div class="table-responsive d-none">
                    <table data-toggle="table" id="table-api" data-table="portarias" data-click="false">
                        <thead class="thead-light">
                            <tr>
                                <th data-field="id" data-sortable="true" data-visible="false">#</th>
                                <th data-field="motorista">Motorista</th>
                                <th data-field="porteiro" data-visible="false">Portaria</th>
                                <th data-field="veiculo">Veiculo</th>
                                <th data-field="data">Data</th>
                                <th data-field="tipo">Tipo</th>
                                <th data-field="observacoes" data-visible="false">Observações</th>
                                <th data-field="files" data-formatter="filesFormatter">Files</th>

                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        function filesFormatter(value, row) {
            const base_url = $('meta[name="js-base_url"]').attr('content');
            var html = ``;

            if (value != '') {
                $.each(value, function(index, img) {
                    html += `
                        <a href="${base_url}/storage/${img}">
                            <img src="${base_url}/storage/${img}" width="20%">
                        </a>
                    `
                });
                return html;
            }
        }
    </script>
@endsection
@endsection
