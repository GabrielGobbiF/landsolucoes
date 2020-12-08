<div class="card">
    <div id="toolbar-maintenance">
        <h4 class="header mt-0">Manutenção</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table data-toggle="table" id="table" class="table table-borderless" data-search="true"
                    data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-cookie="true"
                    data-cookie-id-table="vehicles" data-buttons-class="dark" data-toolbar="#toolbar-maintenance">
                    <thead style="border-bottom: 1px solid rgba(0, 0, 0, 0.125)">
                        <tr>
                            <th>#</th>
                            <th>Descrição</th>
                            <th>KM Aberto</th>
                            <th>Aberto Por</th>
                            <th class="text-center">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($manutencao as $maintenance)
                            <tr>
                                <td>{{ $maintenance->id }}</td>
                                <td>{{ ucfirst($maintenance->description) }}</td>
                                <td>{{ $maintenance->km_start }}</td>
                                <td>{{ $maintenance->driver_name }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($maintenance->created_at)->format('d/m/Y h:i:s') ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
