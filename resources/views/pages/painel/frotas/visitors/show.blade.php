@extends('app')

@section('title', 'Visitante - ' . ucfirst($visitor->linha))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-3">
                    {!! $visitor->status->getLabelHTML() !!}
                </div>
            </div>

            <form id="form-visitors" role="form" class="needs-validation" novalidate autocomplete="off" action="{{ route('visitors.update', $visitor->id) }}"
                  method="POST">
                @csrf
                @method('put')
                @include('pages.painel._partials.forms.form-visitors')
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <button type="button" class="btn btn-primary btn-submit">Salvar</button>
                        <button type="button" onclick="btn_delete(this)" data-route="{{ route('visitors.destroy', $visitor->id) }}" data-action="delete"
                                data-original-title="Cancelar Visita" class="btn btn-outline-warning">
                            <i class="fas fa-trash"></i>
                            Cancelar Visita
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-cards.card-history-log :logs="$visitor->logs()" :user="true" />

@endsection
