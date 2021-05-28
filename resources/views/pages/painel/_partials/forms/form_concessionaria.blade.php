@csrf
<div class="box box-default box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Dados</h3>
    </div>
    <div class="box-body">
        <div class="row mg-0">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="input--name">Razão Social</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name"
                        value="{{ $concessionaria->name ?? old('name') }}">
                </div>
            </div>

            @if (isset($services))
                <div class="col-md-4">
                    <label for="service">Serviço</label>
                    <select name="service" data-placeholder="Selecione o serviço" class="form-control select2 @error('service') is-invalid @enderror">
                        <option value="" selected></option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="col-md-12 pd-0">
                <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
            </div>
        </div>
    </div>
</div>
