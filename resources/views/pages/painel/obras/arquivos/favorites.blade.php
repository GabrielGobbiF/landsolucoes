@extends('app')

@section('title', 'Arquivos - Favoritos')

@section('content')

    <div class="arquivos filemgr-wrapper">
        @include('pages.painel.obras._partials.file-sidebar')
        <div class="filemgr-content">
            <div class="filemgr-content-body ps ps--active-y">
                <div class="pd-20 pd-lg-25 pd-xl-30">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                        @if (Request::input('search'))
                            <div>
                                <h4 class="mg-b-15 mg-lg-b-25">Favoritos</h4>
                                <label class="d-block tx-medium tx-10 tx-uppercase tx-sans tx-spacing-1 tx-color-03 mg-b-15">Filtro "{{ Request::input('search') }}"</label>

                            </div>
                        @else
                            <div>
                                <h4 class="mg-b-15 mg-lg-b-25">Favoritos</h4>
                            </div>
                        @endif
                        <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right">
                            <form id='form-search-doc' role='form' class='needs-validation' action='{{ route('arquivos.my.favorites') }}' method='GET'>
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
