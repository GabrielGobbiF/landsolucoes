@csrf
<input type="hidden" id="concessionaria_id" value="{{ $concessionaria->id }}">
<input type="hidden" id="concessionaria_slug" value="{{ $concessionaria->slug }}">
<div class="box box-default box-solid">
    <div class="col-md-12">
        <div class="box-header with-border">
            <h3 class="box-title">Dados</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="input--name">Razão Social</label>
                        <input id="input--name" type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ $concessionaria->name ?? old('name') }}">
                    </div>
                </div>

                @if (isset($services))
                    <div class="col-md-12">
                        <label for="service">Serviços</label>
                        <select name="service[]" data-placeholder="Selecione o serviço" class="form-control select2 @error('service') is-invalid @enderror"
                                multiple>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="col-md-12 mt-4">
                    @if (isset($concessionaria))
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Excluir Concessionaria"
                           data-href="{{ route('concessionarias.destroy', $concessionaria->id) }}" class="btn btn-xs btn-danger btn-delete float-left"
                           data-original-title="Excluir Concessionaria"><i class="fa fa-trash"></i> <span class="mobile--hidden">Excluir Concessionaria</span>
                        </a>
                    @endif
                    <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>
