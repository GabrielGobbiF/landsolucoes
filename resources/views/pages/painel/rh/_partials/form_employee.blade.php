@csrf
<input type="hidden" id="employee_id" value="{{ $employee->uuid ?? '' }}" />
<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--name">Nome Completo</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name"
                    value="{{ $employee->name ?? old('name') }}" autocomplete="off">
                <div class="invalid-feedback">
                    Nome completo
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="input--email">Email</label>
                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                    id="input--email" value="{{ $employee->email ?? old('email') }}" autocomplete="off">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="input--rg">RG</label>
                <input type="text" name="rg" class="form-control rg @error('rg') is-invalid @enderror" id="input--rg"
                    value="{{ $employee->rg ?? old('rg') }}" autocomplete="off">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="input--ctps">CTPS</label>
                <input type="text" name="ctps" class="form-control @error('ctps') is-invalid @enderror" id="input--ctps"
                    value="{{ $employee->ctps ?? old('ctps') }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="input--endereco">Endereço</label>
                <input type="text" name="endereco" class="form-control @error('endereco') is-invalid @enderror"
                    id="input--endereco" value="{{ $employee->endereco ?? old('endereco') }}" autocomplete="off">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="input--estado_civil">Estado Civil</label>
                <select name="estado_civil" id="input--estado_civil"
                    class="form-control @error('estado_civil') is-invalid @enderror">
                    <option
                        {{ isset($employee->estado_civil) && $employee->estado_civil == 'Solteiro' ? 'selected' : '' }}
                        value="Solteiro" class="">Solteiro</option>
                    <option
                        {{ isset($employee->estado_civil) && $employee->estado_civil == 'Casado' ? 'selected' : '' }}
                        value="Casado" class="">Casado</option>
                    <option {{ isset($employee->estado_civil) && $employee->estado_civil == 'União Estável' ? 'selected' : '' }}
                        value="União Estável" class="">União estável</option>
                    <option {{ isset($employee->estado_civil) && $employee->estado_civil == 'Divorciado' ? 'selected' : '' }}
                        value="Divorciado" class="">Divorciado</option>
                    <option
                        {{ isset($employee->estado_civil) && $employee->estado_civil == 'Não especificado' ? 'selected' : '' }}
                        value="Não especificado" class="">Não especificado</option>

                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="input--cargo">Cargo</label>
                <input type="text" name="cargo" class="form-control  @error('cargo') is-invalid @enderror"
                    id="input--cargo" value="{{ $employee->cargo ?? old('cargo') }}">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="input--salario">Salário</label>
                <input type="text" name="salario" class="form-control money @error('salario') is-invalid @enderror"
                    id="input--salario" value="{{isset($employee->salario) ? number_format($employee->salario, 2, ',', ' ') : old('salario')   }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="input--date_contract">Data Contratação</label>
                <input type="text" name="date_contract"
                    class="form-control date @error('date_contract') is-invalid @enderror" id="input--date_contract"
                    value="{{ isset($employee->date_contract) ? date('d/m/Y', strtotime($employee->date_contract)) : '10/10/2020' }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="input--cnh">CNH</label>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="cnh_check" name="cnh" value="1"
                            {{ isset($employee->cnh) && $employee->cnh == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="cnh_check">
                            Sim
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 {{ isset($employee->cnh) && $employee->cnh != 0 ? '' : 'd-none' }} div--cnh_number">
            <div class="form-group">
                <label for="input--cnh_number">CNH Nº</label>
                <input type="text" name="cnh_number" class="form-control @error('cnh_number') is-invalid @enderror"
                    id="input--cnh_number" value="{{ $employee->cnh_number ?? old('cnh_number') }}">
            </div>
        </div>
        <div class="col-md-3 {{ isset($employee->cnh) && $employee->cnh != 0 ? '' : 'd-none' }} div--cnh_validity">
            <div class="form-group">
                <label for="input--cnh_validity">CNH Validade</label>
                <input type="text" name="cnh_validity" class="form-control date @error('cnh_validity') is-invalid @enderror"
                    id="input--cnh_validity" value="{{ $employee->cnh_validity ?? old('cnh_validity') }}">
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <input type="submit" class="btn btn-primary"
        onclick="this.disabled = true; this.value = 'Salvando…'; this.form.submit();" value="Salvar">
</div>
