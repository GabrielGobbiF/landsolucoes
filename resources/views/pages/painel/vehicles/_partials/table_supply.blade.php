<div class="card">
    <div id="toolbar-supply">
        <h4 class="header mt-0">Abastecimento</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table data-toggle="table" id="table" class="table table-borderless" data-search="true"
                    data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-cookie="true"
                    data-cookie-id-table="vehicles" data-buttons-class="dark" data-toolbar="#toolbar-supply">
                    <thead style="border-bottom: 1px solid rgba(0, 0, 0, 0.125)">
                        <tr>
                            <th>#</th>
                            <th style="width: 34%">Descrição</th>
                            <th>KM</th>
                            <th class="text-center">Nota Fiscal</th>
                            <th class="text-center">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($abastecimento as $supply)
                            <tr>
                                <td>{{ $supply->id }}</td>
                                <td>
                                    <a href="javascript:void(0);">
                                        {{ ucfirst($supply->title) }}
                                    </a>
                                    <br>
                                    <small>Motorista: <b>{{ $supply->driver_name }} </b></small>
                                </td>
                                <td>{{ $supply->km_start ?? '' }}</td>

                                @if ($supply->nota_fiscal != '')
                                    <td class="text-center"><a href="{{ asset('storage/' . $supply->nota_fiscal) }}" target="_blank"> ver </a></td>
                                @else
                                    <td></td>
                                @endif

                                <td class="text-center">{{ \Carbon\Carbon::parse($supply->created_at)->format('d/m/Y H:i:s') ?? '' }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
