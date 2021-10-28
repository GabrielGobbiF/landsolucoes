@csrf
<div class="row">

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="input--nome">Nome</label>
            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" id="input--nome" value="{{ $produto->nome ?? old('nome') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group">
            <label for="input--unidade">Unidade</label>
            <input type="text" name="unidade" class="form-control @error('unidade') is-invalid @enderror" id="input--unidade" value="{{ $produto->unidade ?? old('unidade') }}" autocomplete="off"
                required>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="input--valor">Valor</label>
            <input type="text" name="valor" class="form-control @error('valor') is-invalid @enderror money" id="input--valor" value="{{ $produto->valor ?? old('valor') }}" autocomplete="off"
                required>
        </div>
    </div>


    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="input--categoria">Categoria</label>

            <select name='categoria' class='form-control' id="select--categoria" required>
                @foreach (config('admin.produtos.categorias') as $categoria)
                    <option {{ isset($produto) && $produto->categoria == $categoria ? 'selected' : '' }} value='{{ $categoria }}'>{{ $categoria }}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--descricao">Descricao</label>
            <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror" id="input--descricao" cols="30" rows="2">{{ $produto->descricao ?? old('descricao') }}</textarea>
        </div>
    </div>



</div>
