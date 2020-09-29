<table class="table">
    <tbody>
        @foreach ($documentos['documentos_acompanhamento'] as $documento)
            <tr data-id="{{ $documento->employee_auditory_id }}" data-name="{{ $documento->name }}"
                data-type="contratacao">
                <th style="width: 44%"> <span data-toggle="tooltip" title=""> {{ $documento->description ?? '' }}</span>
                </th>
                <th class="text-center">
                    <div class="form-group">
                        <div class="radio">
                            <a href="#" style="margin-right:5px">

                                Visualizar
                            </a>

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
