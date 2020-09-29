@csrf
<input type="hidden" id="employee_id" value="{{ $employee->uuid ?? ''}}" />
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
                <input type="text" name="rg" class="form-control @error('rg') is-invalid @enderror" id="input--rg"
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
                <input type="text" name="estado_civil" class="form-control @error('estado_civil') is-invalid @enderror"
                    id="input--estado_civil" value="{{ $employee->estado_civil ?? old('estado_civil') }}">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="input--cargo">Cargo</label>
                <input type="text" name="cargo" class="form-control @error('cargo') is-invalid @enderror"
                    id="input--cargo" value="{{ $employee->cargo ?? old('cargo') }}">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="input--salario">Salario</label>
                <input type="text" name="salario" class="form-control @error('salario') is-invalid @enderror"
                    id="input--salario" value="{{ $employee->salario ?? old('salario') }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="input--cnh">CNH</label>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck"
                            value="{{ $employee->cnh ?? old('cnh') }}">
                        <label class="form-check-label" for="gridCheck">
                            Sim
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <input  type="submit" class="btn btn-primary" onclick="this.disabled = true; this.value = 'Salvando…'; this.form.submit();" value="Salvar">
</div>
