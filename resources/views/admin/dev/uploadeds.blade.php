@extends('app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Arquivos</div>
                    <div class="card-body">
                        <button class="btn btn-primary" onclick="openFileUploadModal('App\\Models\\ObraEtapa', '27822')"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
