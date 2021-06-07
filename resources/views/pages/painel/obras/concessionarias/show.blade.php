@extends("app")

@section('title', 'Concessionária - ' . ucfirst($concessionaria->name))

@section('content')
    <div class="container">
        <div class="box">
            <div class="box-body  pd-25">
                <div class="row">
                    <div class="col-12 col-md-2">
                        <div class="nav flex-column nav-pills" data-tab="concessionaria" id="v-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link mb-2 active" data-tab="concessionaria" id="v-dados-tab" data-toggle="pill" href="#v-dados" role="tab" aria-controls="v-dados" aria-selected="true">Dados</a>
                            <a class="nav-link mb-2" data-tab="concessionaria" id="v-department-tab" data-toggle="pill" href="#v-department" role="tab" aria-controls="v-department"
                                aria-selected="false">Departamentos</a>
                            <a class="nav-link mb-2" data-tab="concessionaria" id="v-services-tab" data-toggle="pill" href="#v-services" role="tab" aria-controls="v-services"
                                aria-selected="false">Serviços</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-10">
                        <div class="tab-content text-muted" id="v-tabContent">
                            <div class="tab-pane fade show active" id="v-dados" role="tabpanel" aria-labelledby="v-dados-tab">
                                <div class="box-body  pd-t-0">
                                    <form role="form" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('concessionarias.update', $concessionaria->id) }}"
                                        method="POST">
                                        @csrf
                                        @method("put")
                                        <div>
                                            @include("pages.painel._partials.forms.form_concessionaria")
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-department" role="tabpanel" aria-labelledby="v-department-tab">
                                <div class="box-body ">
                                    @include("pages.painel._partials.forms.form_department", [
                                    $type = "concessionaria_id",
                                    $idType = $concessionaria->id
                                    ])
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-services" role="tabpanel" aria-labelledby="v-services-tab">
                                <div class="box-body ">
                                    <div class="box box-default ">
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
                                                <div class="table-responsive" style="overflow-x: hidden;">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Nome do Serviço</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($Cservices as $service)
                                                                <tr>
                                                                    <td class="d-flex justify-content-between">
                                                                        <span class="align-self-center tx-max-xs-14"> {{ $service->name }}</span>
                                                                        <div class="buttons">
                                                                            <a href="{{ route('concessionaria.service', [$concessionaria->slug, $service->slug]) }}" data-toggle="tooltip"
                                                                                data-placement="top"
                                                                                class="btn btn-xs btn-info"
                                                                                data-original-title="Visualizar">
                                                                                <i class="fa fa-clipboard-list"></i>
                                                                            </a>
                                                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" data-title="Excluir"
                                                                                data-href="{{ route('concessionaria.service.destroy', [$concessionaria->id, $service->id]) }}"
                                                                                class="btn btn-xs btn-danger btn-delete"
                                                                                data-original-title="Excluir">
                                                                                <span class="mobile--hidden">Excluir</span>
                                                                                <i class="fa fa-minus"></i>
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="box-body">
                                                    <span>Concessionária sem Serviço</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="box-body" style="display:none" id="storeServiceConcessionaria">
                                            <form id="form-store-concessionaria-service" role="form" class="needs-validation" action="{{ route('concessionaria.service.store', $concessionaria->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="service">Adicionar novo Serviço</label>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script async>
        $(document).ready(function() {
            $(".storeServiceConcessionaria").on("click", function() {
                $("#storeServiceConcessionaria").toggle();
                $("#servicesTable").toggle();
                $(".btn-store").toggle();
                $(".btn-back").toggle();
            });

            tab = localStorage.getItem('nav-tabs_concessionaria')
            $('#v-tab a#' + tab).tab('show')
        })

    </script>
@endsection
