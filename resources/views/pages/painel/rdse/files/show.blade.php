@extends('app')

@section('title', 'ETDS Arquivos')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="filemgr-content-body ps ps--active-y arquivos">
                <a href="{{ route('etd.files.index') }}" class="">
                    <i class="fas fa-long-arrow-alt-left"></i>
                    Voltar
                </a>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <div>
                        <h4 class="mg-b-15 mg-lg-b-25">Arquivos: {{ $etd->name }}</h4>
                    </div>
                    <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right">
                        <form id="form-search-doc" role="form" class="needs-validation" action="" method="GET">
                            <div class="form-inline">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search" placeholder="" value="">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-light">Buscar por Data</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr class="mg-y-40 bd-0">
                <label class="d-block tx-medium tx-10 tx-uppercase tx-sans tx-spacing-1 tx-color-03 mg-b-15">Pastas</label>
                <div class="row">
                    @foreach ($pastasPorData as $pasta)
                        <div class="col-3 mg-t-5">
                            <a href="{{ route('etd.folder.files.show', [$etd->id, $pasta->FolderPastName]) }}"
                                class="link-02">
                                <div class="media media-folder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder">
                                        <path
                                            d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z">
                                        </path>
                                    </svg>

                                    <div class="media-body">
                                        <h6>
                                            {{ $pasta->FolderPastName }}
                                        </h6>
                                    </div>
                                    <div class="dropdown-file">
                                        {{--
                                            <a href=""
                                                class="dropdown-link" data-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-more-vertical">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="12" cy="5" r="1"></circle>
                                                    <circle cx="12" cy="19" r="1"></circle>
                                                </svg>
                                            </a>
                                        --}}

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <form id="form-delete-1" role="form" class="needs-validation"
                                                action="http://www2.landsolucoes.com.br/l/pastas/1" method="POST">
                                                <input type="hidden" name="_token"
                                                    value="sGpIOuyX6zRYiDDm4YSeTpfMnOiTUiqDuQNPnw6r"> <input type="hidden"
                                                    name="_method" value="DELETE">

                                                <button type="submit" id="modal-confirm" data-btn-text="Deletando"
                                                    class="dropdown-item delete"><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" class="feather feather-trash">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                    </svg>Deletar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

@stop
