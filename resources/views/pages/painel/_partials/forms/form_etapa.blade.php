@csrf
<div class="row mg-0">
    <input type="hidden" name="tipo_id" class="form-control @error('tipo_id') is-invalid @enderror" id="input--tipo_id" value="{{ $product->tipo_id ?? old('tipo_id') }}" autocomplete="off">

    <div class="col-md-4">
        <div class="form-group">
            <label for="input--name">Nome da Etapa</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name" value="{{ $product->name ?? old('name') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-md-8">
        <div class="form-group">
            <label for="input--descricao">Descrição</label>
            <input type="text" name="descricao" class="form-control @error('descricao') is-invalid @enderror" id="input--descricao" value="{{ $product->descricao ?? old('descricao') }}"
                autocomplete="off">
        </div>
    </div>

    <div id="compra" class="d-none">
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--quantidade">Quantidade</label>
                <input type="text" name="quantidade" class="form-control @error('quantidade') is-invalid @enderror" id="input--quantidade" value="{{ $product->quantidade ?? old('quantidade') }}"
                    autocomplete="off">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="input--preco">Preco</label>
                <input type="text" name="preco" class="form-control @error('preco') is-invalid @enderror" id="input--preco" value="{{ $product->preco ?? old('preco') }}" autocomplete="off">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="input--unidade">Unidade</label>
                <input type="text" name="unidade" class="form-control @error('unidade') is-invalid @enderror" id="input--unidade" value="{{ $product->unidade ?? old('unidade') }}"
                    autocomplete="off">
            </div>
        </div>
    </div>
</div>
