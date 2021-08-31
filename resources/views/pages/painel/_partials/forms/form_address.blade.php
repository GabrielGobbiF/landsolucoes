@csrf
<div class="row">
    <input type="hidden" name="address[id]" id="input--id" value="{{ $address->id ?? old('id') }}">

    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="input--cep">Cep</label>
            <input type="text" name="address[cep]" class="form-control @error('cep') is-invalid @enderror" id="input--cep" maxlength="9" onblur="pesquisacep(this.value);"
                value="{{ $address->cep ?? old('cep') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-7">
        <div class="form-group">
            <label for="input--street">Rua</label>
            <input type="text" name="address[street]" class="form-control @error('street') is-invalid @enderror" id="input--street" value="{{ $address->street ?? old('street') }}" autocomplete="off"
            >
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group">
            <label for="input--number">Nº </label>
            <input type="text" name="address[number]" class="form-control @error('number') is-invalid @enderror" id="input--number" value="{{ $address->number ?? old('number') }}"
                autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--city">Cidade</label>
            <input type="text" name="address[city]" class="form-control @error('city') is-invalid @enderror" id="input--city" value="{{ $address->city ?? old('city') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="input--district">Bairro</label>
            <input type="text" name="address[district]" class="form-control @error('district') is-invalid @enderror" id="input--district" value="{{ $address->district ?? old('district') }}"
                autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group">
            <label for="input--state">Estado</label>
            <input type="text" name="address[state]" class="form-control @error('state') is-invalid @enderror" id="input--state" value="{{ $address->state ?? old('state') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--complement">Complemento</label>
            <input type="text" name="address[complement]" class="form-control @error('complement') is-invalid @enderror" id="input--complement"
                value="{{ $address->complement ?? old('complement') }}"
                autocomplete="off">
        </div>
    </div>
</div>
