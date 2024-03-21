@extends('app')

@section('title', 'Motorista - ' . ucfirst($driver->name))

@section('content')
    <div class="card">
        <div class="card-body">

            <form id="form-drivers" role="form" class="needs-validation" novalidate autocomplete="off" action="{{ route('drivers.update', $driver->id) }}"
                  method="POST">
                @csrf
                @method('put')
                @include('pages.painel._partials.forms.form-drivers')
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <button type="button" class="btn btn-primary btn-submit">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- <x-cards.card-history-log :logs="$driver->logs()" :user="true" /> --}}

@endsection
