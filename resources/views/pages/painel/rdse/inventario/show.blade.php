@extends('app')

@section('title', 'Inventario - ' . ucfirst($inventory->description))

@section('content')

    <div class='card'>
        <div class='card-body'>
            <form id="form-inventories" role="form" class="needs-validation" novalidate autocomplete="off" action="{{ route('inventories.update', $inventory->id) }}"
                  method="POST">
                <div class="box-body">
                    @csrf
                    @method('put')
                    @include('pages.painel._partials.forms.form-inventories')
                    <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@stop
