<div class="card text-start">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-4">
            <h4 class="card-title">Atividades</h4>
            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#addItemsModal">
                <i class="fa-solid fa-plus"></i>
                Adicionar
            </button>
        </div>
        <div class="table-responsive">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Data</th>
                        <th scope="col">Inicio</th>
                        <th scope="col">Fim</th>
                        <th scope="col">Equipe</th>
                        <th scope="col">Executado</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($atividades as $atividade)
                        <tr>
                            <td>{{ $atividade->id }}</td>
                            <td>{{ $atividade->atividade }}</td>
                            <td>{{ $atividade->data }}</td>
                            <td>{{ $atividade->data_inicio }}</td>
                            <td>{{ $atividade->data_fim }}</td>
                            <td>{{ $atividade->equipe->name }}</td>
                            <td>{{ empty($atividade->execucao) ? 'Não' : 'Sim' }}</td>
                            <td>
                                <a href="{{ route('rdse.atividades.show', $atividade->id) }}" class="">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="addItemsModal" class="modal fade" tabindex="-1" aria-labelledby="addItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="addItemsModalLabel" class="modal-title">Adicionar Itens</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="itensForNewAtividade" action="{{ route('rdse.atividades.store', $rdse->id) }}" method="POST">
                    @csrf
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="input--description">Atividade</label>
                            <select id="rdse-select_status_execution" name="status_execution" class="form-control" required tabindex="1">
                                <option value="">Selecione </option>
                                @foreach (trans('rdses.status_execution') as $status_execution)
                                    <option value='{{ $status_execution }}'>
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
                                    <option value='{{ $equipe->id }}'>
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
                                <input id="dataInput" tabindex="2" type="date" name="data" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="inicioInput" class="form-label">Início</label>
                                <input id="inicioInput" tabindex="3" type="time" name="inicio" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="fimInput" class="form-label">Fim</label>
                                <input id="fimInput" tabindex="4" type="time" name="fim" class="form-control" required>
                            </div>
                        </div>
                    </div>

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
                                    <tr>
                                        <td>
                                            <select id="select--itens-1" name="itens[1][id]" class="form-control select-item select-itens-1 t-select "
                                                    data-request="handswork" data-value-field="id" placeholder="Digite para pesquisar">
                                            </select>
                                        </td>
                                        <td style="text-align: end">
                                            <button type="button" class="btn btn-danger removeRowBtn">&times;</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="button" class="btn btn-outline-primary btn-sm mt-3" onclick="adicionarLinha()">Adicionar Nova Linha</button>
                        </div>

                    </div>
                    <div class="col-12 col-md-12 mt-4">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')

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
                    <select id="select--itens-${rowCount}" name="itens[${rowCount}][id]" class="form-control select-item select-itens-${rowCount} t-select "
                            data-request="handswork" data-value-field="id" placeholder="Digite para pesquisar">
                    </select>
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
@append
