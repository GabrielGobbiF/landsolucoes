<div id="modaladdItemsModal" class="modal fade" tabindex="-1" aria-labelledby="addItemsModalLabel" aria-hidden="true">
    <input id="routeAddAtividade" type="hidden" value="{{ route('api.rdse.index') }}">
    <input id="modalrdseId" type="hidden">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <div class="d-flex justify-content-between mb-4">
                    <h4 class="card-title">Atividades</h4>
                    <button id="toggleBtn" class="btn btn-outline-primary">
                        <i class="fa-solid fa-plus"></i>
                        Adicionar
                    </button>
                </div>

                <div id="itemList" class="divAtividadesRdse">
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

                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="addItemForm" class="d-none">
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

                        <div class="col-12 mt-4">
                            <label for="atividades" class="form-label">Atividades</label>
                            <textarea id="atividades" name="atividades" cols="30" rows="10" class="form-control"></textarea>
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
                                        <tr>
                                            <td>
                                                {{--
                                                <select id="select--itens-1" name="itens[1][id]" class="form-control select-item select-itens-1 t-select "
                                                        data-request="{{ route('handswork.all') }}" data-value-field="id" placeholder="Digite para pesquisar">
                                                </select>

                                                <input type="text" name="itens[1][id]" class="form-control" placeholder="Nome da Atividade">
                                            </td>
                                            <td style="text-align: end">
                                                <button type="button" class="btn btn-danger removeRowBtn">&times;</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button id="addItemLine" type="button" class="btn btn-outline-primary btn-sm mt-3">Adicionar Nova Linha</button>
                            </div>
                        </div>
                        --}}
                        <div class="col-12 col-md-12 mt-4">
                            <label>Executação</label>

                            <div class="form-check">
                                <input id="ex" class="form-check-input" type="radio" name="executado" value="true" required />
                                <label class="form-check-label" for="ex"> Executado </label>
                            </div>
                            <div class="form-check">
                                <input id="nex" class="form-check-input" type="radio" value="false" name="executado" checked required />
                                <label class="form-check-label" for="nex">
                                    Não Executado
                                </label>
                            </div>
                        </div>

                        <div class="col-12 col-md-12 mt-4">
                            <button id="submitForm" type="button" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')

    <script>
        $('#toggleBtn').on('click', toggleForm);


        function toggleForm() {
            const isFormVisible = $('#addItemForm').hasClass('d-none');
            console.log(isFormVisible);

            if (isFormVisible) {
                $('#itemList').addClass('d-none');
                $('#addItemForm').removeClass('d-none');
                $('#toggleBtn').text('Cancelar');
            } else {
                $('#addItemForm').addClass('d-none');
                $('#itemList').removeClass('d-none');
                $('#toggleBtn').text('Adicionar Item');
            }
        }

        $('#modaladdItemsModal').on('shown.bs.modal', function() {
            const route = $('#routeAddAtividade').val();
            const id = $('#modalrdseId').val();

            $('#addItemForm').addClass('d-none');
            $('#itemList').removeClass('d-none');
            $('#toggleBtn').text('Adicionar Item');

            function carregarAtividades() {

                axios.get(`${route}/${id}/atividades`) // Substitua 'URL_DA_SUA_API' pela URL da sua API
                    .then(function(response) {
                        const atividades = response.data.data;

                        // Obter referência ao tbody da tabela mais próxima de divAtividadesRdse
                        const $tbody = $('.divAtividadesRdse').closest('.divAtividadesRdse').find('tbody');
                        $tbody.empty(); // Limpar conteúdo atual do tbody

                        // Iterar sobre os dados e adicionar cada atividade como uma linha na tabela
                        atividades.forEach(function(atividade, index) {

                            // Adicionar a nova linha com os dados
                            const $linha = $(`
                            <tr>
                              <th scope="row">${atividade.id}</th>
                              <td>${atividade.atividade_descricao}</td>
                              <td>${atividade.data}</td>
                              <td>${atividade.data_inicio}</td>
                              <td>${atividade.data_fim}</td>
                              <td>${atividade.equipe}</td>
                              <td>${atividade.execucao}</td>
                              <td>
                                ${atividade.btn_edit}
                              </td>
                            </tr>
                        `);
                            $tbody.append($linha); // Adicionar a linha ao tbody
                        });
                    })
                    .catch(function(error) {
                        console.error("Erro ao buscar atividades:", error);
                    });
            }

            carregarAtividades();

            document.querySelectorAll('.removeRowBtn').forEach(button => {
                addRemoveEvent(button);
            });

            function submitForm() {

                const form = document.getElementById('itensForNewAtividade');

                const formData = new FormData(form);

                let data = {};
                formData.forEach((value, key) => {
                    //if (key.includes('itens')) {
                    //    const [_, index, field] = key.match(/itens\[(\d+)]\[(.*)]/);
                    //
                    //    if (!data.itens) {
                    //        data.itens = [];
                    //    }
                    //    if (!data.itens[index]) {
                    //        data.itens[index] = {};
                    //    }
                    //    data.itens[index][field] = value;
                    //} else {
                    data[key] = value;
                    //}
                });

                //if (data.itens) {
                //    data.itens = data.itens.filter(item => item !== null && item !== undefined);
                //}

                axios.post(`${route}/${id}/atividades`, data)
                    .then(function(response) {
                        alert('Segmento salvo com sucesso!');
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
                //const itensContainer = document.querySelector('#itemsTable tbody');
                //itensContainer.innerHTML = '';
                //adicionarLinha();
                carregarAtividades();
            }

            // Evento para alternar entre o formulário e a lista de itens ao clicar no botão

            $('#submitForm').on('click', submitForm);

        });

        $('#modaladdItemsModal').on('hide.bs.modal', function() {
            $('#addItemForm').addClass('d-none');
            $('#itemList').removeClass('d-none');
            $('#toggleBtn').text('Adicionar Item');
        });
    </script>
@append
