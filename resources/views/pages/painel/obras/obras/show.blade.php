@extends('app')

@section('title', ucfirst($obra->razao_social) . ' - ' . $obra->last_note)

@section('content-max-fluid')

    <style class="">
        .icon-pulse {
            color: #e74c3c;
            animation: pulse 1s infinite;
        }

        /* Animação de pulsar */
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
    <div class="page--obra">

        <div class="sidenav">
            <div class="col-12">
                <div class="box-body">

                    <input id="input--obra_id" type="hidden" value="{{ $obra->id }}">

                    <div class="row mt-4">
                        <h4 class="col-12 mb-3">Obra <small class="text-muted js-input-obra-name editable">{{ $obra->razao_social ?? '' }}</small></h4>
                        <h4 class="col-12 mb-3">Cliente <small class="text-muted js-input-obra-name editable">{{ $obra->client->username ?? '' }}</small></h4>
                        <h6 class="col-12 mb-3 d-flex tx-18"> <i class="ri-community-line mr-2"></i> {{ $obra->concessionaria->name ?? '' }}</h6>
                        <h6 class="col-12 mb-3 d-flex tx-18"> <i class="ri-git-repository-private-fill mr-2"></i> {{ $obra->service->name ?? '' }}</h6>
                        <h6 class="col-12 mb-3 d-flex tx-18"> <i class="ri-calendar-event-line mr-2"></i> {{ return_format_date($obra->build_at, 'pt', '/') ?? '' }}
                        </h6>
                        <h6 class="col-12 mb-3 d-flex tx-18"> <i class="fas fa-map-marked mr-2"></i> {{ $obra->AddressComplete }}</h6>

                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label style="width:100%" for="input--description">Descrição da Obra <span class="description-span-save float-right"><span> </label>
                                <textarea type="text" name="description" class="form-control input-update-obra">{{ $obra->description ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label style="width:100%" for="input--description">Informações Importantes <span
                                          class="obr_informacoes-span-save float-right"><span></label>
                                <textarea type="text" name="obr_informacoes" class="form-control input-update-obra">{{ $obra->obr_informacoes ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-none">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="input--razao_social">Obra</label>
                                <input id="input--razao_social" type="text" name="razao_social" class="form-control @error('razao_social') is-invalid @enderror"
                                       value="{{ $obra->razao_social ?? old('razao_social') }}" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="input--concessionaria">Concessionaria</label>
                                <input id="input--concessionaria" type="text" name="concessionaria" class="form-control" readonly disabled
                                       value="{{ $obra->concessionaria->name }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="input--service">Tipo de Obra / Serviço</label>
                                <input id="input--service" type="text" name="service" class="form-control" readonly disabled value="{{ $obra->service->name }}">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="input--build_at">Data</label>
                                <input id="input--build_at" type="text" name="build_at" class="form-control" value="{{ old('build_at') ?? $obra->build_at }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="input--description">Descrição</label>
                                <input id="input--description" type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                                       value="{{ $obra->description ?? old('description') }}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main row">
            <div class="col-12 col-md-8">
                <div class="box box-default box-solid">
                    <div class="box-body mg-0 pd-0">
                        <div class="mail-content-header d-flex">
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-update-obra">Editar Obra</button>
                            <a href="{{ route('obras.finance', $obra->id) }}" class="btn btn-outline-primary ml-2">Financeiro <i
                                   class="fas fa-long-arrow-alt-right"></i></a>
                            <a href="{{ route('comercial.show', $obra->id) }}" class="btn btn-outline-primary ml-2">Comercial <i
                                   class="fas fa-long-arrow-alt-right"></i></a>

                            @if ($obra->concessionaria->name == 'RDSE')
                                @if ($obra->medicao)
                                    <a href="{{ route('rdse.show', $obra->medicao->id) }}" target="_blank" class="btn btn-outline-primary ml-2">Medição <i
                                           class="fas fa-long-arrow-alt-right"></i></a>
                                @else
                                    <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#store-rdse_obra">Criar Medição</button>
                                    <div id="store-rdse_obra" class="modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form id='form-add-rdse_obra' role='form' class='needs-validation'
                                                      action='{{ route('rdse.obra.create', $obra->id) }}' method='POST'>
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Criar Medição na obra {{ $obra->razao_social }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <select required name='modelo' parent="#store-rdse_obra .modal-content" class='form-control select2'
                                                                request="{{ route('modelos.rdses.all') }}" placeholder="Selecione o Modelo">
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary btn-submit">Criar</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <nav class="nav nav-icon-only mg-l-auto">

                                @if (empty($obra->remove_finance))
                                    <a href="javascript:void(0)" data-text="Remover do Financeiro" data-href="{{ route('obras.remove.finance', $obra->id) }}"
                                       rel="tooltip" title="Remover do Financeiro" class="nav-link d-none d-sm-block js-btn-delete">
                                        <i data-feather="dollar-sign"></i>
                                    </a>
                                @else
                                    <a href="javascript:void(0)" data-text="Voltar para o Financeiro" data-href="{{ route('obras.remove.finance', $obra->id) }}"
                                       rel="tooltip" title="Voltar para o Financeiro" class="nav-link d-none d-sm-block js-btn-delete">
                                        <i data-feather="dollar-sign"></i>
                                    </a>
                                @endif

                                <a href="javascript:void(0)" data-text="{{ $obra->obr_urgence == 'Y' ? 'Desmarcar Urgencia' : 'Marcar Urgencia' }}"
                                   data-href="{{ route('obras.urgence', $obra->id) }}" rel="tooltip"
                                   title="{{ $obra->obr_urgence == 'Y' ? 'Desmarcar Urgencia' : 'Marcar Urgencia' }}"
                                   class="nav-link d-none d-sm-block js-btn-delete {{ $obra->obr_urgence == 'Y' ? 'icon-pulse' : '' }}"
                                   style="{{ $obra->obr_urgence == 'Y' ? '' : 'color: #71e61b !important;' }}" data-action="PUT">
                                    @if ($obra->obr_urgence == 'Y')
                                        <i data-feather="alert-triangle"></i>
                                    @else
                                        <i data-feather="alert-triangle"></i>
                                    @endif
                                </a>

                                <a href="javascript:void(0)" data-text="Arquivar" data-href="{{ route('obras.concluir', $obra->id) }}" rel="tooltip"
                                   title="Concluir Obra" class="nav-link d-none d-sm-block js-btn-delete">
                                    <i data-feather="archive"></i>
                                </a>
                                <a href="javascript:void(0)" data-text="Deletar" data-href="{{ route('obras.destroy', $obra->id) }}" rel="tooltip"
                                   title="Excluir Obra" class="nav-link d-none d-sm-block js-btn-delete" data-original-title="Archive">
                                    <i data-feather="trash"></i>
                                </a>

                                @if ($obra->favorited())
                                    <form id="form-unfavorite" role="form" class="needs-validation" action="{{ route('obras.unfavorite', $obra->id) }}"
                                          method="POST">
                                        @csrf
                                        <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('form-unfavorite').submit();"
                                           class="nav-link d-none d-sm-block" rel="tooltip" title="Des Favoritar" data-original-title="Des Favoritar"> <i
                                               data-feather="x"></i></a>
                                    </form>
                                @else
                                    <form id="form-favorite" role="form" class="needs-validation" action="{{ route('obras.favorite', $obra->id) }}"
                                          method="POST">
                                        @csrf
                                        <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('form-favorite').submit();"
                                           class="nav-link d-none d-sm-block" rel="tooltip" title="Favoritar" data-original-title="Favoritar"> <i
                                               data-feather="heart"></i></a>
                                    </form>
                                @endif
                                <a href="" rel="tooltip" title="Concluir Obra" class="nav-link d-sm-none" data-original-title="Options"><i
                                       class="ri-delete-bin-line"></i></a>
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

                                <div id="editModeButtons" class="d-none">

                                    <button id="sairModoEdicaoBtn" type="button" data-type="exit" class="btn btn-box-tool">
                                        Sair modo Edição
                                    </button>

                                    <button id="addEtapa" data-toggle="modal" data-target="#addEtapaModal" type="button" data-type="addall"
                                            class="btn btn-box-tool mode">
                                        <i class="fa fa-plus-circle"></i>
                                        Adicionar Etapa
                                    </button>

                                    <button id="deleteSelectionEtapa" type="button" data-type="deleteall" class="btn btn-box-tool mode "><i
                                           class="fa fa-trash"></i>
                                        Deletar Selecionados
                                    </button>
                                    <button id="updateSelectionEtapa" type="button" data-type="updateall" class="btn btn-box-tool mode "><i
                                           class="fa fa-edit"></i>
                                        Atualizar Selecionados
                                    </button>
                                </div>

                                <button id="modoEdicaoBtn" type="button" data-type="active" class="btn btn-box-tool  mode-edition">
                                    <i class="fa fa-plus-circle"></i>
                                    Modo Edição
                                </button>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <select id="select--type" name="type" class="form-control select2 search-input search-input__sales">
                                            <option value="" selected>Todos</option>
                                            @foreach ($tipos as $tipo)
                                                <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="input--term" type="text" class="form-control search-input" name="term" value=""
                                                   autocomplete="off" placeholder="Buscar...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body mg-0 pd-0">
                                <ul id="etapas-list" class="message-list" style="padding: 5px 0px 0px 1px;"></ul>
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
                                <a type="button" class="dropdown-toggle arrow-none card-drop dropleft" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#add__folder" class="dropdown-item"><i
                                           class="fas fa-folder"></i> Nova Pasta</a>
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#modal-add-documento" class="dropdown-item"><i
                                           class="fas fa-file-download"></i> Novo Documento</a>
                                </div>
                            </div>
                        </div>
                        <div id="accordion" class="mt-3">
                            <div id="documents__list"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal-add-documento" class="modal" tabindex="-1" role="dialog">
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
                                <div id="div_select-pasta" class="col-md-12 div_select-pasta">
                                    <div class="form-group">
                                        <label>Selecione a Pasta</label>
                                        <select id="select__pasta" class="form-control ">
                                            @foreach ($pastas as $pasta)
                                                <option value="{{ $pasta->uuid }}">
                                                    {{ mb_strtolower($pasta->name) == mb_strtolower($obra->razao_social) ? 'Na Raiz da obra' : $pasta->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <form id="form-add-documento" role="form" class="needs-validation custom-validation dropzone"
                                          enctype="multipart/form-data" action="{{ route('arquivos.store') }}" method="POST">
                                        <input id="folder_childer" type="hidden" name="folder_childer" value="">
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

            <div id="add__folder" class="modal" tabindex="-1" role="dialog">
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
                                                    <option value="{{ $pasta->uuid }}">
                                                        {{ mb_strtolower($pasta->name) == mb_strtolower($obra->razao_social) ? 'Na Raiz da obra' : $pasta->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nome da pasta</label>
                                            <input id="input--name" type="text" class="form-control" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center my-3">ou selecione pastas já cadastrada</div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Pasta Padrão Cadastradas</label>
                                            <select name="name_padrao[]" class="form-control select2" multiple parent="#add__folder .modal-content">
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

            <div id="modal-file" class="modal" tabindex="-1" role="dialog">
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
                                @method('put')
                                <input id="input__fileId" type="hidden" name="fileId">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nome do Arquivo</label>
                                            <input id="input--doc_name" type="text" class="form-control" name="name" required>
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

            <div id="modal-file-move" class="modal" tabindex="-1" role="dialog">
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
                                                    <option value="{{ $pasta->uuid }}">
                                                        {{ mb_strtolower($pasta->name) == mb_strtolower($obra->razao_social) ? 'Na Raiz da obra' : $pasta->name }}
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

    <div id="addEtapaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalTitleId" class="modal-title">
                        Adicionar Etapa na Modal
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="adicionarEtapaForm">
                        <div class="form-group">
                            <label for="etapaSelect">Selecione uma Etapa</label>
                            <select id="select--etapas_not_in_obra" name="etapas" class="form-control select-users_name t-select"
                                    data-request="{{ route('api.etapas.all', ['not_in_obra' => $obra->id]) }}" multiple required>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button id="salvarEtapaBtn" type="button" class="btn btn-primary">Salvar</button>
                </div>
            </div>
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


    <script>
        $(document).ready(function() {

            let isDragging = false;

            $('#modal-add-documento').on('dragenter dragover', function(e) {
                $('#select__pasta').select2('close');
            });

            $('#modal-add-documento').on('dragleave drop', function(e) {
                $('#select__pasta').select2('close');
                isDragging = true;
                e.stopPropagation();
                e.preventDefault();
            });

            $('#modal-add-documento').on('hidden.bs.modal', function(e) {
                $('#div_select-pasta').removeClass('d-none'); // Esconde o select

            });

            $('#select__pasta').select2({
                dropdownParent: $("#modal-add-documento"),
                allowClear: true,
            });

            $('.search-input__sales').each(function() {
                const id = $(this).attr('id');
                $(`#${id}`).val(JSON.parse(localStorage.getItem(id))).trigger('change');
            })

            $('.search-input__sales').on('change keyup', function() {
                const value = $(this).val();
                const id = $(this).attr('id');
                localStorage.setItem(id, JSON.stringify(value));
            });
        })
    </script>
@append
