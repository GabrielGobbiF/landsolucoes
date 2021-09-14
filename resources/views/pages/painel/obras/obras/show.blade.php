@extends("app")

@section('title', ucfirst($obra->razao_social) . ' - ' . $obra->last_note)

@section('content-max-fluid')

    <div class="page--obra">

        <div class="sidenav">
            <div class="col-12">
                <div class="box-body">

                    <input type="hidden" id="input--obra_id" value="{{ $obra->id }}">

                    <div class="row mt-4">
                        <h4 class="col-12 mb-3">Obra <small class="text-muted js-input-obra-name editable">{{ $obra->razao_social ?? '' }}</small></h4>
                        <h6 class="col-12 mb-3 d-flex tx-18"> <i class="ri-community-line mr-2"></i> {{ $obra->concessionaria->name ?? '' }}</h6>
                        <h6 class="col-12 mb-3 d-flex tx-18"> <i class="ri-git-repository-private-fill mr-2"></i> {{ $obra->service->name ?? '' }}</h6>
                        <h6 class="col-12 mb-3 d-flex tx-18"> <i class="ri-calendar-event-line mr-2"></i> {{ return_format_date($obra->build_at, 'pt', '/') ?? '' }}</h6>
                        <h6 class="col-12 mb-3 d-flex tx-18"> <i class="fas fa-map-marked mr-2"></i> {{ $obra->AddressComplete }}</h6>

                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label style="width:100%" for="input--description">Descrição da Obra <span class="description-span-save float-right"><span> </label>
                                <textarea type="text" name="description" class="form-control input-update-obra">{{ $obra->description ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label style="width:100%" for="input--description">Informações Importantes <span class="obr_informacoes-span-save float-right"><span></label>
                                <textarea type="text" name="obr_informacoes" class="form-control input-update-obra">{{ $obra->obr_informacoes ?? '' }}</textarea>
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
                <div class="box box-default box-solid">
                    <div class="box-body mg-0 pd-0">
                        <div class="mail-content-header d-flex">
                            <button type='button' class='btn btn-outline-primary' data-toggle='modal' data-target='#modal-update-obra'>Editar Obra</button>
                            <a href="{{ route('obras.finance', $obra->id) }}" class='btn btn-outline-primary ml-2'>Financeiro <i class="fas fa-long-arrow-alt-right"></i></a>
                            <a href="{{ route('comercial.show', $obra->id) }}" class='btn btn-outline-primary ml-2'>Comercial <i class="fas fa-long-arrow-alt-right"></i></a>
                            <nav class="nav nav-icon-only mg-l-auto">
                                <a href="javascript:void(0)" data-text="Arquivar" data-href="{{ route('obras.concluir', $obra->id) }}" rel="tooltip" title="Concluir Obra" class="nav-link d-none d-sm-block js-btn-delete">
                                    <i data-feather="archive"></i>
                                </a>
                                <a href="javascript:void(0)" data-text="Deletar" data-href="{{ route('obras.destroy', $obra->id) }}" rel="tooltip" title="Excluir Obra" class="nav-link d-none d-sm-block js-btn-delete"
                                    data-original-title="Archive">
                                    <i data-feather="trash"></i>
                                </a>
                                <a href="" rel="tooltip" title="Concluir Obra" class="nav-link d-sm-none" data-original-title="Options"><i class="ri-delete-bin-line"></i></a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="obr-etapa">
                    <div class="box box-default box-solid">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title text-center my-2">Etapas</h3>
                                <button type="button" data-type="active" class="btn btn-box-tool mode-edition"><i class="fa fa-plus-circle"></i> Modo Edição</button>
                                <button type="button" data-type="exit" class="btn btn-box-tool mode-edition d-none"><i class="fa fa-plus-circle"></i> Sair modo Edição</button>
                                <button type="button" id="deleteSelectionEtapa" data-type="deleteall" class="btn btn-box-tool mode d-none"><i class="fa fa-trash"></i> Deletar Selecionados</button>
                                <button type="button" id="updateSelectionEtapa" data-type="updateall" class="btn btn-box-tool mode d-none"><i class="fa fa-edit"></i> Atualizar Selecionados</button>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <select name="type" id="select--type" class="form-control select2 search-input">
                                            <option value="" selected>Todos</option>
                                            @foreach ($tipos as $tipo)
                                                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
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
        @include('pages.painel.obras._partials.modals.modal-update-obra')
        @include('pages.painel.obras._partials.modals.modal-update-etapa-all')
    </div>
@stop
@section('scripts')
    <script src="{{ asset('panel/js/pages/obras.js') }}"></script>
@endsection
