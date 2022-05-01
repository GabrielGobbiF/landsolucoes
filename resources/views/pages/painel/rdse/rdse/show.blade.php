@extends("app")

@section('title', 'Editar - ' . ucfirst($rdse->description))

@section('content-max-fluid')

    <style class="">
        .form-group {
            margin-right: 8px;
        }

        table * a[type=button] {
            vertical-align: -webkit-baseline-middle
        }

        table * input.description_sap {
            text-transform: uppercase;
        }

    </style>

    <div class='card'>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#info" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-info"></i></span>
                        <span class="d-none d-sm-block">Dados</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#services-tab" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Serviços</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-3 text-muted">

                <div class="tab-pane" id="info" role="tabpanel">
                    <form role="form" class="needs-validation" novalidate id="form-rdse" autocomplete="off" action="{{ route('rdse.update', $rdse->id) }}" method="POST">
                        @csrf
                        @method("put")
                        @include('pages.painel._partials.forms.form-rdse')
                        <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                    </form>
                </div>

                <div class="tab-pane active" id="services-tab" role="tabpanel">
                    <form id='form-update-services-rdse' role='form' class='needs-validation' method='POST'>
                        <div id="services">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="d-none"></th>
                                        <th style="width: 13%">Chegada</th>
                                        <th style="width: 10%">Qnt Minutos</th>
                                        <th style="width: 10%">Saida</th>
                                        <th style="width: 10%">Horas</th>
                                        <th style="width: 15%">SAP</th>
                                        <th>Descrição</th>
                                        <th style="width: 10%">Horas / <br>Qnt Atividade</th>
                                        <th style="width: 10%">Preço</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="services-row">
                                    @foreach ($rdseServices as $service)
                                        <tr class="service-row" data-id="{{ $service->id }}" id="services_{{ $service->id }}">
                                            <th class="d-none">
                                                <input type="hidden" name="serviceId[]" value="{{ $service->id }}">
                                            </th>
                                            <th>
                                                <div class="form-group">
                                                    <input type="time" class="form-control chegada_obra"
                                                        id="chegada_obra_{{ $service->id }}"
                                                        name="chegada[]"
                                                        data-id="{{ $service->id }}"
                                                        value="{{ $service->chegada }}" />
                                                </div>
                                            </th>
                                            <th>
                                                <div class="form-group ">
                                                    <input min="0" type="number" class="form-control qnt_minutos"
                                                        id="qnt_minutos_{{ $service->id }}"
                                                        name="minutos[]"
                                                        data-id="{{ $service->id }}"
                                                        value="{{ $service->minutos }}" />
                                                </div>
                                            </th>

                                            <th>
                                                <div class="form-group ">
                                                    <input class="form-control saida_obra"
                                                        name="saida[]"
                                                        required readonly tabindex="-1"
                                                        value="{{ !empty($service->saida) ? $service->saida : '' }}" />
                                                </div>
                                            </th>

                                            <th>
                                                <input class="form-control hours"
                                                    name="horas[]"
                                                    id="hours_{{ $service->id }}" readonly
                                                    data-id="{{ $service->id }}"
                                                    value="{{ !empty($service->horas) ? $service->horas : '' }}"
                                                    tabindex="-1" />
                                            </th>

                                            <th>
                                                <select name="codigo_sap[]" class="form-control select2 codigo_sap"
                                                    placeholder="Código SAP"
                                                    data-id="{{ $service->id }}">
                                                    @if (!empty($service->codigo_sap))
                                                        <option value="{{ $service->codigo_sap }}">
                                                            {{ !empty($service->handswork) ? $service->handswork->code : '' }}
                                                        </option>
                                                    @else
                                                        <option value="" selected> Selecione </option>
                                                    @endif
                                                </select>
                                            </th>

                                            <th>
                                                <input class="form-control description_sap"
                                                    name="description[]"
                                                    id="description_sap_{{ $service->id }}"
                                                    value="{{ !empty($service->description)? $service->description: (!empty($service->handswork)? $service->handswork->description: '') }}" />
                                            </th>

                                            <th>
                                                <input type="hidden" id="price_ups_{{ $service->id }}" value="{{ !empty($service->handswork) ? $service->handswork->price_ups : '0' }}">
                                                <input
                                                    min="0"
                                                    type="number"
                                                    class="form-control conversion"
                                                    name="qnt_atividade[]" id="conversion_{{ $service->id }}"
                                                    data-id="{{ $service->id }}"
                                                    value="{{ !empty($service->qnt_atividade) ? $service->qnt_atividade : '0' }}" />
                                            </th>
                                            <th>
                                                <input class="form-control price_total_hours money"
                                                    name="preco[]"
                                                    id="price_total_hours_{{ $service->id }}"
                                                    value="{{ !empty($service->preco) ? $service->preco : '0' }}" />
                                            </th>

                                            <th>
                                                <a type="button" href="javascript:void(0)" onclick="deleteService(`{{ $service->id }}`)" class=" " tabindex="-1">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tbody>
                                    <tr class="text-end">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th scope="row">
                                            Total Espera :
                                        </th>
                                        <td class="total_espera" colspan="2"></td>
                                    </tr>
                                    <tr class="text-end">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th scope="row">
                                            Total Serviços :
                                        </th>
                                        <td class="total_servico" colspan="2"></td>
                                    </tr>

                                    <tr class="text-end">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th scope="row">
                                            Total R$ :
                                        </th>
                                        <td class="total" colspan="2"></td>
                                    </tr>

                                    <tr class="text-end">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th scope="row">
                                            Total UPS :
                                        </th>
                                        <td class="total_ups" colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <button type='button' class='btn btn-primary' id="button_modal-rdse-codigo">
        Visualizar Códigos
    </button>
    <div class='modal' id='modal-rdse-codigo' tabindex='-1' role='dialog'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Códigos</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <table class='table table-hover' id="table-codigos-rdse">
                        <thead class='thead-light'>
                            <tr>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        const rdseId = $('#rdse_id').val();
        const priceUps = $('#price_ups').val();
        const formIdentifier = `services_rdse_${rdseId}`;
        const div = $("#services");
        let formRdse = document.querySelector(`#form-update-services-rdse`);
        let unsaved = true;

        window.addEventListener('load', () => {
            initInputs();
            attTotal();
            setInterval("updateServices()", 5000);
        });



        $('#button_modal-rdse-codigo').on('click', () => {

            var html = '';
            let table = $('#table-codigos-rdse');
            let body = table.find('tbody');
            body.html('');

            $('.codigo_sap').each(function() {
                var data = $(this).select2('data')
                if (data[0].text != ' Selecione ') {
                    html += `<tr>
                                  <th>${data[0].text}</th>
                                </tr>`;
                }

            })
            body.append(html)
            $('#modal-rdse-codigo').modal('show');
        })



        $(function() {
            $("#services-row").sortable({
                update: function() {
                    axios.post(`${base_url}/api/v1/rdse/${rdseId}/services/reorder`, {
                            itens: $(this).sortable("toArray")
                        })
                        .then(response => {
                            attLines();
                            unsaved = false;
                        })
                        .catch((error) => {
                            toastr.error(error);
                        });
                }
            });
        })

        $('body').on('click', function() {
            window.onbeforeunload = function() {
                if (!unsaved)
                    return 'Os dados do formulário não foram salvos, deseja permanecer nesta página?';
            };
        });

        $('body').on('keydown', debounce(function(e) {
            e.preventDefault();
            e.stopPropagation();
            let eClick = true;
            if (e.which === 9 && !$(".select2-search__field").is(":focus") && eClick) {
                let option = true;
                $('.qnt_minutos').each(function() {
                    if ($(this).val() == '0' || $(this).val() == '') {
                        option = false;
                    }
                })
                if (option) {
                    eClick = false;
                    eClick = addRow();
                }
            }
        }, 100));

        const initInputs = () => {
            /**
             * Toda alteração de conteudo irá mandar o post para salvar
                $('input, select').on('change', debounce(function(e) {
                    updateServices();
                }, 2000));
            */

            div.find('input, select').on('keyup change focus, click', function(e) {
                unsaved = false;
            });

            $('.qnt_minutos, .conversion').on('focusin', function() {
                $(this).val() == '0' ? $(this).val('') : ''
            }).on('focusout', function() {
                $(this).val() == '' ? $(this).val('0') : ''
            })

            $('.chegada_obra, .qnt_minutos').on('keyup change', function() {
                attLines();
            })

            $(`.select2.codigo_sap`).select2(optionsSelectSap);

            $(document).on('focus', '.select2', function(e) {
                $(this).siblings('select').select2('open');
            });

            $('select').on('select2:open', (e) => {
                if (!e.target.multiple) {
                    document.querySelector('.select2-search__field').focus();
                }
                $('.select2-dropdown--below').css('width', '300px !important');
            });

            $('.select2.codigo_sap').on('select2:select', function(e) {
                let id = $(this).attr('data-id');
                let price_ups = e.params.data.price_ups
                $(`#price_ups_${id}`).val(price_ups);
                $(`#description_sap_${id}`).val(e.params.data.description);
                updateHorasAtividades(id);
                attTotal();
            });

            $('.conversion').on('keyup change', function() {
                updateHorasAtividades($(this).attr('data-id'));
            })

            $('.price_total_hours, .conversion').on('keyup change', function() {
                attTotal();
            })
        }

        function attLines() {
            $(".service-row").each(function() {
                let id = $(this).attr("data-id");
                let line = $(this).next('.service-row').attr('data-id');

                let saida_obra = $(this).find(`.saida_obra`);
                let chegada_obra = $(this).find(`.chegada_obra`).val();
                let minute = $(this).find(`.qnt_minutos`).val();
                let chegada_obra_line = $(`#chegada_obra_${line}`);
                let hours = $(this).find(`.hours`);

                //add minutes 
                var chegada_obra_date = moment(chegada_obra, "HH:mm:ss")
                var saida_obra_date = chegada_obra_date.add(minute, 'minutes');

                if (chegada_obra_date.isValid() && saida_obra_date.isValid()) {
                    saida_obra.val(saida_obra_date.format('HH:mm:ss'));
                    chegada_obra_line.val(saida_obra_date.format('HH:mm:ss'));

                    var now = saida_obra.val();
                    let then = chegada_obra;

                    hours.val(moment.utc(moment(now, "HH:mm:ss").diff(moment(then, "HH:mm:ss"))).format("HH:mm:ss"));
                    updateHorasAtividades(id);
                }
            })
        }

        function attTotal() {
            let total_espera = 0;
            let total_servico = 0;
            let total = 0;
            let total_ups = 0;
            $(".service-row").each(function() {
                const selectSap = $(this).find(`select.codigo_sap`).select2('data');
                if (selectSap.length > 0 && selectSap[0].id == '212') {
                    total_espera += clearNumber($(this).find(`.price_total_hours `).val());
                }
                total += clearNumber($(this).find(`.price_total_hours `).val());
            })

            total_ups = numberFormat(total / priceUps);
            total_servico = numberFormat(total - total_espera);

            total = numberFormat(total);
            total_espera = numberFormat(total_espera);

            $('.total_espera').html(`R$ ${total_espera}`)
            $('.total').html(`R$ ${total}`)
            $('.total_servico').html(`R$ ${total_servico}`)
            $('.total_ups').html(`${total_ups}`)

        }

        function updateHorasAtividades(serviceId) {
            let serviceDiv = $(`#services_${serviceId}`);
            let selectSap = serviceDiv.find(`select.codigo_sap`).select2('data');
            let minute = serviceDiv.find(`.qnt_minutos`).val();
            let price_service_ups = $(`#price_ups_${serviceId}`).val();
            let inputQntAtividade = $(`#conversion_${serviceId}`);
            let inputPriceTotal = $(`#price_total_hours_${serviceId}`);
            let valueQntAtividade = inputQntAtividade.val();

            if (price_ups != '0') {
                if (selectSap && selectSap[0].id == '212') {
                    let conversion = minute / 30;
                    let conversionMathFloor = Math.floor(conversion);
                    let priceTotal = numberFormat((price_service_ups * priceUps) * conversionMathFloor)
                    inputQntAtividade.val(conversionMathFloor)
                    inputPriceTotal.val(`${priceTotal}`)
                    inputQntAtividade.attr('readonly', true).attr('tabindex', '-1');
                } else if (selectSap && selectSap[0].id != '') {
                    inputQntAtividade.attr('readonly', false).removeAttr('tabindex');
                    if (valueQntAtividade != 0) {
                        let priceTotal = numberFormat((price_service_ups * priceUps) * valueQntAtividade);
                        inputPriceTotal.val(`${priceTotal}`)
                    } else {
                        inputPriceTotal.val(0)
                    }
                } else {
                    inputQntAtividade.attr('readonly', false).removeAttr('tabindex');
                }
            }
        }

        const addRow = async () => {
            await updateServices();

            const service = await storeService();

            if (service && service.data != undefined && service.data != 'andamento') {
                let line = service.data;

                if ($(`#services_${line}`).length == 0) {

                    let html = `
                        <tr class="service-row" data-id="${line}" id="services_${line}" tabindex="-1">
                            <th class="d-none">
                                <input type="hidden" name="serviceId[]" value="${line}" />
                            </th>
                            <th>
                                <div class="form-group">
                                    <input type="time" class="form-control chegada_obra"
                                    id="chegada_obra_${line}" name="chegada[]" data-id="${line}" readonly tabindex="-1"/>
                                </div>
                            </th>
                            <th>
                                <div class="form-group ">
                                    <input type="number" class="form-control qnt_minutos"
                                    id="qnt_minutos_${line}" name="minutos[]" data-id="${line}" value="0" />
                                </div>
                            </th>
                        
                            <th>
                                <div class="form-group ">
                                    <input class="form-control saida_obra" name="saida[]" required readonly tabindex="-1"/>
                                </div>
                            </th>
                        
                            <th>
                                <input class="form-control hours" name="horas[]" id="hours_${line}" readonly data-id="${line}" tabindex="-1"/>
                            </th>
                        
                            <th>
                                <select name="codigo_sap[]" class="form-control select2 codigo_sap" placeholder="Código SAP" id="codigo_sap_${line}" data-id="${line}">
                                    <option value="" selected> Selecione  </option>  
                                </select>
                            </th>
                        
                            <th>
                                <input class="form-control description_sap" name="description[]" id="description_sap_${line}" />
                            </th>
                        
                            <th>
                                <input type="hidden" id="price_ups_${line}">
                                <input class="form-control conversion" 
                                name="qnt_atividade[]" id="conversion_${line}" 
                                data-id="${line}"
                                tabindex="-1" 
                                value="0" />
                            </th>
                        
                            <th>
                                <input class="form-control price_total_hours money" name="preco[]" id="price_total_hours_${line}"  value="0" />
                            </th>
                        
                            <th>
                                <a type="button" href="javascript:void(0)" onclick="deleteService(${line})" tabindex="-1">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </th>
                        </tr> `;

                    $('#services-row').append(html);
                    initInputs();
                    attLines();

                    $('html, body').animate({
                        scrollTop: $(document).height()
                    }, 1500);

                    return true;
                }
            }
            return false;
        };

        const updateServices = async () => {
            let formData = new FormData($("#form-update-services-rdse")[0]);
            formData.append('_method', 'PUT');

            if (!unsaved)
                await axios.post(`${base_url}/api/v1/rdse/${rdseId}/services/all`, formData)
                .then(response => {
                    unsaved = true;
                })
                .catch((error) => {
                    toastr.error(error);
                });
        }

        const storeService = async () => {
            return await axios.post(`${base_url}/api/v1/rdse/${rdseId}/services`).catch(error => {
                toastr.error(error)
            });
        }

        function deleteService(serviceId) {
            axios.post(`${base_url}/api/v1/rdse/${rdseId}/services/${serviceId}`, {
                    _method: 'DELETE'
                })
                .then(response => {
                    $(`#services_${serviceId}`).remove();
                    attLines();
                    attTotal();
                })
                .catch(error => {
                    toastr.error(error)
                })
        }

        /**
         * Debounce
         */
        function debounce(fn, delay) {
            var timer = null;
            return function() {
                var context = this,
                    args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    fn.apply(context, args);
                }, delay);
            };
        }

        const optionsSelectSap = {
            dropdownAutoWidth: true,
            multiple: false,
            minimumInputLength: 3,
            language: "pt-br",
            selectOnClose: true,
            formatNoMatches: function() {
                return "Pesquisa não encontrada";
            },
            inputTooShort: function() {
                return "Digite para Pesquisar";
            },
            templateResult: formatState,
            ajax: {
                url: `{{ route('api.handswork.all') }}`,
                dataType: 'json',
                data: function(term, page) {
                    return {
                        search: term, //search term
                    };
                },
                processResults: function(data, page) {
                    var myResults = [];
                    $.each(data.data, function(index, item) {
                        myResults.push({
                            'id': item.id,
                            'text': `${item.code}`,
                            'description': item.description,
                            'price_ups': item.price_ups,
                        });
                    });
                    return {
                        results: myResults
                    };
                }
            },
            escapeMarkup: function(m) {
                return m;
            }
        }

        function formatState(state) {
            return `${state.text} - ${state.description}`;
        };

        function clearNumber(number) {
            if (number == '' || number == null) {
                return 0;
            }
            number = number.toString().replace("R$", "").replace(".", "").replace(".", "");
            number = number.replace(",", ".");
            return number != '' ? numeral(number).value() : 0;
        }

        function numberFormat(number) {
            return number.toLocaleString('pt-br', {
                minimumFractionDigits: 2
            })
        }
    </script>
@append
