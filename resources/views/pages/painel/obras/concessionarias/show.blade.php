@extends('app')

@section('title', 'Concessionária - ' . ucfirst($concessionaria->name))

@section('content')
    <div class="box">
        <div class="box-body pd-15">

            <ul id="v-tab" class="nav nav-pills pt-3 pb-2 mb-3" role="tablist">
                <li class="nav-item waves-effect waves-light">
                    <a id="v-dados-tab" class="nav-link active" data-tab="concessionaria" data-toggle="tab" href="#v-dados" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block">Dados</span>
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a id="v-department-tab" class="nav-link" data-tab="concessionaria" data-toggle="tab" href="#v-department" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Departamentos</span>
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a id="v-services-tab" class="nav-link" data-tab="concessionaria" data-toggle="tab" href="#v-services" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-file-signature"></i></span>
                        <span class="d-none d-sm-block">Serviços</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content text-muted">
                <div id="v-dados" class="tab-pane active" role="tabpanel">
                    <form id="form-driver" role="form" class="needs-validation" novalidate autocomplete="off"
                          action="{{ route('concessionarias.update', $concessionaria->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <div>
                            @include('pages.painel._partials.forms.form_concessionaria')
                        </div>
                    </form>
                </div>
                <div id="v-department" class="tab-pane" role="tabpanel">
                    @include('pages.painel._partials.forms.form_department', [($type = 'concessionaria_id'), ($idType = $concessionaria->id)])
                </div>
                <div id="v-services" class="tab-pane" role="tabpanel">

                    <div class="box box-default box-solid">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                                    <h3 class="box-title">Serviços</h3>
                                    <button type="button" class="btn btn-outline-primary waves-effect btn-store waves-light storeServiceConcessionaria">
                                        <i class="ri-add-circle-line align-middle mr-2"></i> Novo Serviço
                                    </button>
                                    <button type="button" style="display:none"
                                            class="btn btn-outline-primary btn-back waves-effect waves-light storeServiceConcessionaria">
                                        <i class="ri-arrow-left-fill align-middle mr-2"></i> Cancelar
                                    </button>
                                </div>
                            </div>

                            <div id="servicesTable" class="box-body">
                                <input name="search" placeholder="Buscar..." type="text" class="form-control" data-search-table="table-services"
                                       value="{{ request()->input('search') }}">

                                <div class="table-responsive mt-4" style="overflow-x: hidden;" data-table="table-services">
                                    <table class="table table-bordered table-striped table-hover">
                                        <tbody>
                                            <tr>
                                                <td>Nome</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div id="storeServiceConcessionaria" class="box-body" style="display:none">
                            <form id="form-store-concessionaria-service" role="form" class="needs-validation"
                                  action="{{ route('concessionaria.service.store', $concessionaria->id) }}" method="POST">
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

    <script async>
        $(document).ready(function() {
            $(".storeServiceConcessionaria").on("click", function() {
                $("#storeServiceConcessionaria").toggle();
                $("#servicesTable").toggle();
                $(".btn-store").toggle();
                $(".btn-back").toggle();
            });

            var tab = localStorage.getItem('nav-tabs_concessionaria')
            $('#v-tab a#' + tab).tab('show')
        })
    </script>
@endsection

@section('scripts')
    <script>
        //Pegar os serviços da concessionaria
        const concessionariaId = document.querySelector('#concessionaria_id').value;
        const concessionariaSlug = document.querySelector('#concessionaria_slug').value;
        //const url = `${base_url_api}/v1/concessionarias/${concessionariaId}/services`;
        const tableId = 'table-services';
        const $table = document.querySelector(`[data-table="${tableId}"]`);
        const tableTbody = $table.querySelector('tbody');
        const inputSearchs = document.querySelectorAll(`[data-search-table="${tableId}"]`);

        console.log(inputSearchs);

        const init = async () => {
            $table.querySelector('table').classList.add('d-none');
            tableTbody.innerHTML = '';
            setListInDom();
        }

        const setListInDom = async () => {
            const list = await getServices();
            tableTbody.innerHTML += list.data.map((data) => `
            <tr data-id="${data.id}">
                <td>${data.id}</td>
                <td>${data.name}</td>
                <td class="text-end">

                    <a href="${base_url}/l/concessionarias/${concessionariaSlug}/service/${data.slug}"
                        data-toggle="tooltip" data-placement="top" class="btn btn-xs btn-info"
                        data-original-title="Visualizar">
                        <i class="fa fa-clipboard-list"></i>
                    </a>

                    <button type="button" onclick="btn_delete(this)"
                            data-route="${base_url}/l/concessionarias/${concessionariaId}/service/${data.id}/destroy"
                            data-action="delete" data-text="Excluir" class="btn btn-primary">
                        <i class="fa fa-trash"></i>
                        Excluir
                    </button>

                </td>
            </tr>`).join(' ')
            $table.querySelector('table').classList.remove('d-none');
            initButtons();
        }

        const getServices = async () => {
            return await axios.get(`${base_url}/api/v1/concessionarias/${concessionariaId}/services`, {
                    params: {
                        filters: getFilter(),
                    }
                })
                .then(function(response) {
                    return response.data;
                })
                .catch(function(error) {
                    toastr.error(error.response.data.message);
                });
        }

        const getFilter = () => {
            let filter = {};
            inputSearchs.forEach(item => {
                let id = item.getAttribute('id');
                let value = item.value;
                let name = item.getAttribute('name');
                //let value = JSON.parse(localStorage.getItem(id));
                filter[name] = value;
            })
            return filter;
        }

        const initButtons = () => {
            //document.querySelectorAll('.page').forEach(item => {
            //    item.addEventListener('click', changePage);
            //})
        }

        inputSearchs.forEach(item => {
            item.addEventListener('input', debounce(function() {
                init();
            }, 900));
        })

        document.addEventListener('DOMContentLoaded', () => {
            init();
        });
    </script>
@append
