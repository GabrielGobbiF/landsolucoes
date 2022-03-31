@csrf
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--code">Código</label>
            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" id="input--code" value="{{ $handswork->code ?? old('code') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--description">Descrição</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="input--description" value="{{ $handswork->description ?? old('description') }}"
                autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--price_ups">Preço UPS</label>
            <input type="number" name="price_ups" class="form-control @error('price_ups') is-invalid @enderror" id="input--price_ups" value="{{ $handswork->price_ups ?? old('price_ups') }}"
                autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group form-group-money">
            <label for="input--price">Preço</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text-cifr">R$</span>
                </div>
                <input type="text" name="price" class="form-control @error('price') is-invalid @enderror money" id="input--price" value="{{ $handswork->price ?? old('price') }}" autocomplete="off">
            </div>
        </div>
    </div>

</div>
