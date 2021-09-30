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
            <div class="row mb-3">
                <div class="col-12 col-md-5">
                    <label for="fl_art_nome">Status</label>
                    <select name="status" id="select--status" multiple class="form-control select2Multiple search-input">
                        @foreach (config('constants.status_build') as $status)
                            <option value="{{ $status }}"> {{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-auto justify-content-end align-self-center mg-t-25">
                    <button class="btn btn-dark btn-empty-search">Limpar </button>
                </div>
            </div>

            <div class="table table-responsive d-none"  style="font-size: 13px;">

                <div id="toolbar">
                    <div class="form-inline" role="form">
                        <div class="btn-group mr-2">
                            <a href="{{ route('comercial.create') }}" class="btn btn-dark waves-effect waves-light">
                                <i class="ri-add-circle-line align-middle mr-2"></i> Novo
                            </a>
                        </div>
                    </div>
                </div>
                <table data-toggle="table" id="table-api" data-table="comercial">
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

    <div class="modal" data-backdrop="static" id="modal-approved-comercial" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="form-approved-comercial" role="form" class="needs-validation" action="{{ route('comercial.approved') }}" method="POST">
                    <input type="hidden" name="comercial_id" id="comercial_id">
                    @csrf
                    <div class="modal-header text-center">
                        <h5 class="modal-title">Aprovação de Proposta</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="users">Mandar notificação para: </label>
                                <select name="users[]" id="users" class="form-control select--users" placeholder="o" multiple> </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Aprovar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            if (localStorage.getItem('select--status')) {
                $('#select--status').val(JSON.parse(localStorage.getItem('select--status'))).trigger('change');
            }

            if($('#select--status').val != ''){
                initTable();
            }

            let timeSearchComercial = 0;
            $('.search-input').on('change keyup', function() {
                const value = $(this).val();
                const id = $(this).attr('id');
                localStorage.setItem(id, JSON.stringify(value));

                clearTimeout(timeSearchComercial);
                timeSearchComercial = setTimeout(function() {
                    initTable();
                }, 1200);
            });

            $(".select--users").select2({
                dropdownParent: $("#modal-approved-comercial"),
                multiple: true,
                minimumInputLength: 3,
                language: "pt-br",
                formatNoMatches: function() {
                    return "Pesquisa não encontrada";
                },
                inputTooShort: function() {
                    return "Digite para Pesquisar";
                },
                ajax: {
                    url: `{{ route('users.all') }}`,
                    dataType: 'json',
                    data: function(term, page) {
                        console.log(term);
                        return {
                            q: term, //search term
                        };
                    },
                    processResults: function(data, page) {
                        var myResults = [];
                        $.each(data.data, function(index, item) {
                            myResults.push({
                                'id': item.id,
                                'text': item.name
                            });
                        });
                        return {
                            results: myResults
                        };
                    }
                },
                escapeMarkup: function(m) {
                    return m;
                }
            });
        })

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

                var $modal = $('#modal-approved-comercial');
                $modal.find('.modal-title').html('Aprovar Proposta - "' + name + '"');
                $modal.find('#comercial_id').val(id);
                $modal.modal('show');

                $modal.on('hidden.bs.modal', function(e) {
                    $(v).val(value)
                    $(".select--users").empty();
                })

            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `${base_url}/l/comercial/${id}/updateStatus`,
                    type: 'POST',
                    data: {
                        status: status,
                    },
                    dataType: 'json',
                    error: function(jqXHR) {
                        toastr.error(jqXHR.responseJSON.message ?? 'error')
                    },
                });
            }
        }
    </script>
@endsection
