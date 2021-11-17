@csrf
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--nome">Nome</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name" value="{{ $produto->name ?? old('name') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="input--unidade">Unidade</label>
            <input type="text" name="unidade" class="form-control @error('unidade') is-invalid @enderror" id="input--unidade" value="{{ $produto->unidade ?? old('unidade') }}" autocomplete="off"
                required>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="input--preco">Valor</label>
            <input type="text" name="preco" class="form-control @error('preco') is-invalid @enderror money" id="input--preco" value="{{ $produto->preco ?? old('preco') }}" autocomplete="off"
                required>
        </div>
    </div>
</div>

<div class="row">
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

    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="input--sub-categoria">Sub Categoria</label>
            <select name='sub-categoria' class='form-control' id="select--sub-categoria" required>
                @foreach (config('admin.produtos.categorias') as $categoria)
                    <option {{ isset($produto) && $produto->categoria == $categoria ? 'selected' : '' }} value='{{ $categoria }}'>{{ $categoria }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--descricao">Descricao</label>
            <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror" id="input--descricao" cols="30" rows="2">{{ $produto->descricao ?? old('descricao') }}</textarea>
        </div>
    </div>
</div>

@section('scripts')

    <script>
        $('#select--categoria').on('change', function() {

        })
    </script>
@append
