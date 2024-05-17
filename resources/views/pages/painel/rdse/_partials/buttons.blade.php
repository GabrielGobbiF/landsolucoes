<div id="buttons-alter-status" class="d-none">

    <div class="div__pending d-none" id="div-pending">
        <button id="button-approval" type="button" data-type="approval" class="btn btn-secondary btn-states">
            <i class="fas fa-file-export"></i> Enviar para Aprovação
        </button>
    </div>

    <div class="div__pending d-none" id="div-approval">
        <button id="button-pending" type="button" data-type="pending" class="btn btn-secondary btn-states">
            <i class="fas fa-arrow-left"></i> Em Medição
        </button>

        <button id="button-approved" type="button" data-type="approved" class="btn btn-secondary btn-states">
            <i class="fas fa-file-export"></i> Enviar para Aprovado
        </button>
    </div>

    <div class="div__pending d-none" id="div-approved">
        <button id="button-approval" type="button" data-type="approval" class="btn btn-secondary btn-states">
            <i class="fas fa-arrow-left"></i> Enviar para Em Aprovação
        </button>

        <button id="button-invoice" type="button" data-type="invoice" class="btn btn-secondary btn-states">
            <i class="fas fa-file-export"></i> Faturar
        </button>
    </div>

    <div class="div__pending d-none" id="div-invoice">
        <button id="button-approved" type="button" data-type="approved" class="btn btn-secondary btn-states">
            <i class="fas fa-arrow-left"></i> Enviar para Aprovação
        </button>

        <button id="button-inventariando" type="button" data-type="inventariando" class="btn btn-secondary btn-states">
            <i class="fas fa-file-export"></i> Enviar para Inventariando
        </button>
    </div>

    <div class="div__pending d-none" id="div-inventariando">
        <button id="button-invoice" type="button" data-type="invoice" class="btn btn-secondary btn-states">
            <i class="fas fa-arrow-left"></i> Enviar para Faturar
        </button>

        <button id="button-inventariado" type="button" data-type="inventariado" class="btn btn-secondary btn-states">
            <i class="fas fa-file-export"></i> Enviar para Inventariado
        </button>
    </div>

    <div class="div__pending d-none" id="div-inventariado">
        <button id="button-inventariando" type="button" data-type="inventariando" class="btn btn-secondary btn-states">
            <i class="fas fa-arrow-left"></i> Enviar para Inventariando
        </button>
    </div>
</div>

{{-- <button id="button-approval" type="button" data-type="approval" class="btn btn-secondary btn-states button-approval">
    <i class="fas fa-file-export"></i> Enviar para Aprovação
</button>
<button id="button-pending" type="button" data-type="pending" class="btn btn-secondary btn-states button-pending d-none">
    <i class="fas fa-file-export"></i> Enviar para Aprovado
</button>
<button id="button-pending" type="button" data-type="pending" class="btn btn-secondary btn-states button-pending d-none">
    <i class="fas fa-file-export"></i> Faturar
</button> --}}
