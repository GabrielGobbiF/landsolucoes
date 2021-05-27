@csrf
    <div class="row mg-0">
        <div class="col-md-4">
            <div class="form-group">
                <label for="input--name">Razão Social</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name"
                    value="{{ $service->name ?? old('name') }}">
            </div>
        </div>

        <div class="col-md-12">
            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
        </div>
    </div>
