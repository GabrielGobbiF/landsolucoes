@csrf

<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--razao_social">Razão Social</label>
            <input type="text" name="razao_social" class="form-control @error('razao_social') is-invalid @enderror" id="input--razao_social"
                value="{{ $fornecedor->razao_social ?? old('razao_social') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--cnpj">CNPJ</label>
            <input type="text" name="cnpj" class="form-control @error('cnpj') is-invalid @enderror cnpj" id="input--cnpj" value="{{ $fornecedor->cnpj ?? old('cnpj') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--endereco">Endereço</label>
            <textarea type="text" name="endereco" class="form-control @error('endereco') is-invalid @enderror" id="input--endereco" cols="30" rows="4">{{ $fornecedor->endereco ?? old('endereco') }}</textarea>
        </div>
    </div>

</div>
