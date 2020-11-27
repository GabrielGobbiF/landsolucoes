@csrf
<input type="hidden" id="vehicle_id" value="{{ $vehicle->id ?? '' }}" />
<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name" value="{{ $vehicle->name ?? old('name') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--board">Board</label>
                <input type="text" name="board" class="form-control @error('board') is-invalid @enderror" id="input--board" value="{{ $vehicle->board ?? old('board') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--observation">Observation</label>
                <input type="text" name="observation" class="form-control @error('observation') is-invalid @enderror" id="input--observation" value="{{ $vehicle->observation ?? old('observation') }}"
                    autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--year">Year</label>
                <input type="text" name="year" class="form-control @error('year') is-invalid @enderror" id="input--year" value="{{ $vehicle->year ?? old('year') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--secure">Secure</label>
                <input type="text" name="secure" class="form-control @error('secure') is-invalid @enderror" id="input--secure" value="{{ $vehicle->secure ?? old('secure') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--name_company_secure">Name_company_secure</label>
                <input type="text" name="name_company_secure" class="form-control @error('name_company_secure') is-invalid @enderror" id="input--name_company_secure"
                    value="{{ $vehicle->name_company_secure ?? old('name_company_secure') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--number_policy">Number_policy</label>
                <input type="text" name="number_policy" class="form-control @error('number_policy') is-invalid @enderror" id="input--number_policy"
                    value="{{ $vehicle->number_policy ?? old('number_policy') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--vigency_secure">Vigency_secure</label>
                <input type="text" name="vigency_secure" class="form-control @error('vigency_secure') is-invalid @enderror" id="input--vigency_secure"
                    value="{{ $vehicle->vigency_secure ?? old('vigency_secure') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--color">Color</label>
                <input type="text" name="color" class="form-control @error('color') is-invalid @enderror" id="input--color" value="{{ $vehicle->color ?? old('color') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--tracker">Tracker</label>
                <input type="text" name="tracker" class="form-control @error('tracker') is-invalid @enderror" id="input--tracker" value="{{ $vehicle->tracker ?? old('tracker') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--external_camera">External_camera</label>
                <input type="text" name="external_camera" class="form-control @error('external_camera') is-invalid @enderror" id="input--external_camera"
                    value="{{ $vehicle->external_camera ?? old('external_camera') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--internal_camera">Internal_camera</label>
                <input type="text" name="internal_camera" class="form-control @error('internal_camera') is-invalid @enderror" id="input--internal_camera"
                    value="{{ $vehicle->internal_camera ?? old('internal_camera') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--rented">Rented</label>
                <input type="text" name="rented" class="form-control @error('rented') is-invalid @enderror" id="input--rented" value="{{ $vehicle->rented ?? old('rented') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--tracker_company">Tracker_company</label>
                <input type="text" name="tracker_company" class="form-control @error('tracker_company') is-invalid @enderror" id="input--tracker_company"
                    value="{{ $vehicle->tracker_company ?? old('tracker_company') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--rented_company">Rented_company</label>
                <input type="text" name="rented_company" class="form-control @error('rented_company') is-invalid @enderror" id="input--rented_company"
                    value="{{ $vehicle->rented_company ?? old('rented_company') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--mtr">Mtr</label>
                <input type="text" name="mtr" class="form-control @error('mtr') is-invalid @enderror" id="input--mtr" value="{{ $vehicle->mtr ?? old('mtr') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--chassi">Chassi</label>
                <input type="text" name="chassi" class="form-control @error('chassi') is-invalid @enderror" id="input--chassi" value="{{ $vehicle->chassi ?? old('chassi') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="input--renavam">Renavam</label>
                <input type="text" name="renavam" class="form-control @error('renavam') is-invalid @enderror" id="input--renavam" value="{{ $vehicle->renavam ?? old('renavam') }}" autocomplete="off">

            </div>
        </div>
    </div>
</div>

<div class="card-footer">
    <input type="submit" class="btn btn-primary"
        onclick="this.disabled = true; this.value = 'Salvando…'; this.form.submit();" value="Salvar">
</div>
