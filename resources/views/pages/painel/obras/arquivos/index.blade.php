@extends('app')

@section('title', 'Arquivos')


@section('content')

    <div class="arquivos">

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

                    @if (count($documentos) > 0)
                        <div class="row row-xs">
                            @foreach ($documentos as $documento)
                                @php
                                    /* todoFazer colocar o documento em um resource   */
                                    $getColorAndIcon = getIconByExtDoc($documento->ext);
                                    $color = $getColorAndIcon['color'];
                                    $icon = $getColorAndIcon['icon'];
                                @endphp
                                <div class="col-6 col-sm-3 col-md-3">
                                    <div class="card card-file">
                                        <div class="dropdown-file">
                                            <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#modalViewDetails" data-toggle="modal" class="dropdown-item details d-none"><i data-feather="info"></i>View Details</a>
                                                <a href="" class="dropdown-item important  d-none"><i data-feather="star"></i>Mark as Important</a>
                                                <a href="#modalShare" data-toggle="modal" class="dropdown-item share d-none"><i data-feather="share"></i>Share</a>
                                                <a href="{{ asset($documento->url) }}" class="dropdown-item download" download="{{ $documento->slug }}"><i data-feather="download"></i>Download</a>
                                                <a href="#modalCopy" data-toggle="modal" class="dropdown-item copy d-none"><i data-feather="copy"></i>Copy to</a>
                                                <a href="#modalMove" data-toggle="modal" class="dropdown-item move  d-none"><i data-feather="folder"></i>Move to</a>
                                                <a href="#" class="dropdown-item rename d-none"><i data-feather="edit"></i>Rename</a>
                                                <form id="form-delete" role="form" class="needs-validation" onSubmit="if(!confirm('Tem certeza que deseja excluir?')){return false;}" action="{{ route('arquivos.destroy', $documento->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" id="modal-confirm" data-btn-text="Deletando" class="dropdown-item delete"><i data-feather="trash"></i>Deletar</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-file-thumb tx-danger">
                                            <i class="far {{ $icon }}"></i>
                                        </div>
                                        <div class="card-body">
                                            <h6><a href="" class="link-02"> {{ $documento->name }}</a></h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if (count($directorys) > 0)
                        <hr class="mg-y-40 bd-0">
                        <label class="d-block tx-medium tx-10 tx-uppercase tx-sans tx-spacing-1 tx-color-03 mg-b-15">Pastas</label>
                        <div class="row row-xs">
                            @foreach ($directorys as $directory)
                                <div class="col-3 mg-t-5">
                                    <div class="media media-folder">
                                        <i data-feather="folder"></i>
                                        <div class="media-body">
                                            <h6><a href="{{ route('folder.show', $directory->uuid) }}" class="link-02">{{ $directory->name }}</a></h6>
                                            <span>{{$directory->documentos_count}} files</span>
                                        </div>
                                        <div class="dropdown-file">
                                            <a href="{{ route('folder.show', $directory->uuid) }}" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <form id="form-delete" role="form" class="needs-validation" action="{{ route('pastas.destroy', $directory->id) }}" method="POST">
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
                    @endif
                </div>
            </div>
        </div>

        @include('pages.painel.obras._partials.modals.modal-add-pasta')
        @include('pages.painel.obras._partials.modals.modal-add-document')
    @endsection
