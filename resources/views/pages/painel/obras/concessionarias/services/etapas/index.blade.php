@extends("app")

@section('title', $concessionaria->name . ' x ' . $service->name)

@section('content-fluid')

    <div class="box-body box-solid pd-t-0">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Etapas</h3>
            </div>
            <div class="box-body">
                <div class="row mg-0">
                    <div class="col-md-3">
                        <label for="">Selecione o Tipo</label>
                        <select name="tipo" id="tipo" class="form-control select2">
                            <option value="" selected>Selecione</option>
                            @foreach ($tipos as $tipo)
                                <option {{ Request::input('tipo') == $tipo->id ? ' selected="selected"' : '' }} value="{{ $tipo->id }}">{{ ucfirst(mb_strtolower($tipo->name, 'UTF-8')) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="box-body d-none" id="div-etapas">
                <div class="row mg-0">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control form-group" name="search-etapa" id="search-etapa" value="" placeholder="Pesquisar">
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-primary btn-new-store" data-toggle="modal" data-target="#modal-add-etapa"></button>
                    </div>
                    <div class="col-md-12">
                        <div class="text-center" id="preloader-content-table">
                            <div class="spinner-border text-primary m-1 align-self-center" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>

                        <div class="table-responsive d-none" style="max-height: 293px;overflow-x: hidden;">
                            <table id="table-etapas" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="70%">Etapa</th>
                                        <th>Tipo</th>
                                    </tr>
                                </thead>
                                <tbody id="results-table"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include("pages.painel._partials.modals.modal-new-etapa", [
    'redirect' => route('concessionaria.service', [$concessionaria->slug, $service->slug])
    ])

@section('scripts')
    <script src="{{ asset('panel/js/pages/etapas.js') }}"></script>
    <script>
        $(document).ready(function() {
            initDiv();

            $('#tipo').on('change', function() {
                initDiv();
            })

            $('#tipo').select2({
                width: '100%',
                placeholder: 'Selecione',
                language: {
                    noResults: function() {
                        return `<a href="javascript:void(0)" onclick="add_tipo()" style="padding: 6px;height: 20px;display: inline-table;">Sem resultados, Adicionar um novo?</a>`;
                    },
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });
        })

        function initTableEtapas() {
            var data = $('#tipo').select2('data');
            var value = data[0].id;
            var search = $('#search-etapa').val();
            $.ajax({
                url: `{{ route('etapas.all') }}`,
                type: 'GET',
                ajax: true,
                dataType: "JSON",
                data: {
                    tipo: value,
                    search: search
                },
                dataType: 'JSON',
                beforeSend: (jqXHR, settings) => {
                    $('#preloader-content-table').removeClass('d-none');
                    $('.table-responsive').addClass('d-none');
                },
                success: function(data) {
                    var options = '';
                    if (data.length != 0) {
                        $.each(data.data, function(index, value) {
                            options += '<tr>';
                            options += '    <td>' + value.name + '</td>';
                            options += '    <td class="d-flex justify-content-between">';
                            options += '        ' + value.tipo +
                                ' <button class="btn btn-sm btn-dark ml-4"><i class="fas fa-arrow-right"></i> <span class="mobile--hidden"> adicionar</span></button>';
                            options += '    </td>';
                            options += '</tr>';
                        });
                    }
                    $('#results-table').html(options);
                    $('#preloader-content-table').addClass('d-none');
                    $('.table-responsive').removeClass('d-none');
                    $('#div-etapas').removeClass('d-none');
                },
            });
        }

        function initDiv() {
            var data = $('#tipo').select2('data');
            var html = data[0].text;
            var id = data[0].id;
            if (html != '' && id != '') {
                $('.btn-new-store').html('Nova Etapa "' + html + '"')
                $('.btn-new-store').attr('data-tipo-id', id)
                $('.btn-new-store').attr('data-tipo-name', html)
                initTableEtapas()
            } else {
                $('#div-etapas').addClass('d-none');
            }
        }

        function add_tipo(name = '') {
            var name = name == '' ? $("#tipo").data("select2").dropdown.$search.val() : name;
            if (name != '') {
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ route('etapas.tipo.store') }}`,
                    type: 'POST',
                    data: {
                        name: name,
                    },
                    dataType: 'json',
                    success: function(json) {
                        var option = new Option(name, json.data.id, true, true);
                        $("#tipo").append(option).trigger('change').trigger('close');
                        $('#tipo').select2('close');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        toastr.error(thrownError);
                    }
                });
            }
        }

    </script>
@endsection

@endsection
