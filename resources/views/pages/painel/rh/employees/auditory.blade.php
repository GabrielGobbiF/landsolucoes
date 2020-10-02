<div class="card-body">
    <div class="row">
        <div class="col-md-2 border-right">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link nav-link_auditory active text-center" id="v-pills-entrevista-tab" data-toggle="pill"
                    href="#v-pills-entrevista" role="tab" aria-controls="v-pills-entrevista"
                    aria-selected="true">Entrevista</a>
                <a class="nav-link nav-link_auditory {{ $entrevista == true ? '' : 'disabled' }} text-center" id="v-pills-contratacao-tab"
                    data-toggle="pill" href="#v-pills-contratacao" role="tab" aria-controls="v-pills-contratacao"
                    aria-selected="false">Contratação</a>
                <a class="nav-link nav-link_auditory  {{ $entrevista == true ? '' : 'disabled' }} text-center" id="v-pills-ac_mensal-tab"
                    data-toggle="pill" href="#v-pills-ac_mensal" role="tab" aria-controls="v-pills-ac_mensal"
                    aria-selected="false">Acompanhamento Mensal</a>
                <hr>
                <a class="nav-link nav-link_auditory disabled text-center" style="color:rgb(239 109 109)" id="v-pills-documentos-tab"
                    data-toggle="pill" href="#v-pills-documentos" role="tab" aria-controls="v-pills-documentos"
                    aria-selected="false">Dispensa</a>
            </div>
        </div>
        <div class="col-md-10">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane tab-pane_auditory fade show active " id="v-pills-entrevista" role="tabpanel"
                    aria-labelledby="v-pills-entrevista-tab">
                    @include('pages.painel.rh.employees._partials.entrevista')
                </div>
                <div class="tab-pane tab-pane_auditory fade" id="v-pills-contratacao" role="tabpanel"
                    aria-labelledby="v-pills-contratacao-tab">
                    @include('pages.painel.rh.employees._partials.contratacao')
                </div>
                <div class="tab-pane tab-pane_auditory fade " id="v-pills-ac_mensal" role="tabpanel"
                    aria-labelledby="v-pills-ac_mensal-tab">
                    @include('pages.painel.rh.employees._partials.ac_mensal')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal--save--document" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <form id="update--Auditory" action="{{ route('employees.auditory.update', $employee->uuid) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="auditory_id" id="auditory_id">
            <input type="hidden" name="employees_auditory_month_id" id="employees_auditory_month_id">
            <input type="hidden" name="type_pasta" id="type_pasta">
            <input type="hidden" name="document_name" id="document_name">
            <input type="hidden" name="data_month" id="data_month">

            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Importe o Documento</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="file" name="file" id="file_document">
                        <p class="help-block">somente arquivos <b>PDF</b></p>
                        <br>
                        <p class="help-block">por favor, confirme o documento antes de enviar</p>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary"
                        onclick="this.disabled = true; this.value = 'Salvando…'; this.form.submit();" value="Salvar">
                    <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
