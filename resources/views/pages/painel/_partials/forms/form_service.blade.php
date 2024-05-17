@csrf
<div class="row mg-0">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--name">Razão Social</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name"
                value="{{ $service->name ?? old('name') }}">
        </div>
    </div>
    <div class="col-md-12">
        @if (isset($service))
            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Excluir Serviço" data-href="{{ route('services.destroy', $service->id) }}"
                class="btn btn-xs btn-danger btn-delete float-left"
                data-original-title="Excluir Serviço"><i class="fa fa-trash"></i> Excluir Serviço
            </a>
        @endif
        <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
    </div>
</div>
