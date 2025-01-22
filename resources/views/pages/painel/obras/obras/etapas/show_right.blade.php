<div id="offcanvasRight" class="offcanvas offcanvas-end" tabindex="-1" aria-labelledby="offcanvasRightLabel" aria-modal="true" role="dialog">
    <input id="js-etapa-id" type="hidden">

    <div id="div--etp" class="col-md-12 etp">
        <div class="box-header with-border mg-t-10">
            <h3 class="box-title"></h3>
            <div class="float-right">
                <span class="tx-muted font-size-12 mr-3">Nº Nota: </span>
                <h3 class="box-title js-input-etapa-n-nota " value="1"></h3>
                <button type='button' class='close close-right-bar ml-5'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
        </div>
        <div class="box-body mt-3">
            <form id='form-update-etapa' role='form' class='needs-validation' action='1' method='POST'>
                @csrf

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Nome</label>
                            <input id="input--name" type="text" class="form-control" name="nome" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="tx-green">Data Meta</label>
                            <input id="input--meta_etapa" type="text" class="form-control date" name="meta_etapa" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Responsável</label>
                            <input id="input--responsavel" type="text" class="form-control" name="responsavel" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="type concessionaria">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label>Nº Nota</label>
                                <input id="input--n_nota" type="text" class="form-control" name="nota_numero" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label>Data de Abertura</label>
                                <input id="input--data_abertura" type="text" class="form-control date" name="data_abertura" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label>Prazo de Atendimento</label>
                                <div class="input-group">
                                    <input id="input--prazo_atendimento" type="text" class="form-control" name="prazo_atendimento" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Dias</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 align-self-center">
                            <div class="form-check form-check-inline align-self-center mg-0">
                                <input class="form-check-input wd-15 ht-15" name="check_nota" type="checkbox" value="true">
                                <label class="form-check-label" style="font-size:13px" for="metodo_real">Salvar como ultima nota</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="type administrativa row">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Data do Pedido</label>
                            <input id="input--data_pedido" type="text" class="form-control date" name="data_pedido" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Cliente Responsável</label>
                            <input id="input--cliente_responsavel" type="text" class="form-control" name="cliente_responsavel" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="type obra row">

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Data Programada</label>
                            <input id="input--data_programada" type="text" class="form-control date" name="data_programada" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Data Iniciada</label>
                            <input id="input--data_iniciada" type="text" class="form-control date" name="data_iniciada" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Tempo de atividade</label>
                            <input id="input--tempo_atividade" type="text" class="form-control" name="tempo_atividade" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="type compra row">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Quantidade</label>
                            <input id="input--quantidade" type="text" class="form-control" name="quantidade" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Preço</label>
                            <input id="input--preco" type="text" class="form-control money" name="preco" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Tipo</label>
                            <input id="input--unidade" type="text" class="form-control" name="unidade" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="row">
                    @if (!auth()->guard('clients')->check())
                        <div class="col-auto align-self-center mg-t-9">
                            <button type="submit" class="btn btn-form form-control btn-primary js-btn-save"> Salvar</button>
                        </div>
                    @endif
                </div>
            </form>

            <hr class="my-5">


            <div>
                <ul id="pills-tab" class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a id="pills-home-tab" class="nav-link active" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home"
                           aria-selected="true">Observações do Sistema</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a id="pills-history-tab" class="nav-link " data-toggle="pill" href="#pills-history" role="tab" aria-controls="pills-history"
                           aria-selected="true">Histórico</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a id="pills-uploadeds-tab" class="nav-link " data-toggle="pill" href="#pills-uploadeds" role="tab"
                           aria-controls="pills-uploadeds" aria-selected="true">Documentos</a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a id="pills-modelo_uploadeds-tab" class="nav-link " data-toggle="pill" href="#pills-modelo_uploadeds" role="tab"
                           aria-controls="pills-modelo_uploadeds" aria-selected="true">Modelo de Documentos</a>
                    </li>

                    @if (!auth()->guard('clients')->check())
                        <li class="nav-item d-none" role="presentation">
                            <a id="pills-profile-tab" class="nav-link" data-toggle="pill" href="#pills-profile" role="tab"
                               aria-controls="pills-profile" aria-selected="false">Pendências</a>
                        </li>
                    @endif
                </ul>
                <div id="pills-tabContent" class="tab-content">
                    <div id="pills-home" class="tab-pane fade show active" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="media mb-4">
                                    @include('pages.painel._partials.avatar', [
                                        'avatar' => '',
                                        'name' => Auth::user()->name ?? auth()->guard('clients')->user()->username,
                                    ])
                                    <div class="media-body align-self-center ml-2">
                                        <div id="comment-div" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                                            <div class="wd-100p d-none">
                                                <p contenteditable="true" style="height: auto !important;" class="form-control js-new-comment"></p>
                                            </div>
                                            <input id="input-new-comment" type="text" class="form-control" name="obs_texto">
                                            <button type="submit" class="btn btn-primary js-btn-new-comment align-self-start"
                                                    onclick="newComment()">Enviar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="etapas-comments" style="height: 100vh;"></div>
                            </div>
                        </div>
                    </div>
                    @if (!auth()->guard('clients')->check())
                        <div id="pills-profile" class="tab-pane fade" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div id="pills-home" class="tab-pane fade show active" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="row mt-4">
                                    <h6 class="">Desenvolvendo</h6>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div id="pills-history" class="tab-pane fade " role="tabpanel" aria-labelledby="pills-history-tab">
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="table-activitiesTableBody d-none">
                                    <table class="table table-striped ">
                                        <thead>
                                            <tr>
                                                <th>Usuário</th>
                                                <th>Ação</th>
                                                <th>Data/Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody id="activitiesTableBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="pills-uploadeds" class="tab-pane fade arquivos" role="tabpanel" aria-labelledby="pills-uploadeds-tab">
                        <div class="card text-start">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <button id="button-add-new-file" data-parentModel="App\Models\ObraEtapa" class="btn btn-primary">
                                            <i class="fas fa-plus"></i>
                                            Adicionar novo documento
                                        </button>
                                        <div class="progress mt-3" style="height: 25px; display: none;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0"
                                                 aria-valuemin="0" aria-valuemax="100" style="width: 0%; height: 100%">
                                                0%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="documents-section" class="mt-4">
                                    <div class="row">
                                        <div id="preloader" style="display: flex; justify-content: center; align-items: center; height: 100px;">
                                            <div class="spinner-border" role="status">
                                                <span class="visually-hidden">Carregando...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="pills-modelo_uploadeds" class="tab-pane fade arquivos" role="tabpanel" aria-labelledby="pills-modelo_uploadeds-tab">
                        <div class="card text-start">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="progress mt-3" style="height: 25px; display: none;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0"
                                                 aria-valuemin="0" aria-valuemax="100" style="width: 0%; height: 100%">
                                                0%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div id="modelo_documents-section" class="mt-4">
                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="rightbar-etp-overlay" class="rightbar-etp-overlay"></div>
