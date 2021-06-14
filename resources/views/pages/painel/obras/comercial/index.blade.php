@extends("app")

@section('title', 'Comercial')

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
                            <a href="{{ route('comercial.create') }}" class="btn btn-dark waves-effect waves-light">
                                <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                            </a>
                        </div>
                    </div>
                </div>
                <table data-toggle="table" id="table" data-table="comercial">
                    <thead>
                        <tr>
                            <th data-field="id" data-sortable="true" data-visible="false">#</th>
                            <th data-field="razao_social">Razão Social</th>
                            <th data-field="client.name">Cliente</th>
                            <th data-field="concessionaria.name">Concessionaria</th>
                            <th data-field="service.name">Serviço</th>
                            <th data-field="statusButton" data-align="center" data-formatter="nameFormatter">Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        function nameFormatter(value, row) {
            var html = '';

            var data = [
                'elaboração',
                'enviada',
                'aprovada',
                'recusada',
            ];

            html += '<select class="form-control select2" onchange="updateStatus(this)" data-value="' + row.statusButton + '" data-name="' + row.razao_social + '" data-id="' + row.id + '" >';
            $.each(data, function(k, field) {
                var selected = value == field ? "selected='selected'" : "";
                const capitalized = field[0].toUpperCase() + field.substr(1);
                html += `<option ` + selected + ` value="` + field + `">` + capitalized + `</option>`;
            });
            html += '</select>';

            return html;
        }

        function updateStatus(v) {
            var id = $(v).attr('data-id');
            var name = $(v).attr('data-name');
            var value = $(v).attr('data-value');
            var status = $(v).val();
            if (status == 'aprovada') {
                Swal.fire({
                    title: 'Aprovação de Proposta',
                    text: 'Fazer o cadastro da obra: ' + name,
                    confirmButtonText: 'Aprovar',
                    allowOutsideClick: () => $(v).val(value)
                }).then((result) => {
                    if (result.isConfirmed) {

                    }
                })
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: BASE_URL + '/l/comercial/' + id + '/updateStatus',
                    type: 'POST',
                    data: {
                        status: status,
                    },
                    dataType: 'json',
                    error: function() {
                        toastr.error('error')
                    },
                });
            }

        }

    </script>
@endsection
@endsection
