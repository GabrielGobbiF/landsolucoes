@extends('app')

@section('title', 'Novo Comercial')

@section('content')
    <div class="container">
        <div class="box">
            <div class="box-body">
                <form id="form-driver" role="form-create-comercial" class="needs-validation" novalidate autocomplete="off" action="{{ route('comercial.store') }}"
                      method="POST">
                    @csrf

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
                                            <input id="input--razao_social" type="text" name="razao_social"
                                                   class="form-control @error('razao_social') is-invalid @enderror"
                                                   value="{{ $comercial->razao_social ?? old('razao_social') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="select--concessionaria"
                                                   class="@error('concessionaria_id') is-invalid-label @enderror">Concessionária</label>
                                            <select id="select--concessionaria" name="concessionaria_id"
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
                                            <select id="select--service" name="service_id" data-placeholder="Selecione a Concessionaria"
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

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-default box-solid">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">Descrição</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="select--client" class="@error('client_id') is-invalid-label @enderror">Cliente</label>
                                            <select id="select--client" name="client_id" class="form-control select2">
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

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="build_at">Data</label>
                                            <input id="input--build_at" type="text" class="form-control date @error('build_at') is-invalid @enderror"
                                                   name="build_at"
                                                   value="{{ isset($comercial) ? dataLimpa($comercial->build_at) : date('d/m/Y') }} {{ old('build_at') ?? date('d/m/Y') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="build_at">Descrição da Obra</label>
                                            <textarea id="textarea-description" name="description" cols="5" rows="2" class="form-control @error('description') is-invalid @enderror">{{ $comercial->description ?? old('description') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="participantes">Participantes</label>
                                            <input id="input--participantes" type="text"
                                                   class="form-control @error('viabilizacao.participantes') is-invalid @enderror"
                                                   name="viabilizacao[participantes]"
                                                   value="{{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->participantes ? $comercial->viabilizacao->participantes : old('viabilizacao.participantes') }}">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-default box-solid">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">Questões Avaliadas</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Possui Todas as informações necessárias para Elaboração da Proposta?</label>
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input id="elaboracao" type="checkbox" class="custom-control-input" value="sim"
                                                       name="viabilizacao[elaboracao]"
                                                       {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->elaboracao == 'sim' ? 'checked' : '' }}
                                                       {{ !isset($comercial) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="elaboracao">Sim</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Comentarios</label>
                                            <input id="elaboracao_comentario" type="text" class="form-control" name="viabilizacao[elaboracao_comentario]"
                                                   value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->elaboracao_comentario : old('viabilizacao.elaboracao_comentario.') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Atende os requisitos do sitema de Gestão de Qualidade?</label>
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input id="qualidade" type="checkbox" class="custom-control-input" value="sim"
                                                       name="viabilizacao[qualidade]"
                                                       {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->qualidade == 'sim' ? 'checked' : '' }}
                                                       {{ !isset($comercial) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="qualidade">Sim</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Comentarios</label>
                                            <input id="qualidade_comentario" type="text" class="form-control" name="viabilizacao[qualidade_comentario]"
                                                   value="{{ isset($comercial) ? $comercial->viabilizacao->qualidade_comentario : old('viabilizacao.qualidade_comentario') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Atende os requisitos do sitema de Gestão de Ambiental?</label>
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input id="ambiental" type="checkbox" class="custom-control-input" value="sim"
                                                       name="viabilizacao[ambiental]"
                                                       {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->ambiental == 'sim' ? 'checked' : '' }}
                                                       {{ !isset($comercial) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="ambiental">Sim</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Comentarios</label>
                                            <input id="ambiental_comentario" type="text" class="form-control" name="viabilizacao[ambiental_comentario]"
                                                   value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->ambiental_comentario : old('viabilizacao.ambiental_comentario') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Atende os requisitos de Saúde e Segurança?</label>
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input id="seguranca_via" type="checkbox" class="custom-control-input" value="sim"
                                                       name="viabilizacao[seguranca_via]"
                                                       {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->seguranca_via == 'sim' ? 'checked' : '' }}
                                                       {{ !isset($comercial) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="seguranca_via">Sim</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Comentarios</label>
                                            <input id="seguranca_comentario" type="text" class="form-control" name="viabilizacao[seguranca_comentario]"
                                                   value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->seguranca_comentario : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-default box-solid">
                        <div class="col-md-12">
                            <div class="box-header with-border">
                                <h3 class="box-title">Status Final</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Responsável</label>
                                            <input id="responsavel" type="hidden" class="form-control" name="viabilizacao[responsavel]"
                                                   value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->responsavel : old('viabilizacao.responsavel') }}">

                                            <select id="select--reponsavel_id" name="viabilizacao[responsavel_id]"
                                                    class="form-control select2 select--reponsavel_id @error('reponsavel_id') is-invalid @enderror">
                                                <option value="" selected>Selecione</option>
                                                @foreach (users() as $user)
                                                    <option {{ isset($comercial) && $comercial->viabilizacao->responsavel_id == $user->id ? 'selected' : '' }}
                                                            {{ old('viabilizacao[reponsavel_id]') == $user->id ? 'selected' : '' }}
                                                            {{ Request::input('viabilizacao[reponsavel_id]') == $user->id ? 'selected' : '' }}
                                                            value="{{ $user->id }}"> {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 align-self-center">
                                        @foreach (Config::get('constants.status_final_comercial') as $status)
                                            <div class="form-check form-check-inline">
                                                <input id="{{ $status['id'] }}" class="form-check-input" type="radio" name="viabilizacao[viavel]"
                                                       value="{{ $status['id'] }}"
                                                       {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->viavel == $status['id'] ? 'checked' : '' }}
                                                       {{ !isset($comercial) && $status['id'] == 'viavel' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $status['id'] }}">{{ $status['name'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Observações</label>
                                            <textarea id="observacoes" type="text" class="form-control" name="viabilizacao[observacoes]">{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->observacoes : old('viabilizacao.observacoes') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary btn-submit float-right">Avançar Financeiro</button>
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

