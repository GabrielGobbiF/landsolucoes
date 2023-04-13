@extends('app')

@section('title', 'ETDS Arquivos')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="filemgr-content-body ps ps--active-y arquivos">

                <a href="{{ route('etd.files.show', $etd->id) }}" class="">
                    <i class="fas fa-long-arrow-alt-left"></i>
                    Voltar
                </a>

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <div>
                        <h4 class="mg-b-15 mg-lg-b-25">Arquivos: {{ $etd->name }}</h4>
                        <h4 class="mg-b-15 mg-lg-b-25">Data: {{ formatDateAndTime($date) }}</h4>
                    </div>
                </div>
                <hr class="mg-y-40 bd-0">
                <label
                    class="d-block tx-medium tx-10 tx-uppercase tx-sans tx-spacing-1 tx-color-03 mg-b-15">Arquivos</label>
                <div class="row">
                    @foreach ($files as $file)
                        <div class="col-6 col-sm-6 col-md-6">
                            <div class="card card-file" id="card-file-1">
                                <div class="card-file-thumb"
                                    style="background-image: url('{{ $file->path }}');
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    background-size: contain;
                                    height: 300px;
                                    ">
                                </div>

                                <div class="card-body">
                                    <h6>
                                        <a target="_blank" href="{{ $file->path }}" class="link-02">
                                            {{ limit($file->name, 20) }}
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

@stop

{{--
    <div class="dropdown-file">
                                <a class="dropdown-link" data-toggle="dropdown" aria-expanded="false"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-more-vertical">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="12" cy="5" r="1"></circle>
                                        <circle cx="12" cy="19" r="1"></circle>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" style="">
                                    <a href="#modalViewDetails" data-toggle="modal"
                                        class="dropdown-item details d-none"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-info">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="16" x2="12" y2="12"></line>
                                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                        </svg>View Details</a>
                                    <a href="javascript:void(0)"
                                        data-url="http://www2.landsolucoes.com.br/l/arquivos/favorite" data-id="1"
                                        class="dropdown-item fav">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                            <polygon
                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                            </polygon>
                                        </svg>
                                        <span>Marcar Favorito</span>
                                    </a>
                                    <a href="#modalShare" data-toggle="modal" class="dropdown-item share d-none"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-share">
                                            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                            <polyline points="16 6 12 2 8 6"></polyline>
                                            <line x1="12" y1="2" x2="12" y2="15">
                                            </line>
                                        </svg>Share</a>
                                    <a href="javascript:void(0)" data-id="1"
                                        data-name="whatsapp image 2023-04-13 at 11.26.07"
                                        class="dropdown-item download"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-download">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" y1="15" x2="12" y2="3">
                                            </line>
                                        </svg>Selecionar
                                        Download</a>
                                    <a href="storage/00tR9vps6D/1154643803c08c498/7478643818ab74086.jpeg"
                                        class="dropdown-item" download="whatsapp image 2023-04-13 at 11.26.07.jpeg"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-download">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" y1="15" x2="12" y2="3">
                                            </line>
                                        </svg>Download</a>
                                    <a href="#modalCopy" data-toggle="modal" class="dropdown-item copy d-none"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy">
                                            <rect x="9" y="9" width="13" height="13"
                                                rx="2" ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>Copy to</a>
                                    <a href="#modalMove" data-toggle="modal" class="dropdown-item move  d-none"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-folder">
                                            <path
                                                d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z">
                                            </path>
                                        </svg>Move to</a>
                                    <a href="#" class="dropdown-item rename d-none"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                            </path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>Rename</a>
                                    <form id="form-delete-3922643818ab76a6d" role="form" class="needs-validation"
                                        onsubmit="if(!confirm('Tem certeza que deseja excluir?')){return false;}"
                                        action="http://www2.landsolucoes.com.br/l/arquivos/3922643818ab76a6d"
                                        method="POST">
                                        <input type="hidden" name="_token"
                                            value="sGpIOuyX6zRYiDDm4YSeTpfMnOiTUiqDuQNPnw6r"> <input type="hidden"
                                            name="_method" value="DELETE"> <button type="submit"
                                            data-btn-text="Deletando" class="dropdown-item delete"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-trash">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                </path>
                                            </svg>Deletar</button>
                                    </form>
                                </div>
                            </div>
    --}}
