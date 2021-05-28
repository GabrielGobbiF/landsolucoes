@extends("app")

@section('title', 'Serviço - ' . ucfirst($service->name))

@section('content')
    <div class="container">
        <div class="box">
            <div class='box-body box-solid'>
                <form role="form" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('services.update', $service->id) }}" method="POST">
                    @csrf
                    @method("put")
                    <div class="pt-2">
                        @include("pages.painel._partials.forms.form_service")
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
