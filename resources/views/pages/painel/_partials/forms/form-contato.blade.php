<div class="row mt-2">
    <input type="hidden" name="contato[id][]" value="{{ $contato->id }}">
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="input--nome">Nome</label>
            <input type="text" name="contato[nome][]" class="form-control @error('nome') is-invalid @enderror" id="input--nome" value="{{ $contato->nome ?? old('nome') }}" autocomplete="off"
                required>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="input--email">Email</label>
            <input type="text" name="contato[email][]" class="form-control @error('email') is-invalid @enderror" id="input--email" value="{{ $contato->email ?? old('email') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group">
            <label for="input--telefone">Telefone</label>
            <input type="text" name="contato[telefone][]" class="form-control @error('telefone') is-invalid @enderror phone" id="input--telefone" value="{{ $contato->telefone ?? old('telefone') }}"
                autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group">
            <label for="input--celular">Celular</label>
            <input type="text" name="contato[celular][]" class="form-control @error('celular') is-invalid @enderror sp_celphones" id="input--celular"
                value="{{ $contato->celular ?? old('celular') }}"
                autocomplete="off">
        </div>
    </div>

    <div class="col-1 align-self-center mobile--hidden">
        <div style="margin-top: 11px" class="d-flex">
            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Excuir"
                data-href="{{ route('fornecedor.contato.destroy', [$fornecedor->id, $contato->id]) }}"
                class="btn btn-xs btn-danger js-btn-delete ml-1"
                data-text="Excluir Contato">
                <i class="fa fa-trash"></i>
            </a>
        </div>
    </div>
</div>
