<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" aria-modal="true" role="dialog">
    <input type="hidden" id="js-etapa-id">

    <div class="col-md-12 etp" id="div--etp">
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
                            <input type="text" class="form-control" name="nome" id="input--name" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="tx-green">Data Meta</label>
                            <input type="text" class="form-control date" name="meta_etapa" id="input--meta_etapa" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Responsável</label>
                            <input type="text" class="form-control" name="responsavel" id="input--responsavel" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="type concessionaria">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label>Nº Nota</label>
                                <input type="text" class="form-control" name="nota_numero" id="input--n_nota" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label>Data de Abertura</label>
                                <input type="text" class="form-control date" name="data_abertura" id="input--data_abertura" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label>Prazo de Atendimento</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="prazo_atendimento" id="input--prazo_atendimento" autocomplete="off">
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
                            <input type="text" class="form-control date" name="data_pedido" id="input--data_pedido" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Cliente Responsável</label>
                            <input type="text" class="form-control" name="cliente_responsavel" id="input--cliente_responsavel" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="type obra row">

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Data Programada</label>
                            <input type="text" class="form-control date" name="data_programada" id="input--data_programada" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Data Iniciada</label>
                            <input type="text" class="form-control date" name="data_iniciada" id="input--data_iniciada" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Tempo de atividade</label>
                            <input type="text" class="form-control" name="tempo_atividade" id="input--tempo_atividade" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="type compra row">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Quantidade</label>
                            <input type="text" class="form-control" name="quantidade" id="input--quantidade" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Preço</label>
                            <input type="text" class="form-control money" name="preco" id="input--preco" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label>Tipo</label>
                            <input type="text" class="form-control" name="unidade" id="input--unidade" autocomplete="off">
                        </div>
                    </div>
                </div>




                <div class="row">
                    <div class="col-auto align-self-center mg-t-9">
                        <button type="submit" class="btn btn-form form-control btn-primary js-btn-save"> Salvar</button>
                    </div>
                </div>
            </form>

            <hr class="my-5">


            <div class="col-12">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Observações do Sistema</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Pendências</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="media mb-4">
                                    @include('pages.painel._partials.avatar', [
                                    'avatar' => '',
                                    'name' => Auth::user()->name,
                                    ])
                                    <div class="media-body align-self-center ml-2">
                                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                                            <input type="text" name="obs_texto" class="form-control js-new-comment " placeholder="Escreva um comentário..." id="input-new-comment">
                                            <button type="submit" class="btn btn-primary js-btn-new-comment" onclick="newComment()">Enviar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="etapas-comments" style="height: 100vh;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row mt-4">
                                <h6 class="">Desenvolvendo</h6>
                                <div class=" col-12 d-none">
                                    <div class="media mb-4">
                                        @include('pages.painel._partials.avatar', [
                                        'avatar' => '',
                                        'name' => Auth::user()->name,
                                        ])
                                        <div class="media-body align-self-center ml-2">
                                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                                                <input type="text" name="obs_texto" class="form-control js-new-comment " placeholder="Escreva um comentário..." id="input-new-comment">
                                                <button type="submit" class="btn btn-primary js-btn-new-comment" onclick="newComment()">Enviar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="etapas-pendencias" style="height: 100vh;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
