@if (count($documentos) > 0)
    <div class="row row-xs">
        @foreach ($documentos as $documento)
            <div class="col-6 col-sm-3 col-md-3">
                <div class="card card-file" id="card-file-{{ $documento->id }}">
                    <div class="dropdown-file">
                        <a class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#modalViewDetails" data-toggle="modal" class="dropdown-item details d-none"><i data-feather="info"></i>View Details</a>
                            @if ($documento->favorited())
                                <a href="javascript:void(0)" data-url="{{ route('arquivos.unfavorite') }}" data-id="{{ $documento->id }}" class="dropdown-item fav">
                                    <i data-feather="star"></i>
                                    <span>Desmarcar Favorito</span>
                                </a>
                            @else
                                <a href="javascript:void(0)" data-url="{{ route('arquivos.favorite') }}" data-id="{{ $documento->id }}" class="dropdown-item fav">
                                    <i data-feather="star"></i>
                                    <span>Marcar Favorito</span>
                                </a>
                            @endif
                            <a href="#modalShare" data-toggle="modal" class="dropdown-item share d-none"><i data-feather="share"></i>Share</a>
                            <a href="javascript:void(0)" data-id="{{ $documento->id }}" data-name="{{ $documento->name }}" class="dropdown-item download"><i data-feather="download"></i>Selecionar
                                Download</a>
                            <a href="{{ $documento->url }}" class="dropdown-item" download="{{ $documento->name . '.' . $documento->ext }}"><i data-feather="download"></i>Download</a>
                            <a href="#modalCopy" data-toggle="modal" class="dropdown-item copy d-none"><i data-feather="copy"></i>Copy to</a>
                            <a href="#modalMove" data-toggle="modal" class="dropdown-item move  d-none"><i data-feather="folder"></i>Move to</a>
                            <a href="#" class="dropdown-item rename d-none"><i data-feather="edit"></i>Rename</a>
                            <form id="form-delete-{{ $documento->uuid }}" role="form" class="needs-validation" onSubmit="if(!confirm('Tem certeza que deseja excluir?')){return false;}"
                                action="{{ route('arquivos.destroy', $documento->uuid) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-btn-text="Deletando" class="dropdown-item delete"><i data-feather="trash"></i>Deletar</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-file-thumb">
                        <i class="far {{ $documento->desc['icon'] }}" style="color:{{ $documento->desc['color'] }}"></i>
                    </div>
                    <div class="card-body">
                        <h6><a target="_blank" href="{{ asset($documento->url) }}" class="link-02"> {{ $documento->name }}</a></h6>
                    </div>
                    @if ($documento->favorited())
                        <div class="marker-icon marker-warning pos-absolute t--1 l--1">
                            <i class="fas fa-star"></i>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

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
@endif
