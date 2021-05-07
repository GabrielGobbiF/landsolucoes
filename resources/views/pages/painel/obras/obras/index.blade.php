@extends('pages.painel.obras.app')

@section('title', 'Obras')

@section('sidebar')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <div>
            <h1 class="h2">Obras</h1>
            <ol class="breadcrumb">
                <a href="{{ route('obras.index') }}" class="breadcrumb-item">
                    <li class="tx-15">Home</li>
                </a>
            </ol>
        </div>
        <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right">
            <div class="btn-group mr-2">
                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-add-pasta"><i class="fas fa-folder-open"></i> Adicionar Pasta</button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">

    </div>
@endsection
