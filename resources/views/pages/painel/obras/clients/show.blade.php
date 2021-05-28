@extends("app")

@section('title', 'Cliente - ' . ucfirst($client->username))

@section('content')
    <div class="container">
        <div class="box">
            <div class='box-body box-solid'>
                <form role="form" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('clients.update', $client->uuid) }}" method="POST">
                    @csrf
                    @method("put")
                    @include("pages.painel._partials.forms.form_client")
                </form>
            </div>
            <div class='box-body box-solid'>
                @include("pages.painel._partials.forms.form_department", [
                $type = 'client_id',
                $idType = $client->uuid
                ])
            </div>
        </div>
    </div>
@stop
