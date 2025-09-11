@csrf
<div class="row">

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--name">Nome</label>
            <input id="input--name" type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ $visitor->name ?? old('name') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--company_name">Empresa</label>
            <input id="input--company_name" type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror"
                   value="{{ $visitor->company_name ?? old('company_name') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--finality">Finalidade</label>
            <input id="input--finality" type="text" name="finality" class="form-control @error('finality') is-invalid @enderror"
                   value="{{ $visitor->finality ?? old('finality') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--rms">Numero RMS</label>
            <input id="input--rms" type="text" name="rms" class="form-control @error('rms') is-invalid @enderror"
                   value="{{ $visitor->rms ?? old('rms') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--document">Documento</label>
            <input id="input--document" type="text" name="document" class="form-control @error('document') is-invalid @enderror"
                   value="{{ $visitor->document ?? old('document') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--vehicle_model">Modelo do Veiculo</label>
            <input id="input--vehicle_model" type="text" name="vehicle_model" class="form-control @error('vehicle_model') is-invalid @enderror"
                   value="{{ $visitor->vehicle_model ?? old('vehicle_model') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--vehicle_plate">Placa do Veiculo</label>
            <input id="input--vehicle_plate" type="text" name="vehicle_plate" class="form-control @error('vehicle_plate') is-invalid @enderror"
                   value="{{ $visitor->vehicle_plate ?? old('vehicle_plate') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--vehicle_color">Cor do Veiculo</label>
            <input id="input--vehicle_color" type="text" name="vehicle_color" class="form-control @error('vehicle_color') is-invalid @enderror"
                   value="{{ $visitor->vehicle_color ?? old('vehicle_color') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--visitor_at">Data da Visita</label>
            <input id="input--visitor_at" type="datetime-local" name="visitor_at" class="form-control  @error('visitor_at') is-invalid @enderror"
                   value="{{ isset($visitor) ? formatDateAndTime($visitor->visitor_at, 'Y-m-d\TH:i') : old('visitor_at') }}" autocomplete="off" required>
        </div>
    </div>

</div>
