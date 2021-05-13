@extends('app')

@section('title', 'Arquivos')

@section('content')
    <div class="arquivos">

        @include('pages.painel.obras._partials.file-sidebar')

        <div class="filemgr-content">
            <div class="filemgr-content-body ps ps--active-y">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mg-b-0">
                        <li class="breadcrumb-item"><a href="{{ route('arquivos.index') }}">Arquivos</a></li>
                        @if ($pastaPai && $pastaPai->name != '')
                            <li class="breadcrumb-item"><a href="{{ route('folder.show', $pastaPai->uuid) }}">{{ $pastaPai->name }}</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ $pasta->name }}</li>
                    </ol>
                </nav>
                <div class="pd-20 pd-lg-25 pd-xl-30">
                    @if (count($pastasFilhas) > 0)
                        <label class="d-block tx-medium tx-10 tx-uppercase tx-sans tx-spacing-1 tx-color-03 mg-b-15">Pastas</label>
                        <div class="row row-xs">
                            @foreach ($pastasFilhas as $directory)
                                <div class="col-sm-6 col-lg-4 col-xl-3 mg-t-5">
                                    <div class="media media-folder">
                                        <i data-feather="folder"></i>
                                        <div class="media-body">
                                            <h6><a href="{{ route('folder.show', $directory->uuid) }}" class="link-02">{{ $directory->name }}</a></h6>
                                            <span>{{ $directory->documentos_count }} files</span>
                                        </div>
                                        <div class="dropdown-file">
                                            <a href="{{ route('folder.show', $directory->uuid) }}" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <form id="form-delete" role="form" class="needs-validation" onSubmit="if(!confirm('Tem certeza que deseja excluir?')){return false;}" action="{{ route('pastas.destroy', $directory->id) }}" method="POST">
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
                        <hr class="mg-y-40 bd-0">
                    @endif
                    <div class="row row-xs">
                        @if (count($documentos) > 0)
                            @foreach ($documentos as $documento)
                                @php
                                    /* todoFazer colocar o documento em um resource   */
                                    $getColorAndIcon = getIconByExtDoc($documento->ext);
                                    $color = $getColorAndIcon['color'];
                                    $icon = $getColorAndIcon['icon'];
                                @endphp
                                <div class="col-6 col-sm-4 col-md-3">
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
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('pages.painel.obras._partials.modals.modal-add-pasta')
    @include('pages.painel.obras._partials.modals.modal-add-document')

@endsection
