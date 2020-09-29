<div class="acompanhamento-mensal ">
    <table class="table">
        <tbody>
            @foreach ($documentos['documentos_acompanhamento'] as $documento)
                <tr data-id="{{ $documento->employee_auditory_id }}" data-name="{{ $documento->name }}"
                    data-type="contratacao">
                    <th style="width: 44%"> <span data-toggle="tooltip" title="">
                            {{ $documento->description ?? '' }}
                        </span>
                    </th>
                    <th class="text-center">
                        @if ($documento->along_month == true)
                            <div class="form-group">
                                <div class="radio">
                                    <a href="#" data-id="{{ $documento->employee_auditory_id }}"
                                        class="visibility_auditory_month">Visualizar</a>
                                </div>
                            </div>
                        @else
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
                        @endif
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="table-mensal d-none">
    <table class="table text-center">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h3 class="title_table--mensal"> </h3>
            <div class="float-right">
                <button class="btn btn-xs btn-primary back">
                    <i class="fas fa-long-arrow-alt-left"></i>
                    Voltar
                </button>
            </div>
        </div>
        <thead>
            <tr>
                <th scope="col">Mês</th>
                <th scope="col">Status</th>
                <th scope="col">Documento</th>
            </tr>
        </thead>
        <tbody id="rows_table--mensal"></tbody>
    </table>
</div>
