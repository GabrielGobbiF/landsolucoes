@if (request()->input('status') == 'pending')
    <button id="button-approval" type="button" data-type="approval" class="btn btn-secondary btn-states">
        <i class="fas fa-file-export"></i> Enviar para Aprovação
    </button>
@endif

@if (request()->input('status') == 'approval')
    <button id="button-pending" type="button" data-type="pending" class="btn btn-secondary btn-states">
        <i class="fas fa-arrow-left"></i> Em Medição
    </button>

    <button id="button-approved" type="button" data-type="approved" class="btn btn-secondary btn-states">
        <i class="fas fa-file-export"></i> Enviar para Aprovado
    </button>
@endif

@if (request()->input('status') == 'approved')
    <button id="button-approval" type="button" data-type="approval" class="btn btn-secondary btn-states">
        <i class="fas fa-arrow-left"></i> Enviar para Em Aprovação
    </button>

    <button id="button-invoice" type="button" data-type="invoice" class="btn btn-secondary btn-states">
        <i class="fas fa-file-export"></i> Faturar
    </button>
@endif

@if (request()->input('status') == 'invoice')
    <button id="button-approved" type="button" data-type="approved" class="btn btn-secondary btn-states">
        <i class="fas fa-arrow-left"></i> Enviar para Aprovado
    </button>
@endif


{{-- <button id="button-approval" type="button" data-type="approval" class="btn btn-secondary btn-states button-approval">
    <i class="fas fa-file-export"></i> Enviar para Aprovação
</button>
<button id="button-pending" type="button" data-type="pending" class="btn btn-secondary btn-states button-pending d-none">
    <i class="fas fa-file-export"></i> Enviar para Aprovado
</button>
<button id="button-pending" type="button" data-type="pending" class="btn btn-secondary btn-states button-pending d-none">
    <i class="fas fa-file-export"></i> Faturar
</button> --}}
