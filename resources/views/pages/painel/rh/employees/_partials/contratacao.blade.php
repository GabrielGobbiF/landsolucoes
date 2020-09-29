<table class="table">
    <tbody>
        @foreach ($documentos['documentos_contratacao'] as $documento)
            <tr data-id="{{ $documento->employee_auditory_id }}" data-name="{{ $documento->name }}"
                data-type="contratacao">
                <th style="width: 44%"> <span data-toggle="tooltip" title=""> {{ $documento->description ?? '' }}</span>
                </th>
                <th class="text-center">
                    <div class="form-group">
                        <div class="radio">
                            @if ($documento->applicable == '0')
                                <div class="radio_applicable_{{ $documento->employee_auditory_id }}">
                                    <label style="margin-right:5px">
                                        <input type="checkbox" class="applicable" value="{{ $documento->employee_auditory_id }}" />
                                        Aplicável
                                    </label>
                                </div>

                                <div style="display:none" class="radio_applicable_{{ $documento->employee_auditory_id }}"
                                    id="yesorno_{{ $documento->employee_auditory_id }}">
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
                                </div>
                            @else
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
                            @endif
                        </div>
                    </div>
                </th>
                @if ($documento->status == '1' && $documento->document_link != '')
                    @php
                    $usuario = Auth::user()->where('id', $documento->update_by)->first();
                    $nome_usuario = $usuario->name;
                    $data_enviada = date('d/m/Y H:i', strtotime($documento->updated_at));
                    $doc = '<a href=""> ver </a>'
                    @endphp
                    <th class="text-center">
                        <span style="font-size:13px"> documento enviado por {{ $nome_usuario }} em {{ $data_enviada }}
                            <a target="_blank" href="{{ env('APP_URL') . '/storage/' . $documento->document_link }}">
                                ver </a><span>
                    </th>
                @else
                    <th> </th>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
