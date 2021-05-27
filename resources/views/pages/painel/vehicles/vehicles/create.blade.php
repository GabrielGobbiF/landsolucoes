@extends('app')

@section('title', 'Cadastrar Veiculo')

@section('content')
    <div class="container">
        <div class="card mt-3">
            <form role="form" class="needs-validation" novalidate id="form" autocomplete="off" novalidate="novalidate" action="{{ route('vehicles.store') }}" method="POST">
                @include('pages.painel.vehicles._partials.form_vehicle')
            </form>
        </div>
    </div>
@stop
