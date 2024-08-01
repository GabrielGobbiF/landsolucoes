@csrf
@php
    $tab = isset($tab) ? false : 'show active';

@endphp
<div class="row">
    <div class="col-md-2 {{ $tab ? 'd-none' : '' }}">
        <div id="v-tab" class="nav flex-column nav-pills" data-tab="comercial" role="tablist" aria-orientation="vertical">
            <a id="v-dados-tab" class="nav-link mb-2 active" data-tab="comercial" data-toggle="pill" href="#v-dados" role="tab" aria-controls="v-dados"
               aria-selected="false">Dados</a>
            <a id="v-financeiro-tab" class="nav-link mb-2" data-tab="comercial" data-toggle="pill" href="#v-financeiro" role="tab"
               aria-controls="v-financeiro" aria-selected="false">Financeiro</a>
            <a id="v-iso-tab" class="nav-link mb-2" data-tab="comercial" data-toggle="pill" href="#v-iso" role="tab" aria-controls="v-iso"
               aria-selected="true">ISO</a>
        </div>
    </div>
    <div class="col-md-{{ $tab ? '12' : '10' }}">
        <div id="v-tabContent" class="tab-content text-muted mt-4 mt-md-0">
            <div id="v-dados" class="tab-pane fade show active" role="tabpanel" aria-labelledby="v-dados-tab">

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
                                        @if (!$edit)
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
                                        @else
                                            <input id="input--concessionaria_id" type="text" name="concessionaria_id" class="form-control" readonly disabled
                                                   value="{{ $comercial->concessionaria->name }}">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="select--service" class="@error('service_id') is-invalid-label @enderror">Tipo de Obra/Serviço</label>
                                        @if (!$edit)
                                            <select id="select--service" name="service_id" data-placeholder="Selecione a Concessionaria"
                                                    class="form-control select2"></select>
                                        @else
                                            <input id="input--concessionaria_id" type="text" name="concessionaria_id" class="form-control" readonly disabled
                                                   value="{{ $comercial->concessionaria->name }}">
                                        @endif
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
                                        @if (!$edit)
                                            <select id="select--client" name="client_id" class="form-control select2">
                                                <option value="" selected>Selecione</option>
                                                @foreach ($clients as $client)
                                                    <option
                                                            {{ isset($comercial) && $comercial->client_id == $client->id ? 'selected' : '' }}
                                                            {{ old('client_id') == $client->id ? 'selected' : '' }} value="{{ $client->id }}">
                                                        {{ $client->company_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input id="input--concessionaria_id" type="text" name="concessionaria_id" class="form-control" readonly disabled
                                                   value="{{ $comercial->concessionaria->name }}">
                                        @endif
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
            </div>

            <div id="v-iso" class="tab-pane fade {{ $tab }}" role="tabpanel" aria-labelledby="v-iso-tab">
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
                                               value="{{ isset($comercial) ? $comercial->viabilizacao->elaboracao_comentario : old('viabilizacao.elaboracao_comentario.') }}">
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
                                               value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->qualidade_comentario : old('viabilizacao.qualidade_comentario') }}">
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
                                        <input id="responsavel" type="text" class="form-control" name="viabilizacao[responsavel]"
                                               value="{{ isset($comercial) && isset($comercial->viabilizacao) ? $comercial->viabilizacao->responsavel : old('viabilizacao.responsavel') }}">



                                    </div>
                                </div>

                                <div class="col-md-6 align-self-center">
                                    @foreach (Config::get('constants.status_final_comercial') as $status)
                                        <div class="form-check form-check-inline">
                                            <input id="{{ $status['id'] }}" class="form-check-input" type="radio" name="viabilizacao[viavel]"
                                                   value="{{ $status['id'] }}"
                                                   {{ isset($comercial) && isset($comercial->viabilizacao) && $comercial->viabilizacao->viavel == $status['id'] ? 'checked' : '' }}
                                                   {{ !isset($comercial) && isset($comercial->viabilizacao) && $status['id'] == 'viavel' ? 'checked' : '' }}>
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
            </div>

            @if ($edit)
                <div id="v-financeiro" class="tab-pane fade {{ $tab }}" role="tabpanel" aria-labelledby="v-financeiro-tab">
                    @include('pages.painel.obras.comercial.financeiro.index')
                </div>
            @endif
        </div>
    </div>
</div>
