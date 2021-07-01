@extends('app')

@section('title', 'Arquivos')

@section('content')
    <div class="arquivos filemgr-wrapper">
        @include('pages.painel.obras._partials.file-sidebar')

        <div class="filemgr-content">
            <div class="filemgr-content-body ps ps--active-y">
                <nav aria-label="breadcrumb" class="mg-t-15">
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
                                                <form id="form-delete-{{ $directory->id }}" role="form" class="needs-validation" onSubmit="if(!confirm('Tem certeza que deseja excluir?')){return false;}"
                                                    action="{{ route('pastas.destroy', $directory->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" data-btn-text="Deletando" class="dropdown-item delete"><i data-feather="trash"></i>Deletar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <hr class="mg-y-40 bd-0">
                    @endif

                    @include('pages.painel.obras.arquivos.all')

                </div>
            </div>
        </div>
    </div>

    @include('pages.painel.obras._partials.modals.modal-add-pasta')
    @include('pages.painel.obras._partials.modals.modal-add-document')

    <div class="pos-fixed b-10 r-10 z-index-200 d-none" id="files-downloading">
        <div class='card'>
            <form id='form-download-files' role='form' class='needs-validation' action='{{ route('arquivos.download') }}' method='POST'>
                <input type="hidden" id="files--input" name="files">
                @csrf
                <div class='card-header bg-primary'>
                    <h6 class="tx-white mg-b-0 mg-r-auto">Preparado para download</h6>
                </div>
                <div class='card-body pd-15' id="files-row">
                </div>
                <div class="card-footer">
                    <button type='submit' class='btn btn-sm btn-primary btn-download'>Baixar</button>
                    <button type='button' class='btn btn-sm btn-outline-info btn-submit'>Enviar</button>
                </div>
            </form>
        </div>
    </div>

@section('scripts')
    <script src="{{ asset('panel/js/pages/arquivos.js') }}"></script>
@endsection

@endsection
