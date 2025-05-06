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
            <input type="text" name="nf_n" class="form-control @error('nf_n') is-invalid @enderror" required id="input--nf_n" value="{{ old('nf_n') ?? '' }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group">
            <label for="input--data_emissao">Data Emissão</label>
            <input type="text" name="data_emissao" class="form-control date @error('data_emissao') is-invalid @enderror" id="input--data_emissao"
                value="{{ old('data_emissao') ?? date('d/m/Y') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group">
            <label for="input--data_vencimento">Data Vencimento</label>
            <input type="text" name="data_vencimento" class="form-control date @error('data_vencimento') is-invalid @enderror" data-flatpickr='{"dateFormat": "d/m/Y H:i:S"}' id="input--data_vencimento"
                value="{{ old('data_vencimento') ?? '' }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="form-group form-group-money">
            <label for="input--price">Valor</label>
            <div class="input-group mb-3">
                <input type="text" name="valor"
                data-inputmask="'alias': 'currency', 'numericInput': 'true', 'prefix': 'R$ ', 'radixPoint': ',' "
                class="form-control @error('valor') is-invalid @enderror" id="input--valor" value="{{ old('valor') ?? '' }}" autocomplete="off" required>
            </div>
        </div>
    </div>

    <div class="col-md-12" style="text-align: end;">
        <button type="button" class="btn btn-primary btn-submit"> <i class="fas fa-edit"></i> Adicionar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
    </div>

</div>
