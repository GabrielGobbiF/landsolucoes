@extends('pages.painel.rh.app')

@section('title', 'Empresa')

@section('content')

    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Documentos da Empresa</h1>
            <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right"></div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documentos = [] as $documento)

                @endforeach
            </tbody>
        </table>
    </div>

@endsection
