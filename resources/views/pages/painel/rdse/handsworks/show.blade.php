@extends("app")

@section('title', 'Editar - ' . ucfirst($handswork->description))

@section('content')

    <div class='card'>
        <div class='card-body'>
            <form role="form" class="needs-validation" novalidate id="form-handsworkes" autocomplete="off" action="{{ route('handswork.update', $handswork->id) }}" method="POST">
                <div class="box-body">
                    @csrf
                    @method("put")
                    @include('pages.painel._partials.forms.form-handswork')
                    <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                </div>
            </form>
        </div>
    </div>
@stop
