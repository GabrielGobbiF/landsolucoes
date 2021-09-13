@csrf
<div class="row">
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="input--coluna_faturamento">Coluna de Faturamento</label>
            <select name='coluna_faturamento' class='form-control select2' required>
                <option value='' selected>Selecione</option>
                @foreach (config('admin.colunas_faturamento') as $colunas_faturamento)
                    <option {{ old('colunas_faturamento') && old('colunas_faturamento') == $colunas_faturamento ? 'selected' : '' }} value='{{ $colunas_faturamento }}'>
                        {{ $colunas_faturamento }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group">
            <label for="input--nf_n">NF Nº</label>
            <input type="text" name="nf_n" class="form-control @error('nf_n') is-invalid @enderror" id="input--nf_n" value="{{ old('nf_n') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group">
            <label for="input--data_emissao">Data Emissão</label>
            <input type="text" name="data_emissao" class="form-control date @error('data_emissao') is-invalid @enderror" id="input--data_emissao"
                value="{{ old('data_emissao') ?? date('Y-m-d') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group">
            <label for="input--data_vencimento">Data Vencimento</label>
            <input type="text" name="data_vencimento" class="form-control date @error('data_vencimento') is-invalid @enderror" id="input--data_vencimento"
                value="{{ old('data_vencimento') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group form-group-money">
            <label for="input--price">Valor</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text-cifr">R$</span>
                </div>
                <input type="text" name="valor" class="form-control @error('valor') is-invalid @enderror money" id="input--valor" value="{{ old('valor') }}" autocomplete="off" required>
            </div>
        </div>
    </div>

</div>
