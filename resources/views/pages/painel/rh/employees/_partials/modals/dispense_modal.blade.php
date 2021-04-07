<div class="modal fade effect-scale" id="modal-dispense--employee" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Abrir Dispensa</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mg-b-0 text-center">Tem certeza que deseja abrir a dispensa desse funcionário?</p>

                <div class='form-group'>
                    <label for='text1'>Tipo de Dispensa</label>
                    <select name='typeDispense' id="typeDispense" class='form-control select2' required>
                        <option value='' selected>Selecione</option>
                        @foreach (Config::get('constants.DISPENSE') as $status)
                            <option {{ Request::input('filter.status') && Request::input('filter.status') == $status ? 'selected' : '' }} value='{{ $status }}'>
                                {{  $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modal-cancel" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger modal-confirm">Sim</button>
            </div>
        </div>
    </div>
</div>
