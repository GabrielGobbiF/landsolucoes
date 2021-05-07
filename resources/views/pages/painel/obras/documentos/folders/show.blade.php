@extends('pages.painel.obras.app')

@section('title', 'Obras')

@section('sidebar')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <div>
            <h1 class="h2">Documentos</h1>
            <ol class="breadcrumb">
                <a href="{{ route('obras.index') }}" class="breadcrumb-item">
                    <li class="tx-15">Home</li>
                </a>
                <a href="{{ route('documentos.index') }}" class="breadcrumb-item">
                    <li class="tx-15">Documentos</li>
                </a>
                @if ($pastaPai && $pastaPai->name != '')
                    <a href="{{ route('folder.show', $pastaPai->uuid) }}" class="breadcrumb-item">
                        <li class="tx-15">{{ $pastaPai->name }}</li>
                    </a>
                @endif
                <li class="breadcrumb-item active tx-15">{{ $pasta->name }}</li>
            </ol>
        </div>
        <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right">
            <div class="btn-group mr-2">
                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-add-pasta"><i class="fas fa-folder-open"></i> Adicionar Pasta em {{ $pasta->name }}</button>
                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-add-documento"><i class="fas fa-file-import"></i> Adicionar Documento</button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        @foreach ($pastasFilhas as $directory)
            <div class="col-md-3 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body overflow-hidden">
                                <a href="{{ route('folder.show', $directory->uuid) }}">
                                    <p class="text-truncate font-size-14 mb-2">{{ $directory->name }}</p>
                                </a>
                            </div>
                            <div class="text-primary">
                                <a href="JavaScript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Excluir"
                                    data-href="{{ route('pastas.destroy', $directory->id) }}" class="btn-delete"
                                    data-original-title="Excluir Pasta">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @include('pages.painel.obras._partials.modals.modal-add-pasta')
    @include('pages.painel.obras._partials.modals.modal-add-document')
@endsection
