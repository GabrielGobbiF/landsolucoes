@extends('app')

@section('title', 'Editar Comercial')

@section('content')
    <div class="container">
        <div class="box">
            <div class="box-body">
                <form id="form-driver" role="form-create-comercial" class="needs-validation" novalidate autocomplete="off"
                      action="{{ route('comercial.updata.data', $comercial->id) }}" method="POST">
                    @csrf
                    @method('PUT')


                    <div class="box box-default box-solid">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">Dados da Obra</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="input--razao_social">Nome da Obra</label>
                                            <input id="input--razao_social" required type="text" name="razao_social"
                                                   class="form-control @error('razao_social') is-invalid @enderror"
                                                   value="{{ $comercial->razao_social ?? old('razao_social') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="select--concessionaria"
                                                   class="@error('concessionaria_id') is-invalid-label @enderror">Concessionária</label>
                                            <select id="select--concessionaria" required name="concessionaria_id"
                                                    class="form-control select2 select--concessionaria @error('concessionaria_id') is-invalid @enderror">
                                                <option value="" selected>Selecione</option>
                                                @foreach ($concessionarias as $concessionaria)
                                                    <option {{ isset($comercial) && $comercial->concessionaria_id == $concessionaria->id ? 'selected' : '' }}
                                                            {{ old('concessionaria_id') == $concessionaria->id ? 'selected' : '' }}
                                                            {{ Request::input('concessionaria_id') == $concessionaria->id ? 'selected' : '' }}
                                                            value="{{ $concessionaria->id }}"> {{ $concessionaria->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="select--service" class="@error('service_id') is-invalid-label @enderror">Tipo de Obra/Serviço</label>
                                            <select id="select--service" required name="service_id" data-placeholder="Selecione a Concessionaria"
                                                    class="form-control select2"></select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="input--requester">Solicitante</label>
                                            <input id="input--requester" type="text" name="requester"
                                                   class="form-control @error('requester') is-invalid @enderror"
                                                   value="{{ $comercial->requester ?? old('requester') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="input--requester_email">Email</label>
                                            <input id="input--requester_email" type="text" name="requester_email"
                                                   class="form-control @error('requester_email') is-invalid @enderror"
                                                   value="{{ $comercial->requester_email ?? old('requester_email') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="input--requester_phone">Telefone</label>
                                            <input id="input--requester_phone" type="text" name="requester_phone"
                                                   class="form-control @error('requester_phone') is-invalid @enderror"
                                                   value="{{ $comercial->requester_phone ?? old('requester_phone') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="select--client" class="@error('client_id') is-invalid-label @enderror">Cliente</label>
                                            <select id="select--client" required name="client_id" class="form-control select2">
                                                <option value="" selected>Selecione</option>
                                                @foreach ($clients as $client)
                                                    <option
                                                            {{ isset($comercial) && $comercial->client_id == $client->id ? 'selected' : '' }}
                                                            {{ old('client_id') == $client->id ? 'selected' : '' }} value="{{ $client->id }}">
                                                        {{ $client->username }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary btn-submit float-right">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')

    <script>
        $(document).ready(function() {
            if ($('.select--concessionaria').val() != '') {
                concessionaria();
            }

            $('.select--concessionaria').on('change', function() {
                concessionaria();
            });

            $('#select--service').on('change', function() {
                var service = $('#select--service').val();
                var concessionaria = $('#select--concessionaria').val();
                var request = `{{ Request::input('service_id') }}`
                if (($(this).val() != null && $(this).val() != '' && request == '')) {
                    //window.location.href = BASE_URL + '/l/comercial/create?concessionaria_id='+concessionaria+'&service_id='+service;
                }
            })
        })

        function concessionaria() {
            var concessionaria = $('.select--concessionaria').val();
            var $selectService = $('#select--service');
            $('#select--service').empty().trigger('change');
            if (concessionaria != '') {
                var url = "{{ route('concessionaria.service.all', ':id') }}";
                url = url.replace(':id', concessionaria);
                $.ajax({
                    url: url,
                    type: "GET",
                    ajax: true,
                    dataType: "JSON",
                    success: function(j) {
                        var platform = `{{ isset($comercial) ? $comercial->service_id : '' }}`;
                        var input = `{{ Request::input('service_id') }}`;

                        $.each(j.data, function(k, field) {
                            var newOption = new Option(field.name, field.id, false, false);
                            $('#select--service').append(newOption);
                        });

                        var newOption = new Option('Selecione', '', true, true);
                        $('#select--service').append(newOption).trigger('change');

                        $('#select--service').data('placeholder', 'Selecione');
                        $('#select--service').select2();

                        if (input != '') {
                            $('#select--service').val(input).trigger('change');
                        }

                        if (platform != '') {
                            $selectService.val(platform);
                            $selectService.trigger('change');
                        }
                    },
                });
            }
        }
    </script>
@append
