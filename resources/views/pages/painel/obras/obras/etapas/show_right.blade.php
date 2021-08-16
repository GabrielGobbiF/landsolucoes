<div class="etp-show right-bar-etp d-flex" class="h-100">
    <input type="hidden" id="js-etapa-id">

    <div class="col-md-12 etp">
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
            <form id='form-update-etapa' role='form' class='needs-validation' action='' method='POST'>
                @csrf
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="tx-green" for="text1">Data Meta</label>
                            <input type="text" class="form-control date" name="meta_etapa" id="input--meta_etapa" value="" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="text1">Nº Nota</label>
                            <input type="text" class="form-control" name="nota_numero" id="input--n_nota" value="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="text1">Data de Abertura</label>
                            <input type="text" class="form-control date" name="data_abertura" id="input--data_abertura" value="" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="text1">Prazo de Atendimento</label>
                            <input type="text" class="form-control" name="prazo_atendimento" id="input--prazo_atendimento" value="33" autocomplete="off">
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

                <div class="row">
                    <div class="col-auto align-self-center mg-t-9">
                        <button type="submit" class="btn btn-form form-control btn-primary js-btn-save"> Salvar</button>
                    </div>
                </div>
            </form>

            <hr class="my-5">

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-2">
                        <h5 class="mt-0 font-size-14">Observações do Sistema</h5>
                    </div>
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
    </div>
</div>
