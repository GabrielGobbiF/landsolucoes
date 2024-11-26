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
    @include('pages.painel.rdse.rdse.atividade.form_atividade')
</div>


@section('scripts')

    <script>
        $('#toggleBtn').on('click', toggleForm);

        $('#submitForm').on('click', submitForm);

        function initAddItemsModal() {

            carregarAtividades();
        }

        function carregarAtividades() {
            const $tbody = $('.divAtividadesRdse').closest('.divAtividadesRdse').find('tbody');
            $tbody.empty();

            const route = $('#routeAddAtividade').val();

            const id = $('#modalrdseId').val();

            if (id == undefined || id == '') {
                return;
            }

            axios.get(`${route}/${id}/atividades`) // Substitua 'URL_DA_SUA_API' pela URL da sua API
                .then(function(response) {
                    const atividades = response.data.data;

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
                                <div class="d-flex" style="gap:1rem">
                                         ${atividade.btn_edit}
                                    <button class="btn btn-sm btn-danger" onclick="deletarAtividade(${atividade.rdse_id},${atividade.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
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

        function submitForm() {

            const route = $('#routeAddAtividade').val();

            const id = $('#modalrdseId').val();

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

            form.reset();

            carregarAtividades();

            toggleForm();
        }

        function toggleForm() {
            const isFormVisible = $('#addItemForm').hasClass('d-none');

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

        function deletarAtividade(rdseId, atvId) {

            const route = $('#routeAddAtividade').val();

            const id = $('#modalrdseId').val();

            if (confirm("Tem certeza de que deseja deletar este item?")) {
                axios.delete(`${route}/${id}/atividades/${atvId}`)
                    .then(function(response) {
                        carregarAtividades();
                    })
                    .catch(function(error) {
                        if (error.response && error.response.data && error.response.data.errors) {
                            let errors = error.response.data.errors;
                            let errorMessages = '';
                            Object.keys(errors).forEach(key => {
                                errorMessages += errors[key].join(' ') + '\n';
                            });
                            alert(errorMessages);
                        } else {
                            alert('Ocorreu um erro inesperado. Tente novamente.');
                        }
                    });
            }

        }

        initAddItemsModal();
    </script>
@append
