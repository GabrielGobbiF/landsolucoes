<div class="cursos">
    <table class="table">
        <tbody>
            @foreach ($documentos['cursos'] as $documento)
                <tr data-id="{{ $documento->id }}" data-name="{{ $documento->name }}" data-type="cursos">
                    <th style="width: 18%"> <span data-toggle="tooltip" title="">
                            {{ $documento->description ?? '' }}
                        </span>
                    </th>
                    <th class="text-center" style="width: 30%">
                        <label style="margin-right:5px">
                            <input type="radio" data-collumn="status"
                                class="{{ $documento->status != '1' ? 'status' : '' }}"
                                name="status_{{ $documento->id }}" id="option_sim_{{ $documento->id }}" value="1"
                                {{ $documento->status == '1' ? 'checked' : '' }} />
                            Sim
                        </label>

                        @if ($documento->status != '1')
                            <label>
                                <input type="radio" data-collumn="status" name="status_{{ $documento->id }}"
                                    id="option_nao_{{ $documento->id }}" value="0"
                                    {{ $documento->status == '0' ? 'checked' : '' }} />
                                Não
                            </label>
                        @endif
                    </th>
                    @if ($documento->data_vigencia_curso != '')
                        <th style="width: 15%"> <span data-toggle="tooltip" title="">
                                Vencimento {{ $documento->data_vigencia_curso ?? '' }}
                            </span>
                        </th>
                    @else
                        <th style="width: 15%"> <span data-toggle="tooltip" title="">
                            </span>
                        </th>
                    @endif

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

                    @if ($documento->status != '1')
                        <th style="width: 15%">
                            <!-- <a href="JavaScript:void(0)" data-toggle="tooltip" data-placement="top" title="Retirar"
                                data-href="" class="btn btn-sm btn-danger btn-delete">
                                <i class="fa fa-trash"></i>
                            </a>-->
                        </th>
                    @else
                        <th style="text-align:right">
                            <a href="JavaScript:void(0)" data-toggle="tooltip" data-placement="top"
                                title="Pedir alteração" data-href="" class="btn btn-sm btn-danger btn-dark">
                                <i class="fa fa-question-circle"></i>
                            </a>
                        </th>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
