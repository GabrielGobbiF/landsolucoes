@csrf
<div class="row">

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--name">Nome</label>
            <input id="input--name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $driver->name ?? old('name') }}"
                   autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--cpf">CPF</label>
            <input id="input--cpf" type="number" name="cpf" class="form-control @error('cpf') is-invalid @enderror"
                   value="{{ $driver->cpf ?? old('cpf') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--cnh_number">CNH</label>
            <input id="input--cnh_number" type="number" name="cnh_number" class="form-control @error('cnh_number') is-invalid @enderror"
                   value="{{ $driver->cnh_number ?? old('cnh_number') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--cnh_validity">CNH Validade</label>
            <input id="input--cnh_validity" type="date" name="cnh_validity" class="form-control @error('cnh_validity') is-invalid @enderror"
                   value="{{ isset($driver) ? formatDateAndTime($driver->cnh_validity, 'Y-m-d') : old('cnh_validity') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--cnh_category">CNH Categoria</label>
            <input id="input--cnh_category" type="text" max="2" name="cnh_category" class="form-control @error('cnh_category') is-invalid @enderror"
                   value="{{ $driver->cnh_category ?? old('cnh_category') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--re">RE</label>
            <input id="input--re" type="text" name="re" class="form-control @error('re') is-invalid @enderror" value="{{ $driver->re ?? old('re') }}"
                   autocomplete="off">
        </div>
    </div>

</div>
