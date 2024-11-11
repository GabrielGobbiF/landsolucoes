@csrf

<div class="row">
    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="input--description">Atividade</label>
            <select id="rdse-select_status_execution" name="status_execution" class="form-control" required tabindex="1">
                <option value="">Selecione </option>
                @foreach (trans('rdses.status_execution') as $status_execution)
                    <option {{ $rdseAtividade->atividade_descricao == $status_execution ? 'selected' : null }} value='{{ $status_execution }}'>
                        {{ $status_execution }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="rdse-supervisor">Supervisor</label>
            <select id="rdse-supervisor" name="supervisor_id" class="form-control" required tabindex="1">
                <option value="">Selecione </option>
                @foreach (supervisores() as $supervisor)
                    <option {{ $rdseAtividade->supervisor_id == $supervisor->id ? 'selected' : null }} value='{{ $supervisor->id }}'>
                        {{ $supervisor->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="rdse-encarregado">Encarregado</label>
            <select id="rdse-encarregado" name="encarregado_id" class="form-control" required tabindex="1">
                <option value="">Selecione </option>
                @foreach (encarregados() as $encarregado)
                    <option {{ $rdseAtividade->encarregado_id == $encarregado->id ? 'selected' : null }} value='{{ $encarregado->id }}'>
                        {{ $encarregado->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="rdse-encarregado">Veiculo</label>
            <select id="select--veiculo_id" name="veiculo_id" class="form-control select-veiculo_id t-select " data-request="{{ route('vehicles.all') }}"
                    data-value-field="id" required>
                <option value='{{ $rdseAtividade->encarregado_id }}'>
                    {{ $rdseAtividade->veiculo?->board }}
                </option>
            </select>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="input--description">Equipe</label>
            <select id="rdse-select_equipe" name="equipe_id" class="form-control" required tabindex="1">
                <option value="">Selecione </option>
                @foreach ($equipes as $equipe)
                    <option {{ $rdseAtividade->equipe_id == $equipe->id ? 'selected' : null }} value='{{ $equipe->id }}'>
                        {{ $equipe->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="rdse-diretoria">Diretoria</label>
            <select id="rdse-diretoria" name="diretoria" class="form-control" required tabindex="1">
                <option value="">Selecione </option>
                <option {{ $rdseAtividade->diretoria == 'PM' ? 'selected' : null }} value='PM'>PM </option>
                <option {{ $rdseAtividade->diretoria == 'HV' ? 'selected' : null }} value='HV'>HV </option>
            </select>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="rdse-civil">Civil</label>
            <select id="rdse-civil" name="civil" class="form-control" required tabindex="1">
                <option value="">Selecione </option>
                <option {{ $rdseAtividade->civil == '1' ? 'selected' : null }} value='1'>Sim </option>
                <option {{ $rdseAtividade->civil == '0' ? 'selected' : null }} value='0'>Não </option>
            </select>
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <label for="dataInput" class="form-label">Data</label>
                <input id="dataInput" tabindex="2" name="data" class="form-control date" value="{{ $rdseAtividade->data }}" required>
            </div>
            <div class="col-md-4">
                <label for="inicioInput" class="form-label">Início</label>
                <input id="inicioInput" tabindex="3" type="time" name="inicio" class="form-control" value="{{ $rdseAtividade->data_inicio }}" required>
            </div>
            <div class="col-md-4">
                <label for="fimInput" class="form-label">Fim</label>
                <input id="fimInput" tabindex="4" type="time" name="fim" class="form-control" value="{{ $rdseAtividade->data_fim }}" required>
            </div>
        </div>
    </div>

    <div class="col-12 mt-4">
        <label for="atividades" class="form-label">Atividades</label>
        <textarea id="atividades" name="atividades" cols="30" rows="10" class="form-control">{{ $rdseAtividade->atividades }}</textarea>
    </div>

    {{--
<div class="card text-start">
    <div class="card-body">
        <h4 class="card-title mb-4">Adicionar Atividades</h4>
        <table id="itemsTable" class="table">
            <thead>
                <tr>
                    <th>Atividade</th>
                    <th style="text-align: end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($itens as $item)
                    <tr>
                        <td>
                            <input type="text" name="itens[{{ $item->id }}][id]" class="form-control" value="{{ $item->description }}">
                        </td>
                        <td style="text-align: end">
                            <button type="button" class="btn btn-danger removeRowBtn">&times;</button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        @if ($rdseAtividade->canUpdate())
            <button type="button" class="btn btn-outline-primary btn-sm mt-3" onclick="adicionarLinha()">Adicionar Nova Linha</button>
        @endif
    </div>
</div>
--}}

    <div class="col-12 col-md-12 mt-4">
        <label>Executação</label>

        <div class="form-check">
            <input id="ex" class="form-check-input form-exec" type="radio" name="executado" value="true"
                   {{ !empty($rdseAtividade->execucao) ? 'checked' : null }} required />
            <label class="form-check-label" for="ex"> Executado </label>
        </div>
        <div class="form-check mb-3">
            <input id="nex" class="form-check-input form-exec" value="false" type="radio" name="executado"
                   {{ empty($rdseAtividade->execucao) ? 'checked' : null }} required />
            <label class="form-check-label" for="nex">
                Não Executado
            </label>
        </div>
        <span class="tx-danger mt-3 d-none mgs-exc">*Se você confirmar essa operação essa atividade não poderá ser mais alterada</span>
    </div>
</div>
@section('scripts')

    <script class="">
        document.addEventListener('DOMContentLoaded', function() {
            // Seleciona os radios e a mensagem
            const radios = document.querySelectorAll('.form-exec');
            const message = document.querySelector('.mgs-exc');

            // Função para mostrar ou ocultar a mensagem
            function toggleMessage() {
                const isExecuted = document.querySelector('input[name="executado"]:checked').value === 'true';
                if (isExecuted) {
                    message.classList.remove('d-none');
                } else {
                    message.classList.add('d-none');
                }
            }

            // Adiciona o evento de mudança nos radios
            radios.forEach(radio => {
                radio.addEventListener('change', toggleMessage);
            });

            // Executa a função ao carregar a página para definir o estado inicial da mensagem
            toggleMessage();
        });
    </script>
    {{--
    <script>
        document.querySelectorAll('.removeRowBtn').forEach(button => {
            addRemoveEvent(button);
        });

        function adicionarLinha() {

            const tableBody = document.querySelector('#itemsTable tbody');
            const rowCount = tableBody.rows.length + 1;

            const newRow = document.createElement('tr');
            newRow.setAttribute('data-id', rowCount);

            newRow.innerHTML = `
            <tr>
                <td>
                    <input type="text" name="itens[${rowCount}][id]" class="form-control" >
                </td>
                <td style="text-align: end">
                    <button type="button" class="btn btn-danger removeRowBtn">&times;</button>
                </td>
            </tr>`;

            tableBody.appendChild(newRow);

            // Adiciona o evento de remoção ao novo botão
            const newButton = newRow.querySelector('.removeRowBtn');
            addRemoveEvent(newButton);

            newSelect(document.getElementById(`select--itens-${rowCount}`));
        }

        function addRemoveEvent(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const tr = this.closest('tr');
                if (tr) {
                    tr.remove();
                    calculateSubTotal(); // Recalcula o subtotal após remover a linha
                }
            });
        }
    </script>
    --}}
@append
