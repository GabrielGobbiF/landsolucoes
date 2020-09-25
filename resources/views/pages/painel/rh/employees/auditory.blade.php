<div class="card-body">
    <div class="row">
        <div class="col-md-2 border-right">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active text-center" id="v-pills-entrevista-tab" data-toggle="pill"
                    href="#v-pills-entrevista" role="tab" aria-controls="v-pills-entrevista"
                    aria-selected="true">Entrevista</a>
                <a class="nav-link disabled text-center" id="v-pills-contratacao-tab" data-toggle="pill"
                    href="#v-pills-contratacao" role="tab" aria-controls="v-pills-contratacao" aria-selected="false"
                    disabled>Contratação</a>
                <a class="nav-link disabled text-center" id="v-pills-ac_mensal-tab" data-toggle="pill"
                    href="#v-pills-ac_mensal" role="tab" aria-controls="v-pills-ac_mensal"
                    aria-selected="false">Acompanhamento Mensal</a>
                <a class="nav-link disabled text-center" id="v-pills-documentos-tab" data-toggle="pill"
                    href="#v-pills-documentos" role="tab" aria-controls="v-pills-documentos"
                    aria-selected="false">Documentos</a>
            </div>

        </div>

        <div class="col-md-10">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-entrevista" role="tabpanel"
                    aria-labelledby="v-pills-entrevista-tab">
                    <table class="table">
                        <tbody>
                            @for ($i = 0; $i < 10; $i++)

                                <tr data-id="" data-name="">
                                    <th> <span data-toggle="tooltip" title=""> Entrevista </span></th>
                                    <th class="text-center">
                                        <div class="form-group">
                                            <div class="radio">
                                                <label style="margin-right:5px">
                                                    <input type="radio" data-collumn="usc_status" class="usc_status"
                                                        name="usc_status_" id="option_sim_" value="1" />
                                                    Sim
                                                </label>

                                                <label>
                                                    <input type="radio" data-collumn="usc_status" class="usc_status"
                                                        name="usc_status_" id="option_nao_" value="0" checked />
                                                    Não
                                                </label>
                                            </div>
                                        </div>
                                    </th>

                                    <th class="text-center">
                                        documento enviado por gabriel gobbi em 27/08/2020 <a href="#" class="">Ver</a>
                                    </th>
                                </tr>

                            @endfor

                        </tbody>
                    </table>
                </div>

                <div class="tab-pane fade" id="v-pills-contratacao" role="tabpanel"
                    aria-labelledby="v-pills-contratacao-tab">

                </div>
                <div class="tab-pane fade" id="v-pills-ac_mensal" role="tabpanel"
                    aria-labelledby="v-pills-ac_mensal-tab">

                </div>
                <div class="tab-pane fade" id="v-pills-documentos" role="tabpanel"
                    aria-labelledby="v-pills-documentos-tab">

                </div>
            </div>
        </div>

    </div>
</div>
