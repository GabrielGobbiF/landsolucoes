@section('styles')

@endsection

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

    <script class="">
        document.addEventListener("DOMContentLoaded", function() {
            const equipeSelect = document.getElementById("rdse-select_equipe");
            const dataInput = document.getElementById("dataInput");
            const atividadesTabela = document.getElementById("atividades-tabela");
            const atividadesContainer = document.getElementById("atividades-container");
            let debounceTimer;

            // Inicializar o Tom Select
            new TomSelect("#rdse-select_equipe", {
                maxItems: 1,
                placeholder: "Selecione uma equipe",
            });

            // Função para buscar atividades
            function buscarAtividades(equipeId, data) {
                fetch(`${base_url}/api/v1/rdses/equipes/${equipeId}?date=${data}`)
                    .then(response => response.json())
                    .then(data => {

                        let dataRow = data.data;

                        atividadesTabela.innerHTML = ""; // Limpa tabela

                        if (dataRow.length > 0) {
                            dataRow.forEach(atividade => {
                                atividadesTabela.innerHTML += `
                            <tr>
                                <td>${atividade.id}</td>
                                <td>${atividade.atividade_descricao}</td>
                                <td>${atividade.data}</td>
                                <td>${atividade.data_inicio}</td>
                                <td>${atividade.data_fim}</td>
                                <td>${atividade.equipe}</td>
                                <td>${atividade.execucao}</td>
                            </tr>
                        `;
                            });
                            atividadesContainer.classList.remove("d-none"); // Exibe a tabela
                        } else {
                            atividadesTabela.innerHTML = `<tr><td colspan="3">Nenhuma atividade encontrada.</td></tr>`;
                            atividadesContainer.classList.remove("d-none"); // Exibe a tabela com mensagem
                        }
                    })
                    .catch(error => {
                        console.error("Erro ao buscar atividades:", error);
                        atividadesTabela.innerHTML = `<tr><td colspan="3">Erro ao carregar atividades.</td></tr>`;
                        atividadesContainer.classList.remove("d-none"); // Exibe mensagem de erro
                    });
            }

            // Evento de mudança nos inputs
            function verificarInputs() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const equipeId = equipeSelect.value;
                    const data = dataInput.value;
                    atividadesTabela.innerHTML = "";

                    if (equipeId && data) {
                        const formattedDate = formatDate(data);
                        buscarAtividades(equipeId, formattedDate);
                    } else {
                        atividadesContainer.classList.add("d-none");
                    }
                }, 800); // Tempo de debounce em milissegundos
            }

            function formatDate(dateString) {
                // Dividir a string yyyy-mm-dd em partes
                const [year, month, day] = dateString.split("-");

                // Retornar a data formatada como d/m/Y
                return `${day}/${month}/${year}`;
            }

            equipeSelect.addEventListener("change", verificarInputs);
            dataInput.addEventListener("change", verificarInputs);
        });
    </script>

    <script>
        $(document).ready(function() {
            let atividadesPorData = [];

            // Quando selecionar uma equipe, busca as atividades
            $('#rdse-select_equipe').on('change', function() {
                const equipeId = $(this).val();

                if (equipeId) {
                    axios.get(`${base_url}/api/v1/rdses/equipes/${equipeId}/atividades`)
                        .then(response => {
                            atividadesPorData = response.data.map(data => {
                                const partes = data.split('/'); // Divide 'dd/mm/yyyy'
                                return `${partes[2]}-${partes[1]}-${partes[0]}`; // Reorganiza para 'yyyy-mm-dd'
                            });



                            $('#datepicker').datepicker('refresh'); // Atualiza o calendário
                        })
                        .catch(error => console.error('Erro ao buscar atividades:', error));
                } else {
                    atividadesPorData = [];
                    $('#dataInput').datepicker('refresh'); // Limpa o calendário
                }
            });

            // Configura o Date Picker
            $('#dataInput').datepicker({
                beforeShowDay: function(date) {
                    const formattedDate = $.datepicker.formatDate('yy-mm-dd', date);
                    if (atividadesPorData.includes(formattedDate)) {
                        return [true, 'highlight ui-state-highlight', 'Atividade na data']; // Adiciona classe ao <a>
                    }
                    return [true, '', ''];
                }
            });
        });
    </script>
@append
