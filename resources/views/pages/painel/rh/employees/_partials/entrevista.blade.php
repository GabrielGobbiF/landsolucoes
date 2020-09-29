<table class="table">
    <tbody>
        @foreach ($documentos['documentos_entrevista'] as $documento)
            <tr data-id="{{ $documento->employee_auditory_id }}" data-name="{{ $documento->name }}"
                data-type="entrevista">
                <th style="width: 44%"> <span data-toggle="tooltip" title=""> {{ $documento->description ?? '' }}</span>
                </th>
                <th class="text-center">
                    <div class="form-group">
                        <div class="radio">
                            @if ($documento->option_name == 'sim/não')
                                <label style="margin-right:5px">
                                    <input type="radio" data-collumn="status" class="status"
                                        name="status_{{ $documento->employee_auditory_id }}" id="option_sim_{{ $documento->employee_auditory_id }}"
                                        value="1" {{ $documento->status == '1' ? 'checked' : '' }} />
                                    Sim
                                </label>
                                @if ($documento->status != '1')
                                    <label>
                                        <input type="radio" data-collumn="status" class="status"
                                            name="status_{{ $documento->employee_auditory_id }}" id="option_nao_{{ $documento->employee_auditory_id }}"
                                            value="0" {{ $documento->status == '0' ? 'checked' : '' }} />
                                        Não
                                    </label>
                                @endif
                            @else
                                <label style="margin-right:5px">
                                    <input type="radio" data-collumn="status" class="status"
                                        name="status_{{ $documento->employee_auditory_id }}" id="option_sim_{{ $documento->employee_auditory_id }}"
                                        value="1" {{ $documento->status == '1' ? 'checked' : '' }} />
                                    Aprovado
                                </label>

                                @if ($documento->status != '1')
                                    <label>
                                        <input type="radio" data-collumn="status" class="status"
                                            name="status_{{ $documento->employee_auditory_id }}" id="option_nao_{{ $documento->employee_auditory_id }}"
                                            value="0" {{ $documento->status == '0' ? 'checked' : '' }} />
                                        Não Aprovado
                                    </label>
                                @endif
                            @endif
                        </div>
                    </div>
                </th>
                @if ($documento->status == '1' && $documento->document_link != '')
                    @php
                    $usuario = Auth::user()->where('id', $documento->updated_by)->first();
                    $nome_usuario = $usuario->name;
                    $data_enviada = date('d/m/Y H:i', strtotime($documento->updated_at));
                    $doc = '<a href=""> ver </a>'
                    @endphp
                    <th class="text-center">
                        <span style="font-size:13px"> documento enviado por {{ $nome_usuario }} em {{ $data_enviada }}
                        <a target="_blank" href="{{ env('APP_URL').'/storage/'.($documento->document_link) }}"> ver </a><span>
                    </th>
                @else
                <th> </th>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

