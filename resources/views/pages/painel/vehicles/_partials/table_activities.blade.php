<div class="card">
    <div id="toolbar-activitys">
        <h4 class="header mt-0">Atividades</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table data-toggle="table" id="table" class="table table-hover" data-search="true"
                    data-pagination="true" data-page-list="[10, 25, 50, 100, all]" data-cookie="true"
                    data-cookie-id-table="vehicles" data-buttons-class="dark" data-toolbar="#toolbar-activitys">
                    <thead>
                        <tr>
                            <th colspan="4" data-halign="center">Saida</th>
                            <th colspan="3" data-halign="center">Retorno</th>
                        </tr>

                        <tr>
                            <th>#</th>
                            <th>Descrição</th>
                            <th data-halign="center">KM Saída</th>
                            <th data-halign="center">Data Saida</th>

                            <th data-halign="center">KM Retorno</th>
                            <th data-halign="center">Data Retorno</th>
                            <th data-halign="right">Retorno</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($atividade as $activity)
                            <tr>
                                <td>{{ $activity->id }}</td>

                                <!-- Saida -->
                                <td>
                                    {{ ucfirst($activity->type) }}
                                    <br>
                                    <small>para: <b>{{ $activity->description }}</b></small>
                                    @if ($activity->obra_id != '')
                                        <a href="http://www.landsolucoes.com.br/obras/edit/{{ $activity->obra_id }}" target="_blank"> {{ $activity->obr_razao_social }} </a>
                                    @else
                                        {{ $activity->observation }}
                                    @endif
                                    <br>
                                    <small>motorista: <b>{{ $activity->driver_name }}</b></small>
                                </td>
                                <td class="text-center">{{ $activity->km_start ?? '' }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($activity->created_at)->format('d/m/Y h:i:s') ?? '' }}</td>

                                <!-- retorno -->

                                @if ($activity->status == '0')
                                    <td colspan="3" class="text-center">
                                        <span class="badge-{{ $activity->status == '0' ? 'danger' : 'success' }} badge mr-2">
                                            {{ $activity->status == '0' ? 'em aberto' : 'finalizado' }}
                                        </span>
                                    </td>
                                @else
                                    <td class="text-center">{{ $activity->km_end ?? '' }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($activity->updated_at)->format('d/m/Y h:i:s') ?? '' }}</td>
                                    <td class="text-right">
                                        Retorno
                                        <br>
                                        <small>para: <b>{{ $activity->description_return }}</b></small>
                                        <br>
                                        <small>motorista: <b>{{ $activity->driver_name }}</b></small>
                                    </td>
                                @endif
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
