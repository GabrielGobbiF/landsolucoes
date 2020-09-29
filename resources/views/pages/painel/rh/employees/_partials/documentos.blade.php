<table class="table">
    <tbody>
        @foreach ($documentos['documentos_docs'] as $documento)
            <tr data-id="{{ $documento->employee_auditory_id }}" data-name="{{ $documento->name }}"
                data-type="documentos">
                <th > <span data-toggle="tooltip" title=""> {{ $documento->description ?? '' }}</span>
                </th>
                <th style="width: 44%" class="text-center">
                    <div class="form-group">
                        <div class="radio">
                            <label style="margin-right:5px">
                                <input type="radio" data-collumn="status" class="status"
                                    name="status_{{ $documento->employee_auditory_id }}"
                                    id="option_sim_{{ $documento->employee_auditory_id }}" value="1"
                                    {{ $documento->status == '1' ? 'checked' : '' }} />
                                Sim
                            </label>
                            @if ($documento->status != '1')
                                <label>
                                    <input type="radio" data-collumn="status" class="status"
                                        name="status_{{ $documento->employee_auditory_id }}"
                                        id="option_nao_{{ $documento->employee_auditory_id }}" value="0"
                                        {{ $documento->status == '0' ? 'checked' : '' }} />
                                    Não
                                </label>
                            @endif
                        </div>
                    </div>
                </th>
                @if ($documento->status == '1' && $documento->document_link != '')
                    <th class="text-center">
                        <span style="font-size:13px"> documento enviado por {{ $documento->user_envio }} em
                            {{ $documento->data_envio }}
                            <a target="_blank" href="{{ $documento->document_link }}">
                                ver </a><span>
                    </th>
                @else
                    <th> </th>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
