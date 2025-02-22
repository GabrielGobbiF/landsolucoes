@extends("pages.clients.app")

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
                                <textarea type="text" name="description" class="form-control">{{ $obra->description ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label style="width:100%" for="input--description">Informações Importantes <span class="obr_informacoes-span-save float-right"><span></label>
                                <textarea type="text" name="obr_informacoes" class="form-control">{{ $obra->obr_informacoes ?? '' }}</textarea>
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

        <div class="main row">

            <div class="col-12 col-md-8">
                <div class="obr-etapa">
                    <div class="box box-default box-solid">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title text-center my-2">Etapas</h3>
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

            <div class="col-md-4">
                <div class="card" style="height:100%;max-height: 400px; ">
                    <div class="card-body" style="overflow: auto;height: auto;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Documentos</h4>
                            <div class="btn-group dropleft">
                                <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#add__folder" class="dropdown-item"><i class="fas fa-folder"></i> Nova Pasta</a>
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#modal-add-documento" class="dropdown-item"><i class="fas fa-file-download"></i> Novo Documento</a>
                                </div>
                            </div>
                        </div>
                        <div id="accordion" class="mt-3">
                            <div id="documents__list"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="modal-add-documento" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Adicionar Documento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Selecione a Pasta</label>
                                        <select class="form-control select2" id="select__pasta">
                                            @foreach ($pastas as $pasta)
                                                <option value="{{ $pasta->uuid }}"> {{ mb_strtolower($pasta->name) == mb_strtolower($obra->razao_social) ? 'Na Raiz da obra' : $pasta->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <form id="form-add-documento" role="form" class="needs-validation custom-validation dropzone" enctype="multipart/form-data" action="{{ route('arquivos.store') }}"
                                        method="POST">
                                        <input type="hidden" name="folder_childer" id="folder_childer" value="">
                                        @csrf
                                        <div id="docs"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="add__folder" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="form-add-folder" role="form" class="needs-validation" action="{{ route('pastas.store') }}" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title">Adicionar Pasta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Adicionar Pasta em</label>
                                            <select name="folder_childer" class="form-control select2">
                                                @foreach ($pastas as $pasta)
                                                    <option value="{{ $pasta->uuid }}"> {{ mb_strtolower($pasta->name) == mb_strtolower($obra->razao_social) ? 'Na Raiz da obra' : $pasta->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nome da pasta</label>
                                            <input type="text" class="form-control" name="name" id="input--name">
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center my-3">ou selecione pastas já cadastrada</div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Pasta Padrão Cadastradas</label>
                                            <select name="name_padrao[]" class="form-control select2" multiple>
                                                @foreach ($pastaPadrao as $pastP)
                                                    <option value="{{ $pastP['nome_pasta'] }}">{{ $pastP['nome_pasta'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-submit">Adicionar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal" id="modal-file" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="form-update-file" role="form" class="needs-validation" action="" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title">Alterar Nome</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                @method("put")
                                <input type="hidden" name="fileId" id="input__fileId">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nome do Arquivo</label>
                                            <input type="text" class="form-control" name="name" id="input--doc_name" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-submit">Alterar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal" id="modal-file-move" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="form-move-file" role="form" class="needs-validation" action="" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Selecione a Pasta para onde deseja mover</label>
                                            <select name="folder_move" class="form-control select2">
                                                @foreach ($pastas as $pasta)
                                                    <option value="{{ $pasta->uuid }}"> {{ mb_strtolower($pasta->name) == mb_strtolower($obra->razao_social) ? 'Na Raiz da obra' : $pasta->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-submit">Mover</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @include('pages.painel.obras.obras.etapas.show_right')
            @include('pages.painel.obras._partials.modals.modal-update-obra')
            @include('pages.painel.obras._partials.modals.modal-update-etapa-all')
        </div>
    </div>
@stop
@section('scripts')
    <script src="{{ asset('panel/js/pages/obras.js') }}"></script>
    <script src="{{ asset('panel/js/pages/obras/document.js') }}"></script>

    @if ($input = Request::input('etp'))
        <script>
            showEtapa(`{{ $input }}`)
        </script>
    @endif
@endsection
