@extends("app")

@section('title', 'Concessionaria - ' . ucfirst($concessionaria->name))

@section('content')
    <div class="container">
        <div class="box">
            <div class="box-body box-solid">
                <form role="form" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('concessionarias.update', $concessionaria->id) }}" method="POST">
                    @csrf
                    @method("put")
                    <div class="pt-2">
                        @include("pages.painel._partials.forms.form_concessionaria")
                    </div>
                </form>
            </div>

            <div class="box-body box-solid">
                @include("pages.painel._partials.forms.form_department", [
                $type = "concessionaria_id",
                $idType = $concessionaria->id
                ])
            </div>

            <div class="box-body box-solid">
                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                            <h3 class="box-title">Serviços</h3>
                            <button type="button" class="btn btn-outline-primary waves-effect btn-store waves-light storeServiceConcessionaria">
                                <i class="ri-add-circle-line align-middle mr-2"></i> Novo Serviço
                            </button>
                            <button type="button" style="display:none" class="btn btn-outline-primary btn-back waves-effect waves-light storeServiceConcessionaria">
                                <i class="ri-arrow-left-fill align-middle mr-2"></i> Cancelar
                            </button>
                        </div>
                    </div>

                    <div class="box-body" id="servicesTable">
                        @if (count($Cservices) > 0)
                            <table class="table table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nome do Serviço</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @foreach ($Cservices as $service)
                                    <tr>
                                        <td>{{ $service->name }}</td>
                                        <td>
                                            <a href="{{ route('services.show', [$service->id]) }}" data-toggle="tooltip" data-placement="top"
                                                class="btn btn-xs btn-info"
                                                data-original-title="Visualizar">
                                                <i class="fa fa-clipboard-list"></i>
                                            </a>
                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Retirar"
                                                data-href="{{ route('concessionaria.service.destroy', [$concessionaria->id, $service->id]) }}"
                                                class="btn btn-xs btn-danger btn-delete"
                                                data-original-title="Retirar">
                                                Retirar
                                                <i class="fa fa-minus"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <div class="box-body">
                                <span>Concessionaria sem Serviço</span>
                            </div>
                        @endif
                    </div>

                    <div class="box-body" style="display:none" id="storeServiceConcessionaria">
                        <form id="form-store-concessionaria-service" role="form" class="needs-validation" action="{{ route('concessionaria.service.store', $concessionaria->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="service">Serviço</label>
                                    <select name="service[]" data-placeholder="Selecione o serviço" class="form-control select2" multiple>
                                        @foreach ($servicesNotConces as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <button type="submit" class="btn btn-primary btn-submit">Adicionar </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".storeServiceConcessionaria").on("click", function() {
                $("#storeServiceConcessionaria").toggle();
                $("#servicesTable").toggle();
                $(".btn-store").toggle();
                $(".btn-back").toggle();
            });
        })

    </script>
@endsection
