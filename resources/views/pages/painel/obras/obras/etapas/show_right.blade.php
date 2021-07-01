<div class="right-bar-etp d-flex" class="h-100">
    <input type="hidden" id="js-etapa-id">
    <div class="col-md-12 align-self-center" id="preloader-content-etp">
        <div class="text-center">
            <div class="spinner-border text-primary m-1 align-self-center" role="status">
                <span class="sr-only"></span>
            </div>
        </div>
    </div>

    <div class="col-md-12 d-none etp">
        <div class="box-header with-border mg-t-10">
            <h3 class="box-title"></h3>
            <div class="float-right">
                <span class="tx-muted font-size-12 mr-3">Nª Nota: </span>
                <h3 class="box-title js-input-etapa-n-nota editable" value="1"></h3>
            </div>
        </div>
        <div class="box-body">

            <div class="row mg-0 pd-0 mt-4">
                <div class="col-md-10 mg-0 pd-0">
                    <div class="col-12 tx-14">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Data Abertura</dt>
                            <dd class="col-sm-8">24/08/2021</dd>
                        </dl>
                        <dl class="row mb-0">
                            <dt class="col-sm-4"><span class="badge-success badge tx-14 pd-5">Data Meta</span></dt>
                            <dd class="col-sm-8">24/08/2021</dd>
                        </dl>
                    </div>

                    <div class="col-12 mt-5">
                        <div class="media mb-4">
                            <i class="fas fa-list mr-3 mg-t-4 rounded-circle"></i>
                            <div class="media-body">
                                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-2">
                                    <h5 class="mt-0 font-size-14">Descrição</h5>
                                    <button class="btn btn-sm btn-outline-secondary js-edit-description">Editar</button>
                                </div>
                                <textarea disabled style="cursor: pointer;resize:none" class="form-control js-textarea-description" rows="3" data-type="textarea"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-5">
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

                        <div class="etapas-comments"></div>
                    </div>
                </div>

                <div class="col-md-2 d-none">
                    <div class="media">
                        <div class="user-img online align-self-center mr-3">
                            <span class="user-status"></span>
                        </div>
                        <div class="media-body overflow-hidden">
                            <h5 class="text-truncate font-size-14 mb-1">Léo</h5>
                            <p class="text-truncate mb-0">Hey! there I'm available</p>
                        </div>
                        <div class="font-size-11">04 min</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
