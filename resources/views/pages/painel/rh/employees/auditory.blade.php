<div class="card-body">
    <div class="row">
        <div class="col-md-2 border-right">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link nav-link_auditory active text-center" id="v-pills-entrevista-tab" data-toggle="pill"
                    href="#v-pills-entrevista" role="tab" aria-controls="v-pills-entrevista"
                    aria-selected="true">Entrevista</a>
                <a class="nav-link nav-link_auditory {{ $entrevista == true ? '' : 'disabled' }} text-center"
                    id="v-pills-contratacao-tab" data-toggle="pill" href="#v-pills-contratacao" role="tab"
                    aria-controls="v-pills-contratacao" aria-selected="false">Contratação</a>
                <a class="nav-link nav-link_auditory  {{ $entrevista == true ? '' : 'disabled' }} text-center"
                    id="v-pills-ac_mensal-tab" data-toggle="pill" href="#v-pills-ac_mensal" role="tab"
                    aria-controls="v-pills-ac_mensal" aria-selected="false">Acompanhamento Periódico</a>

                <a class="nav-link nav-link_auditory  {{ $entrevista == true ? '' : 'disabled' }} text-center"
                    id="v-pills-cursos-tab" data-toggle="pill" href="#v-pills-cursos" role="tab"
                    aria-controls="v-pills-cursos" aria-selected="false">Cursos</a>
                <hr>
                @if ($employee->dispense == true)
                    <a class="nav-link nav-link_auditory text-center" id="v-pills-dispensa-tab"
                        style="color:rgb(239 109 109)" data-toggle="pill" href="#v-pills-dispensa" role="tab"
                        aria-controls="v-pills-dispensa" aria-selected="false">Dispensa</a>
                @else
                    <a style="color:rgb(239 109 109); cursor: pointer;" class="text-center open_dispense_employee">Dispensa</a>
                @endif

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

                <div class="tab-pane tab-pane_auditory fade " id="v-pills-dispensa" role="tabpanel"
                    aria-labelledby="v-pills-dispensa-tab">
                    @if ($employee->dispense == true)
                        @include('pages.painel.rh.employees._partials.dispensa')
                    @endif
                </div>

                <div class="tab-pane tab-pane_auditory fade " id="v-pills-cursos" role="tabpanel"
                    aria-labelledby="v-pills-cursos-tab">
                    @include('pages.painel.rh.employees._partials.cursos')
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
            <input type="hidden" id="required" value="false" >

            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Importe o Documento</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="file" name="file" id="file_document" required>
                        <p class="help-block">somente arquivos <b>PDF</b></p>
                        <br>
                        <p class="help-block">por favor, confirme o documento antes de enviar</p>
                    </div>

                    <div class="cursos--employees d-none"></div>
                    <div class="epi--employees d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-submit">Salvar</button>
                    <button type="button" class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@include('pages.painel.rh.employees._partials.modals.dispense_modal')
@include('pages.layouts.modal_change')

