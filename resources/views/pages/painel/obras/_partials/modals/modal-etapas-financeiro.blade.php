<div class="modal" id="modal-etapas--financeiro" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header text-center">
                <h3 class="modal-title ">Lançamento de Faturamento</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title etapa-nome mb-4"></h4>
                            <span class="card-title etapa-valor_receber justify-content-end"></span>
                        </div>
                        <form id="form-etapas-financeiro" autocomplete="off" role="form" class="needs-validation" action="" method="POST">
                            @method('put')
                            <input type="hidden" class="hidden" id="obraId" value="{{ $obra->id }}">
                            @include("pages.painel._partials.forms.form-etapas-faturamento")
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Histórico</h4>
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Ação</th>
                                    <th>Etapa</th>
                                    <th>Faturamento</th>
                                    <th>NF Nº</th>
                                    <th>Emissão</th>
                                    <th>Vencimento</th>
                                    <th>Valor</th>
                                    <th>Recebido</th>
                                </tr>
                            </thead>
                            <tbody id="results-faturamento"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($errors->any())
    <script>
        $(document).ready(function() {
            $("#modal-etapas--financeiro").modal("show")
        })
    </script>
@endif

<script>
    $(document).ready(function() {
        $("#modal-etapas--financeiro").on("hidden.bs.modal", function() {
            $(':input', '#form-etapas-financeiro')
                .not(':button, :submit, :reset, :hidden')
                .val('')
            document.querySelector('#results-faturamento').innerHTML = '';
        })
    })
</script>
