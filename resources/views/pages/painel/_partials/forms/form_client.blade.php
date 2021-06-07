@csrf
<div class="box box-default bd-t-0">
    <div class="box-header with-border">
        <h3 class="box-title">Dados</h3>
    </div>
    <div class="box-body">
        <div class="row mg-0">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="input--company_name">Razão Social</label>
                    <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" id="input--company_name"
                        value="{{ $client->company_name ?? old('company_name') }}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="input--username">Apelido</label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="input--username" value="{{ $client->username ?? old('username') }}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="input--cnpj">CNPJ</label>
                    <input type="text" name="cnpj" class="form-control @error('cnpj') is-invalid @enderror cpf-cnpj" id="input--cnpj" value="{{ $client->cnpj ?? old('cnpj') }}">
                </div>
            </div>

            <div class="col-md-12">
                <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
            </div>
        </div>
    </div>
</div>
