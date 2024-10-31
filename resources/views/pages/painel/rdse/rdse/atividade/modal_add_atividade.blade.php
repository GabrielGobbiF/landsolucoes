<div id="modaladdItemsModal" class="modal fade" tabindex="-1" aria-labelledby="addItemsModalLabel" aria-hidden="true">
    <input id="routeAddAtividade" type="hidden" value="{{ route('api.rdse.index') }}">
    <input id="modalrdseId" type="hidden">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="addItemsModalLabel" class="modal-title">Adicionar Itens</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="itensForNewAtividade" action="" method="POST">
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
                                @foreach (equipes() as $equipe)
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
                        <button type="button" class="btn btn-primary" onclick="submitForm()">Salvar</button>
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

        function submitForm() {
            const route = $('#routeAddAtividade').val();
            const id = $('#modalrdseId').val();

            // Seleciona o formulário pelo ID
            const form = document.getElementById('itensForNewAtividade');

            // Cria um FormData para coletar os dados do formulário
            const formData = new FormData(form);

            // Converte o FormData para um objeto simples, pois o Axios prefere trabalhar com JSON
            let data = {};
            formData.forEach((value, key) => {
                if (key.includes('itens')) {
                    // Dividir as chaves para transformar em array de objetos
                    const [_, index, field] = key.match(/itens\[(\d+)]\[(.*)]/);

                    if (!data.itens) {
                        data.itens = [];
                    }
                    if (!data.itens[index]) {
                        data.itens[index] = {};
                    }
                    data.itens[index][field] = value;
                } else {
                    data[key] = value;
                }
            });

            if (data.itens) {
                data.itens = data.itens.filter(item => item !== null && item !== undefined);
            }

            // Enviar via Axios (alterar para a URL correta da sua aplicação)
            axios.post(`${route}/${id}/atividades`, data)
                .then(function(response) {
                    // Lógica de sucesso (por exemplo, mostrar um alerta)
                    alert('Segmento salvo com sucesso!');
                    // Limpar o formulário após o sucesso
                    clearForm();
                })
                .catch(function(error) {
                    // Lógica de erro (mostrar mensagens de erro)
                    if (error.response && error.response.data && error.response.data.errors) {
                        let errors = error.response.data.errors;
                        let errorMessages = '';
                        Object.keys(errors).forEach(key => {
                            errorMessages += errors[key].join(' ') + '\n';
                        });
                        alert(errorMessages);
                    } else {
                        console.log(error);
                        alert('Ocorreu um erro inesperado. Tente novamente.');
                    }
                });
        }

        function clearForm() {
            const form = document.getElementById('itensForNewAtividade');

            // Reseta todos os campos do formulário
            form.reset();

            // Seleciona todos os campos de itens e mantém apenas o primeiro (poderia remover todos e adicionar um vazio, depende do contexto)
            const itensContainer = document.querySelector('#itemsTable tbody');
            itensContainer.innerHTML = '';
            adicionarLinha();

        }

        function adicionarLinha() {

            const tableBody = document.querySelector('#itemsTable tbody');
            const rowCount = tableBody.rows.length + 1;

            console.log(rowCount);

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

            if (tableBody.rows.length == 0) {
                tableBody.insertBefore(newRow, tableBody.children[0]);
            } else {
                tableBody.appendChild(newRow); // Caso não tenha linha alguma, apenas adiciona ao fim
            }

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
