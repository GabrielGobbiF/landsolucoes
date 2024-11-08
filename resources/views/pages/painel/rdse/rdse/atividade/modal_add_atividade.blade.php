<div id="modaladdItemsModal" class="modal fade" tabindex="-1" aria-labelledby="addItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('pages.painel.rdse.rdse.atividade.divAtividade')
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $('#modaladdItemsModal').on('shown.bs.modal', function() {
            init();
        });
    </script>
@append
