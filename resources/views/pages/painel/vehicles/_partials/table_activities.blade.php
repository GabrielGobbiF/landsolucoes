<div class="card">
    <div id="toolbar-activitys">
        <h4 class="header mt-0">Atividades</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table data-toggle="table" id="table" class="table table-borderless" data-search="true"
                    data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-cookie="true"
                    data-cookie-id-table="vehicles" data-buttons-class="dark" data-toolbar="#toolbar-activitys">
                    <thead style="border-bottom: 1px solid rgba(0, 0, 0, 0.125)">
                        <tr>
                            <th>#</th>
                            <th>Descrição</th>
                            <th>Tipo</th>
                            <th>Obra</th>
                            <th>KM</th>
                            <th class="text-center">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($atividade as $activitys)
                            <tr>
                                <td>{{ $activitys->id }}</td>
                                <td>
                                    <a href="javascript:void(0);" onclick="editHistorico(2666)">
                                        {{ ucfirst($activitys->title) }}
                                    </a>
                                    <br>
                                    <small>Motorista: <b>{{ $activitys->driver_name }} </b></small>
                                </td>
                                <td>
                                    {{ ucfirst($activitys->type) }}
                                    <br>
                                    <small>para: <b>{{ $activitys->description }} </b></small>
                                </td>
                                @if ($activitys->obra_id != '')
                                    <td>
                                        <a href="http://www.landsolucoes.com.br/obras/edit/{{ $activitys->obra_id }}" target="_blank"> {{ $activitys->obr_razao_social }} </a>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                                <td>{{ $activitys->km_start ?? '' }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($activitys->created_at)->format('d/m/Y h:i:s') ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
