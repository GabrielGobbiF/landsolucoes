@csrf
<input type="hidden" id="vehicle_id" value="{{ $vehicle->id ?? '' }}" />
<h4 class="header mt-0 pt-3 pl-3">Dados</h4>
<div class="card-body">
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="input--name">Nome</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name" value="{{ $vehicle->name ?? old('name') }}" autocomplete="off" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="input--board">Placa</label>
                <input type="text" name="board" class="form-control @error('board') is-invalid @enderror" id="input--board" value="{{ $vehicle->board ?? old('board') }}" autocomplete="off" required>

            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="input--year">Ano Fabricação</label>
                <input type="text" name="year" class="form-control @error('year') is-invalid @enderror" id="input--year" value="{{ $vehicle->year ?? old('year') }}" autocomplete="off" required>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="input--color">Cor</label>
                <input type="text" name="color" class="form-control @error('color') is-invalid @enderror" id="input--color" value="{{ $vehicle->color ?? old('color') }}" autocomplete="off">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="input--mtr">MTR</label>
                <input type="text" name="mtr" class="form-control @error('mtr') is-invalid @enderror" id="input--mtr" value="{{ $vehicle->mtr ?? old('mtr') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="input--chassi">Chassi</label>
                <input type="text" name="chassi" class="form-control @error('chassi') is-invalid @enderror" id="input--chassi" value="{{ $vehicle->chassi ?? old('chassi') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="input--renavam">Renavam</label>
                <input type="text" name="renavam" class="form-control @error('renavam') is-invalid @enderror" id="input--renavam" value="{{ $vehicle->renavam ?? old('renavam') }}"
                    autocomplete="off">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="input--renavam">Tipo</label>
                <select name='type' class='form-control select2' required>
                    <option value='' selected>Selecione</option>
                    @foreach (Config::get('constants.tipo_vehicle') as $type)
                        <option
                            {{ isset($vehicle->type) && $vehicle->type == $type ? 'selected' : '' }}
                            value='{{ $type }}'>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        @if (isset($vehicle) && $vehicle->document_attach != '')
            <div class="col-md-5 my-3">
                <div class="form-group d-grid">
                    <a target="_blank" href="{{ asset('storage/' . $vehicle->document_attach) }}">Visualizar documento</a>
                    <a href='JavaScript:void(0)' onclick='btn_delete(this)' data-toggle='tooltip' data-placement='top' data-title='Deletar'
                        data-href='{{ route('vehicles.document.destroy', $vehicle->id) }}'
                        class='btn btn-sm btn-danger btn-delete'
                        data-original-title='Deletar Documento'>
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>
        @else
            <div class="col-md-5">
                <div class="form-group">
                    <label for="input--renavam">Documento</label>
                    <input type="file" name="document_attach" id="file_document">
                </div>
            </div>
        @endif

        <div class="col-md-12 row mt-3 mb-4">
            <div class="col-md-2">
                <div class="custom-control custom-switch">
                    <input {{ isset($vehicle->secure) && $vehicle->secure == '1' ? 'checked' : '' }} type="checkbox" class="custom-control-input companySwitch" name="secure" id="secureSwitch"
                        data-label="secure">
                    <label class="custom-control-label" for="secureSwitch">
                        <a class="" data-toggle="collapse" href="#collapseSecure" aria-expanded="true" aria-controls="collapseSecure">
                            Seguro
                        </a>
                    </label>
                </div>
            </div>

            <div class="col-md-2">
                <div class="custom-control custom-switch">
                    <input {{ isset($vehicle->tracker) && $vehicle->tracker == '1' ? 'checked' : '' }} type="checkbox" class="custom-control-input companySwitch" name="tracker" id="trackerSwitch"
                        data-label="tracker">
                    <label class="custom-control-label" for="trackerSwitch">
                        <a class="" data-toggle="collapse" href="#collapseTracker" aria-expanded="true" aria-controls="collapseTracker">
                            Rastreador
                        </a>
                    </label>
                </div>
            </div>

            <div class="col-md-2">
                <div class="custom-control custom-switch">
                    <input {{ isset($vehicle->rented) && $vehicle->rented == '1' ? 'checked' : '' }} type="checkbox" class="custom-control-input companySwitch" name="rented" id="rentedSwitch"
                        data-label="rented">
                    <label class="custom-control-label" for="rentedSwitch">
                        <a class="" data-toggle="collapse" href="#collapseRented" aria-expanded="true" aria-controls="collapseRented">
                            Alugado
                        </a>
                    </label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="custom-control custom-switch">
                    <input {{ isset($vehicle->external_camera) && $vehicle->external_camera == '1' ? 'checked' : '' }} type="checkbox" class="custom-control-input" name="external_camera"
                        id="cameraExternalSwtich">
                    <label class="custom-control-label" for="cameraExternalSwtich">
                        Câmera Externa
                    </label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="custom-control custom-switch">
                    <input {{ isset($vehicle->internal_camera) && $vehicle->internal_camera == '1' ? 'checked' : '' }} type="checkbox" class="custom-control-input" name="internal_camera"
                        id="cameraInternalSwitch">
                    <label class="custom-control-label" for="cameraInternalSwitch">
                        Câmera Interna
                    </label>
                </div>
            </div>
        </div>

        <div class="collapse w-100" id="collapseSecure">
            <div class="card card-body mb-0">
                <h1 class="card-title">Seguro</h1>
                <div class="form-group">
                    <label for="input--name_company_secure">Empresa de Seguros</label>
                    <input type="text" name="name_company_secure" class="form-control @error('name_company_secure') is-invalid @enderror" id="input--name_company_secure"
                        value="{{ $vehicle->name_company_secure ?? old('name_company_secure') }}" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="collapse w-100 mt-1" id="collapseTracker">
            <div class="card card-body mb-0">
                <h1 class="card-title">Rastreador</h1>
                <div class="form-group">
                    <label for="input--tracker_company">Empresa Rastreador</label>
                    <input type="text" name="tracker_company" class="form-control @error('tracker_company') is-invalid @enderror" id="input--tracker_company"
                        value="{{ $vehicle->tracker_company ?? old('tracker_company') }}" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="collapse w-100 mt-1" id="collapseRented">
            <div class="card card-body mb-0">
                <h1 class="card-title">Alugado</h1>
                <div class="form-group">
                    <label for="input--rented_company">Empresa Locatária</label>
                    <input type="text" name="rented_company" class="form-control @error('rented_company') is-invalid @enderror" id="input--rented_company"
                        value="{{ $vehicle->rented_company ?? old('rented_company') }}" autocomplete="off">
                </div>
            </div>
        </div>

    </div>
</div>

<div class="card-footer">
    <button type="button" class="btn btn-primary btn-submit">Salvar</button>
</div>
