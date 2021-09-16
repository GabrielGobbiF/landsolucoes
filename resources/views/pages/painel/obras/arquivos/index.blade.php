@extends('app')

@section('title', 'Arquivos')


@section('content')
    <div class="arquivos filemgr-wrapper">
        @include('pages.painel.obras._partials.file-sidebar')
        <div class="filemgr-content">
            <div class="filemgr-content-body ps ps--active-y">
                <div class="pd-20 pd-lg-25 pd-xl-30">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                        @if (Request::input('search'))
                            <div>
                                <h4 class="mg-b-15 mg-lg-b-25">Filtro "{{ Request::input('search') }}"</h4>
                            </div>
                        @else
                            <div>
                                <h4 class="mg-b-15 mg-lg-b-25">Todos os arquivos</h4>
                                <label class="d-block tx-medium tx-10 tx-uppercase tx-sans tx-spacing-1 tx-color-03 mg-b-15">Recentes Adicionados</label>
                            </div>
                        @endif
                        <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right">
                            <form id='form-search-doc' role='form' class='needs-validation' action='{{ route('arquivos.index') }}' method='GET'>
                                <div class="form-inline">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="search" placeholder="" value="{{ Request::input('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-light" type="button">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @include('pages.painel.obras.arquivos.all')

                    @if (count($directorys) > 0)
                        <hr class="mg-y-40 bd-0">
                        <label class="d-block tx-medium tx-10 tx-uppercase tx-sans tx-spacing-1 tx-color-03 mg-b-15">Pastas</label>
                        <div class="row">
                            @foreach ($directorys as $directory)
                                <div class="col-3 mg-t-5">
                                    <div class="media media-folder">
                                        <i data-feather="folder"></i>
                                        <div class="media-body">
                                            <h6><a href="{{ route('folder.show', $directory->uuid) }}"
                                                    class="link-02">{{ ucfirst(mb_strtolower(mb_strimwidth($directory->name, 0, 35, '...'), 'utf-8')) }}</a></h6>
                                            <span>{{ $directory->documentos_count }} files</span>
                                        </div>
                                        <div class="dropdown-file">
                                            <a href="{{ route('folder.show', $directory->uuid) }}" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <form id="form-delete-{{ $directory->id }}" role="form" class="needs-validation" action="{{ route('pastas.destroy', $directory->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" id="modal-confirm" data-btn-text="Deletando" class="dropdown-item delete"><i data-feather="trash"></i>Deletar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row d-flex justify-content-center">
                            <ul class="pagination pagination-rounded mb-sm-0">
                                {!! $directorys->appends(Request::input('pastas'))->links() !!}
                            </ul>
                        </div>
                    @endif
                    <hr class="my-5">
                    @if (count($obrasPastas) > 0)
                        <hr class="mg-y-40 bd-0">
                        <label class="d-block tx-medium tx-10 tx-uppercase tx-sans tx-spacing-1 tx-color-03 mg-b-15">Obras</label>
                        <div class="row">
                            @foreach ($obrasPastas as $obrasPasta)
                                <div class="col-3 mg-t-5">
                                    <div class="media media-folder">
                                        <i data-feather="folder"></i>
                                        <div class="media-body">
                                            <h6><a href="{{ route('folder.show', $obrasPasta->uuid) }}"
                                                    class="link-02">{{ ucfirst(mb_strtolower(mb_strimwidth($obrasPasta->name, 0, 35, '...'), 'utf-8')) }}</a></h6>
                                            <span>{{ $obrasPasta->documentos_count }} files</span>
                                        </div>
                                        <div class="dropdown-file">
                                            <a href="{{ route('folder.show', $obrasPasta->uuid) }}" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <form id="form-delete-{{ $obrasPasta->id }}" role="form" class="needs-validation" action="{{ route('pastas.destroy', $obrasPasta->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" id="modal-confirm" data-btn-text="Deletando" class="dropdown-item delete"><i data-feather="trash"></i>Deletar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row d-flex justify-content-center">
                            <ul class="pagination pagination-rounded mb-sm-0">
                                {!! $obrasPastas->appends(Request::input('obras'))->links() !!}
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('pages.painel.obras._partials.modals.modal-add-pasta')
    @include('pages.painel.obras._partials.modals.modal-add-document')

@section('scripts')
    <script src="{{ asset('panel/js/pages/arquivos.js') }}"></script>
@endsection
@endsection
