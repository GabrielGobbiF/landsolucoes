<form id="itensForNewAtividade" action="" method="POST">
    <input id="routeAddAtividade" type="hidden" value="{{ route('api.rdse.index') }}">
    <input id="modalrdseId" type="hidden" value="{{ isset($rdse) ? $rdse->id : null }}">

    @csrf

    <div class="row">
        <div class="col-12 col-md-3">
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

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label for="rdse-supervisor">Supervisor</label>
                <select id="rdse-supervisor" name="supervisor_id" class="form-control" required tabindex="1">
                    <option value="">Selecione </option>
                    @foreach (supervisores() as $supervisor)
                        <option value='{{ $supervisor->id }}'>
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
                        <option value='{{ $encarregado->id }}'>
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
                </select>
            </div>
        </div>

        <div class="col-12 col-md-4">
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

        <div class="col-12 col-md-4">
            <div class="form-group">
                <label for="rdse-diretoria">Diretoria</label>
                <select id="rdse-diretoria" name="diretoria" class="form-control" required tabindex="1">
                    <option value="">Selecione </option>
                    <option value='PM'>PM </option>
                    <option value='HV'>HV </option>
                </select>
            </div>
        </div>


        <div class="col-12 col-md-4">
            <div class="form-group">
                <label for="rdse-civil">Civil</label>
                <select id="rdse-civil" name="civil" class="form-control" required tabindex="1">
                    <option value="">Selecione </option>
                    <option value='1'>Sim </option>
                    <option value='0'>Não </option>
                </select>
            </div>
        </div>

        <div class="col-12 col-md-12">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label for="dataInput" class="form-label">Data</label>
                    <input id="dataInput" tabindex="2" type="text" name="data" class="form-control" autocomplete="off" required>
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

        <div class="col-12">
            <div id="atividades-container" class="mt-4 d-none">
                <h6>Atividades da data </h6>
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
                            </tr>
                        </thead>
                        <tbody id="atividades-tabela"> </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <label for="atividades" class="form-label">Atividades</label>
            <textarea id="atividades" name="atividades" cols="30" rows="10" class="form-control"></textarea>
        </div>

        <div class="col-12 col-md-12 mt-4">
            <label>Executação </label>

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
    </div>
</form>

@section('scripts')
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
