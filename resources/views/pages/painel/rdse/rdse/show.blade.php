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
                                                <div class="form-group ">
                                                    <input type="time" class="form-control chegada_obra"
                                                        onchange="att_lines()"
                                                        onkeyup="att_lines()" id="chegada_obra_{{ $service->id }}"
                                                        name="chegada[]"
                                                        data-id="{{ $service->id }}"
                                                        value="{{ $service->chegada }}" />
                                                </div>
                                            </th>
                                            <th>
                                                <div class="form-group ">
                                                    <input type="number" class="form-control qnt_minutos"
                                                        onchange="att_lines()"
                                                        onkeyup="att_lines()" id="qnt_minutos_{{ $service->id }}"
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
                                                <input class="form-control conversion"
                                                    onchange="updatePriceByQntAtv({{ $service->id }})"
                                                    onkeyup="updatePriceByQntAtv({{ $service->id }})"
                                                    name="qnt_atividade[]" id="conversion_{{ $service->id }}"
                                                    value="{{ !empty($service->qnt_atividade) ? $service->qnt_atividade : '0' }}" />
                                            </th>
                                            <th>
                                                <input class="form-control price_total_hours money"
                                                    name="preco[]"
                                                    id="price_total_hours_{{ $service->id }}"
                                                    value="{{ !empty($service->preco) ? $service->preco : '' }}" />
                                            </th>

                                            <th>
                                                <a type="button" href="#" onclick="deleteService(`{{ $service->id }}`)" class=" " tabindex="-1">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            clickQntMinutes();
            att_lines();
            initSelect2();
        })

        $('body').on('keydown', function(e) {
            // if (e.which === 9) {
            //     let focus = $('#onfocus').val();
            //     let nextFocus = parseInt(focus) + 1;
            //     document.getElementById(`saida_obra_1`).focus({
            //         preventScroll: true
            //     });
            // }

            if (e.which === 9) {

                axios.get(`${base_url}/api/v1/rdse/lastServiceId`).then(function(response) {
                    let count = response.data;
                    let line = parseInt(count) + 1;

                    let html = `
                        <tr class="service-row" data-id="${line}" id="services_${line}" tabindex="-1">
                         <input type="hidden" name="serviceId[]" value="${line}" />
                            <th>
                                <div class="form-group ">
                                    <input type="time" class="form-control chegada_obra"
                                        onchange="att_lines()"
                                        onkeyup="att_lines()" id="chegada_obra_${line}" name="chegada[]" data-id="${line}" readonly tabindex="-1"/>
                                </div>
                            </th>
                            <th>
                                <div class="form-group ">
                                    <input type="number" class="form-control qnt_minutos"
                                        onchange="att_lines()"
                                        onkeyup="att_lines()" id="qnt_minutos_${line}" name="minutos[]" data-id="${line}" value="0" />
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
                                <select name="codigo_sap[]" class="form-control select2 codigo_sap" placeholder="Código SAP" data-id="${line}"></select>
                            </th>

                            <th>
                                <input class="form-control description_sap" name="description[]" id="description_sap_${line}" />
                            </th>

                            <th>
                                <input type="hidden" id="price_ups_${line}">
                                <input class="form-control conversion" 
                                onchange="updatePriceByQntAtv(${line})" 
                                onkeyup="updatePriceByQntAtv(${line})" name="qnt_atividade[]" id="conversion_${line}" 
                                readonly tabindex="-1" />
                            </th>

                            <th>
                                <input class="form-control price_total_hours money" name="preco[]" id="price_total_hours_${line}" />
                            </th>

                            <th>
                                <a type="button" href="#" onclick="deleteService(${line})" class=" " tabindex="-1">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </th>
                        </tr>


                `;


                    //let html =
                    //    `<div class="row row-xs service-row no-gutters" data-id="${line}" id="services_${line}">
                //        <div class="form-group col-1" style="min-width:125px">
                //            <label>Chegada na obra</label>
                //            <input type="time" class="form-control chegada_obra" onchange="att_lines()" onkeyup="att_lines()" id="chegada_obra_${line}" name="chegada_obra[]" data-id="${line}" disabled />
                //        </div>
                //
                //        <div class="form-group col-1">
                //            <label>Qnt Minutos</label>
                //            <input type="number" class="form-control qnt_minutos" onchange="att_lines()" onkeyup="att_lines()" id="qnt_minutos_${line}" name="qnt_minutos[]" data-id="${line}"
                //                value="0" />
                //        </div>
                //
                //        <div class="form-group col-1" style="min-width:125px">
                //            <label>Saida da obra</label>
                //            <input class="form-control saida_obra" name="saida_obra[]" id="saida_obra_${line}" required disabled />
                //        </div>
                //
                //        <div class="form-group col-1" style="min-width:125px">
                //            <label>Horas</label>
                //            <input class="form-control hours" name="hours"  disabled data-id="${line}" />
                //        </div>
                //
                //        <div class="form-group col-1" style="min-width:150px">
                //            <label>SAP</label>
                //            <select name="" class="form-control select2 codigo_sap" data-id="${line}" placeholder="Código SAP"></select>
                //        </div>
                //
                //        <div class="form-group col-3" style="min-width:220px">
                //            <label>Descrição</label>
                //            <input class="form-control description_sap" name="description_sap" id="description_sap_${line}"  />
                //        </div>
                //    </div>
                //    `

                    let option = true;
                    $('.qnt_minutos').each(function() {
                        if ($(this).val() == '0') {
                            option = false;
                        }
                    })

                    if (option) {
                        $('#services-row').append(html);
                        clickQntMinutes();
                        initSelect2();
                        att_lines();
                    }

                });
            }
        });

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

        function att_lines() {

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

                saida_obra.val(saida_obra_date.format('HH:mm:ss'));
                chegada_obra_line.val(saida_obra_date.format('HH:mm:ss'));

                var now = saida_obra.val();
                let then = chegada_obra;

                hours.val(moment.utc(moment(now, "HH:mm:ss").diff(moment(then, "HH:mm:ss"))).format("HH:mm:ss"));
                updateHorasEspera(id);
            })

        }

        function updateAjax() {
            var form_data = new FormData($("#form-update-services-rdse")[0]);
            let id = $('#rdse_id').val();
            axios.post(`${base_url}/api/v1/rdse/${id}/services`, form_data)
                .then(function(response) {})
                .catch(function(error) {
                    toastr.error(error);
                });
        }

        function initSelect2() {
            $(".codigo_sap").select2({
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
            });

            $(document).on('focus', '.select2-selection.select2-selection--single', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            });

            // steal focus during close - only capture once and stop propogation
            $('.select2').on('select2:closing', function(e) {
                $(e.target).data("select2").$selection.one('focus focusin', function(e) {
                    e.stopPropagation();
                });
            });

            $('.select2').on('select2:select', function(e) {
                let id = $(this).attr('data-id');
                let price_ups = e.params.data.price_ups
                $(`#description_sap_${id}`).val(e.params.data.description);

                if (e.params.data.id == 212) {
                    addInputEspera(id, price_ups);
                } else {
                    addInputQntAtividade(id, price_ups)
                }
            });

            $('select').on('select2:open', (event) => {
                if (!event.target.multiple) {
                    document.querySelector('.select2-search__field').focus();
                }
            });

            $('input, select').on('change', debounce(function(event) {
                updateAjax();
            }, 1200));

        }

        function addInputEspera(id, price_ups) {
            $(`#price_ups_${id}`).val(price_ups);
            $(`#conversion_${id}`).attr('readonly', true);
            $(`#conversion_${id}`).attr('tabindex', '-1');

            //const div = $(`#services_${id}`)
            //let countDiv = $(`#conversion_${id}`).length;
            //if (countDiv == 0) {
            //    const div = $(`#services_${id}`)
            //    let html = `
        //        <input type="hidden" id="price_ups_${id}" value="${price_ups}" >
        //        <div class="form-group col-1" style="min-width:115px">
        //            <label>Horas Espera</label>
        //            <input class="form-control conversion" name="conversion" id="conversion_${id}" disabled />
        //        </div>
        //
        //        <div class="form-group col-1" style="min-width:120px">
        //            <label>Preço</label>
        //            <input class="form-control price_total_hours money" name="price_total_hours" id="price_total_hours_${id}" />
        //        </div>
        //    `;
            //    div.append(html)
            //}
            //$('.money').mask('000.000.000.000.000,00', {
            //    reverse: true
            //});
            updateHorasEspera(id);
        }

        function updateHorasEspera(id) {
            const div = $(`#services_${id}`)
            const selectSap = div.find(`select.codigo_sap`).select2('data') ?? false;

            if (selectSap != '') {
                if (selectSap[0].id == '212') {
                    let minute = div.find(`.qnt_minutos`).val();
                    let conversion = minute / 30;
                    conversion = Math.floor(conversion);
                    let priceTotal = numberFormat(($(`#price_ups_${id}`).val() * 299.97) * conversion)
                    div.find(`#conversion_${id}`).val(conversion)
                    div.find(`#price_total_hours_${id}`).val(`${priceTotal}`)
                }
            }
        }

        function addInputQntAtividade(id, price_ups) {
            $(`#price_ups_${id}`).val(price_ups);
            $(`#conversion_${id}`).attr('readonly', false);
            $(`#conversion_${id}`).removeAttr('tabindex');

            //const div = $(`#services_${id}`)
            //let countDiv = $(`#qnt_atv_${id}`).length;
            //if (countDiv == 0) {
            //    const div = $(`#services_${id}`)
            //    let html = `
        //        <input type="hidden" id="price_ups_${id}" value="${price_ups}" >
        //        <div class="form-group col-1" style="min-width:115px">
        //            <label>Qnt Atividade</label>
        //            <input type="number" class="form-control qnt_atv" onchange="updatePriceByQntAtv(${id})" onkeyup="updatePriceByQntAtv(${id})" name="qnt_atv" id="qnt_atv_${id}" value="0" />
        //        </div>
        //
        //        <div class="form-group col-1" style="min-width:120px">
        //            <label>Preço</label>
        //            <input class="form-control price_total_hours money" name="price_total_hours" id="price_total_hours_${id}" />
        //        </div>
        //    `;
            //    div.append(html)
            //}
            updatePriceByQntAtv(id);
        }

        function updatePriceByQntAtv(id) {
            const div = $(`#services_${id}`)
            let qntAtv = $(`#conversion_${id}`).val()


            if (qntAtv != 0) {
                let priceTotal = numberFormat(($(`#price_ups_${id}`).val() * 299.97) * qntAtv);
                div.find(`#price_total_hours_${id}`).val(`${priceTotal}`)
            }
        }

        function numberFormat(number) {
            return number.toLocaleString('pt-br', {
                minimumFractionDigits: 2
            })
        }

        function clickQntMinutes() {
            $('.qnt_minutos').on('focusin', function() {
                $(this).val() == '0' ? $(this).val('') : ''
            }).on('focusout', function() {
                $(this).val() == '' ? $(this).val('0') : ''
            })
        }

        function deleteService(serviceId) {
            let rdseId = $('#rdse_id').val();
            axios.delete(`${base_url}/api/v1/rdse/${rdseId}/services/${serviceId}`)
                .then(() => {
                    $(`#services_${serviceId}`).remove();
                    att_lines();
                })
                .catch((response) => {
                    toastr.error(response)
                })
        }
    </script>
@append
