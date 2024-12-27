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
                    <input id="dataInput" tabindex="2" type="text"  name="data" class="form-control" autocomplete="off" required>
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
