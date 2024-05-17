<div class="acompanhamentoOrCurso">
    <table class="table">
        <tbody>
            @foreach ($documentos['documentos_acompanhamento'] as $documento)
                <tr data-id="{{ $documento->id }}" data-name="{{ $documento->name }}"
                    data-type="Acompanhamento_mensal">
                    <th style="width: 44%"> <span data-toggle="tooltip" title="">
                            {{ $documento->description ?? '' }}
                        </span>
                    </th>
                    <th class="text-center">
                        @if ($documento->along_month == true)
                            <div class="form-group">
                                <div class="radio">
                                    <a href="#" data-id="{{ $documento->id }}"
                                        class="{{$documento->epi == 0 ? 'visibility_auditory_month' : 'visibility_auditory_epi'}}">Visualizar</a>
                                </div>
                            </div>
                        @else
                            <label style="margin-right:5px">
                                <input type="radio" data-collumn="status" class="status"
                                    name="status_{{ $documento->id }}"
                                    id="option_sim_{{ $documento->id }}" value="1"
                                    {{ $documento->status == '1' ? 'checked' : '' }} />
                                Sim
                            </label>

                            @if ($documento->status != '1')
                                <label>
                                    <input type="radio" data-collumn="status"
                                        name="status_{{ $documento->id }}"
                                        id="option_nao_{{ $documento->id }}" value="0"
                                        {{ $documento->status == '0' ? 'checked' : '' }} />
                                    Não
                                </label>
                            @endif
                        @endif
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('pages.painel.rh.employees._partials.mothOrYear')

