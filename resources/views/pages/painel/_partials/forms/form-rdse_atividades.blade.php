@csrf
<div class="col-12 col-md-12">
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

<div class="col-12 col-md-12">
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
    <textarea name="atividades" id="atividades" cols="30" rows="10" class="form-control">{{$rdseAtividade->atividades}}</textarea>
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
        <input id="ex" class="form-check-input" type="radio" name="executado" value="true" {{ !empty($rdseAtividade->execucao) ? 'checked' : null }}
               required />
        <label class="form-check-label" for="ex"> Executado </label>
    </div>
    <div class="form-check">
        <input id="nex" class="form-check-input" value="false" type="radio" name="executado" {{ empty($rdseAtividade->execucao) ? 'checked' : null }}
               required />
        <label class="form-check-label" for="nex">
            Não Executado
        </label>
    </div>
</div>

@section('scripts')

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
