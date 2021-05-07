@extends('pages.painel.obras.app')

@section('title', 'Obras')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Documentos</h1>
            <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right">
                <div class="btn-group mr-2">
                    <a href="{{ route('employees.create') }}" data-toggle="tooltip" data-placement="top" title="Novo" class="btn btn-dark"><i class="fas fa-folder-open"></i>
                        Nova Pasta</a>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($directorys as $directory)
                <div class="col-md-3">
                    <div class="card">
                        <a href="#">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body overflow-hidden">
                                        <p class="text-truncate font-size-14 mb-2">{{ str_replace('00tR9vps6D/', '', $directory) }}</p>
                                        <h4 class="mb-0">5 Documentos</h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
