@extends("app")

@section("title", "Cliente - " . ucfirst($client->username))

@section("content")
    <div class="box">
        <div class="box-body">
            <form role="form" class="needs-validation" novalidate id="form-clients" autocomplete="off" action="{{ route("clients.update", $client->uuid) }}" method="POST">
                @csrf
                @method("put")
                @include("pages.painel._partials.forms.form-clients")
            </form>
        </div>

        <div>
            @include("pages.painel._partials.forms.form_department", [
            $type = "client_id",
            $idType = $client->id
            ])
        </div>

        <div>
            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Excluir Cliente" data-href="{{ route("clients.destroy", $client->uuid) }}"
                class="btn btn-xs btn-danger btn-delete float-left"
                data-original-title="Excluir Cliente"><i class="fa fa-trash"></i> Excluir Cliente
            </a>
        </div>
    </div>
@stop
