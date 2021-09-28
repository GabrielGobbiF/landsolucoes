<div class="modal" id="modal-pesquisa__global" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="form-search-global" role="form" class="needs-validation" action="{{ route('global.search') }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title">Pesquisa Global</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="text1">Digite sua pesquisa</label>
                        <input type="text" class="form-control" name="search" id="input--search" value="{{ old('text') }}" autocomplete="off" required>
                    </div>

                    <hr class="mt-2">
                    <div id="results"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#modal-pesquisa__global").on("hidden.bs.modal", function() {
        $('#input--search').val('');
        $('#results').html('');
    })

    $("#form-search-global").on('submit', function(e) {
        $('#results').html('')
        e.preventDefault();
        const value = $('#input--search').val();
        if (value != '') {
            $.ajax({
                url: $('#form-search-global').attr('action'),
                type: 'GET',
                data: {
                    search: value,
                },
            }).done(function(response) {
                $('#results').html(response)
            });
        }
    })
</script>
