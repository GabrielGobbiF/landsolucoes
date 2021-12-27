@csrf
<div class="row">
    <input type="hidden" name="variable[id][]" value="{{ $variable->id ?? '' }}">

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--nome">Nome</label>
            <input type="text" name="variable[name][]" class="form-control @error('name') is-invalid @enderror" id="input--name" value="{{ $variable->name ?? old('name') }}" autocomplete="off"
                required>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group">
            <label for="input--nome">Preço</label>
            <input type="text" name="variable[price][]" class="form-control @error('price') is-invalid @enderror money" id="input--price" value="{{ $variable->price ?? old('price') }}"
                autocomplete="off" required>
        </div>
    </div>

    <div class="col-1 align-self-center mobile--hidden">
        <div style="margin-top: 11px" class="d-flex">
            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Excuir"
                data-href="{{ route('produto.variable.destroy', [$produto->id, $variable->id]) }}"
                class="btn btn-xs btn-danger js-btn-delete ml-1"
                data-text="Excluir Variavel">
                <i class="fa fa-trash"></i>
            </a>
        </div>
    </div>
</div>
