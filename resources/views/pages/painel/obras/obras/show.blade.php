@extends("app")

@section('title', ucfirst($obra->razao_social) . ' - ' . $obra->last_note)

@section('content-max-fluid')

    <div class="page--obra">

        <div class="sidenav">
            <div class="col-12">
                <div class="box-body">

                    <input type="hidden" id="input--obra_id" value="{{ $obra->id }}">

                    <div class="row">
                        <h4 class="col-12 mb-3">Obra <small class="text-muted js-input-obra-name editable">{{ $obra->razao_social ?? '' }}</small></h4>
                        <h6 class="col-12 mb-3 d-flex tx-18"> <i class="ri-community-line mr-2"></i> {{ $obra->concessionaria->name ?? '' }}</h6>
                        <h6 class="col-12 mb-3 d-flex tx-18"> <i class="ri-git-repository-private-fill mr-2"></i> {{ $obra->service->name ?? '' }}</h6>
                        <h6 class="col-12 mb-3 d-flex tx-18"> <i class="ri-calendar-event-line mr-2"></i> {{ return_format_date($obra->build_at, 'pt', '/') ?? '' }}</h6>

                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label for="input--description">Descrição da Obra</label>
                                <textarea type="text" name="description" class="form-control">{{ $obra->description ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="input--description">Informações Importantes</label>
                                <textarea type="text" name="description" class="form-control">{{ $obra->obr_informacoes ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-none">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="input--razao_social">Obra</label>
                                <input type="text" name="razao_social" class="form-control @error('razao_social') is-invalid @enderror" id="input--razao_social"
                                    value="{{ $obra->razao_social ?? old('razao_social') }}" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="input--concessionaria">Concessionaria</label>
                                <input type="text" name="concessionaria" class="form-control" readonly disabled id="input--concessionaria" value="{{ $obra->concessionaria->name }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="input--service">Tipo de Obra / Serviço</label>
                                <input type="text" name="service" class="form-control" readonly disabled id="input--service" value="{{ $obra->service->name }}">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="input--build_at">Data</label>
                                <input type="text" name="build_at" class="form-control" id="input--build_at" value="{{ old('build_at') ?? $obra->build_at }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="input--description">Descrição</label>
                                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="input--description"
                                    value="{{ $obra->description ?? old('description') }}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main">
            <div class="col-12 col-md-8">
                <div class="obr-etapa">
                    <div class="box box-default box-solid">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title text-center mb-2">Etapas</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="type" id="select--type" class="form-control select2 search-input">
                                            <option value="" selected>Todos</option>
                                            @foreach ($tipos as $tipo)
                                                <option value="{{ $tipo->id }}">{{$tipo->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control search-input" name="term" id="input--term" value="" autocomplete="off" placeholder="Buscar...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body mg-0 pd-0">
                                <ul class="message-list" id="etapas-list" style="padding: 5px 0px 0px 1px;"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('pages.painel.obras.obras.etapas.show_right')
    </div>


@section('scripts')
    <script src="{{ asset('panel/js/pages/obras.js') }}"></script>
@endsection

@stop
