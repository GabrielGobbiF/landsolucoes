@extends('app')

@section('title', 'Portaria')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">

                <div class="col-auto align-self-center">
                    <span class="pos-relative t-10">Agrupar por: </span>
                </div>

                <div class="col-md-3">
                    <label for="fl_art_nome">Motorista</label>
                    <select id="obra-select_driver_id" name="driver_id" class="form-control select2 search-input">
                        <option value="" selected>Selecione</option>
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->id }}"> {{ $driver->re }} - {{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="fl_art_nome">Veiculos</label>
                    <select id="obra-select_vehicle_id" name="vehicle_id" class="form-control select2 search-input">
                        <option value="" selected>Selecione</option>
                        @foreach ($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}"> {{ $vehicle->name }} - {{ $vehicle->board }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="fl_art_nome">Data</label>
                    <input id="input--at" type="date" name="at" class="form-control search-input">
                </div>

                <div class="col-md-3 justify-content-end align-self-center mg-t-25">
                    <a href="{{ route('vehicles.portaria') }}" class="btn btn-dark btn-empty-search">Limpar </a>
                </div>

            </div>
        </div>

        <div class="card-body">
            <div class="table table-api">
                <div class="table-responsive d-none">
                    <table id="table-api" data-toggle="table" data-table="portarias" data-click="false">
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
@endsection
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

    <script>
        $(function() {
            $('.search-input').on('change keyup', function() {
                time = setTimeout(function() {
                    initTable();
                }, 1200);
            });
        })
    </script>
@append
