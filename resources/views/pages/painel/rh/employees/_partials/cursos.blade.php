<div class="acompanhamentoOrCurso">
    <table class="table">
        <tbody>
            @if (isset($documentos['cursos']) && count($documentos['cursos']) > 0)
                @foreach ($documentos['cursos'] as $documento)
                    <tr data-id="{{ $documento->id }}" data-name="{{ $documento->name }}" data-type="cursos">
                        <th style="width: 44%"> <span data-toggle="tooltip" title="">
                                {{ $documento->description ?? '' }}
                            </span>
                        </th>
                        <th class="text-center">
                            @if ($documento->along_month == true)
                                <div class="form-group">
                                    <div class="radio">
                                        <a href="#" data-id="{{ $documento->id }}" class="visibility_auditory_month"
                                            data-type="cursos">Visualizar</a>
                                    </div>
                                </div>
                            @else
                                <label style="margin-right:5px">
                                    <input type="radio" data-collumn="status" class="status"
                                        name="status_{{ $documento->id }}" id="option_sim_{{ $documento->id }}"
                                        value="1" {{ $documento->status == '1' ? 'checked' : '' }} />
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
                            @endif
                        </th>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    @if (count($cursosInEmployee) > 0)
        <div class="card mt-5">
            <h5 class="text-center pt-3"> Adicionar curso ao funcionario </h5>
            <div class="card-body">
                <form action="{{ route('employees.auditory.store', $employee->uuid) }}" method="POST">
                    @csrf
                    <select multiple="multiple" size="20" name="cursos[]" id="cursos_employee" required>
                        @foreach ($cursosInEmployee as $curso)
                            <option value="{{ $curso->id }}"> {{ $curso->description }}</option>
                        @endforeach
                    </select>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fas fa-edit"></i>
                            Salvar
                        </button>

                    </div>
                </form>
            </div>
        </div>
    @endif
</div>


@include('pages.painel.rh.employees._partials.mothOrYear')
