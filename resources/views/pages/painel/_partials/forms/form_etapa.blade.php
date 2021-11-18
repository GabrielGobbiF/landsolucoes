@csrf

<input type="hidden" name="tipo_id" class="form-control @error('tipo_id') is-invalid @enderror" id="input--tipo_id" value="" autocomplete="off">
<input type="hidden" name="concessionaria" value="{{ $concessionaria->id ?? false }}">
<input type="hidden" name="service" value="{{ $service->id ?? false }}">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="input--name">Nome da Etapa</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name" value="" autocomplete="off" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="input--descricao">Descrição</label>
            <input type="text" name="descricao" class="form-control @error('descricao') is-invalid @enderror" id="input--descricao" value=""
                autocomplete="off">
        </div>
    </div>
</div>

<div class="d-none compra">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="input--quantidade">Quantidade</label>
                <input type="text" name="quantidade" class="form-control @error('quantidade') is-invalid @enderror" id="input--quantidade" value=""
                    autocomplete="off">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="input--preco">Preço</label>
                <input type="text" name="preco" class="form-control @error('preco') is-invalid @enderror money" id="input--preco" value="" autocomplete="off">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="input--unidade">Unidade</label>
                <input type="text" name="unidade" class="form-control @error('unidade') is-invalid @enderror" id="input--unidade" value=""
                    autocomplete="off">
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label for="input--categoria">Categoria</label>
                <select name='categoria' class='form-control select2' id="select--categoria" required>
                    @foreach (config('admin.produtos.categorias') as $categoria)
                        <option {{ isset($produto) && $produto->categoria == $categoria ? 'selected' : '' }} value='{{ $categoria }}'>{{ $categoria }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label for="input--sub_categoria">Sub Categoria</label>
                <select name='sub_categoria' class='form-control' id="select--sub_categoria"></select>
            </div>
        </div>
    </div>

    <div class="box box-primary mt-3 mb-3">
        <div class="box-header with-border">
            <h3 class="box-title">Variaveis</h3>

            <div class="box-tools pull-right">
                <a class="btn btn-sm btn-info btn-flat btn-new_variavel_edit"> <i class="fa fa-fw fa-plus-circle"></i></a>

            </div>
        </div>
        <div class="box-body">
            <div id="new_variavel_edit"></div>
            <div id="variavel_etapa"></div>
        </div>
    </div>
</div>
