<div class="modal" id="modal-add-{{ $type }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered {{ isset($modalSize) ? $modalSize : null }}" role="document">
        <div class="modal-content">
            <form id="form-add-{{ $type }}" autocomplete="off" role="form" class="needs-validation" action="{{ route("$type.store", ['redirect' => $redirect ?? '']) }}" method="POST">
                <input type="hidden" name="redirect" value="{{ $redirect ?? null }}">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar novo(a) {{ __('text.' . singular($type, false)) }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @include("pages.painel._partials.forms.form-$type")
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-submit"> <i class="fas fa-edit"></i> Adicionar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('scripts')

    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $("#modal-add-{{ $type }}").modal('show')
            })
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $('#input--musical_genre').select2({
                dropdownParent: $('#modal-add-{{ $type }}  .modal-content'),
                width: '100%',
            });

            $('#input--user_id').select2({
                dropdownParent: $('#modal-add-{{ $type }}  .modal-content'),
                width: '100%',
            });

            $("#modal-add-{{ $type }}").on("hidden.bs.modal", function() {
                $("#form-add-{{ $type }}")[0].reset();
            })
        })
    </script>
@endsection
