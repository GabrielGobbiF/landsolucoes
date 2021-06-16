@extends("app")

@section('title', 'Comercial - ' . ucfirst($comercial->razao_social))

@section('content')
    <div class="box">
        <div class='box-body pd-25'>
            @if ($financeiro)
                <ul class="nav nav-pills" id="v-tab" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-tab="comercial" id="v-dados" data-toggle="tab" href="#dados" role="tab" aria-selected="true">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Dados da Proposta</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-tab="comercial" id="v-financeiro" data-toggle="tab" href="#financeiro" role="tab" aria-selected="false">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Métodos de Pagamento</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-tab="comercial"  id="v-iso" data-toggle="tab" href="#iso" role="tab" aria-selected="false">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">ISO</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content pd-t-20">
                    <div class="tab-pane active" id="dados" role="tabpanel">
                        <form role="form-update-comercial" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('comercial.update', $comercial->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="box box-default box-solid">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Dados</h3>
                                    </div>
                                    <div class="box-body">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="input--razao_social">Nome da Obra</label>
                                                    <input type="text" name="razao_social" class="form-control @error('razao_social') is-invalid @enderror" id="input--razao_social"
                                                        value="{{ $comercial->razao_social ?? old('razao_social') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="select--concessionaria" class="@error('concessionaria_id') is-invalid-label @enderror">Concessionária</label>
                                                    <input type="text" name="concessionaria_id" class="form-control" readonly disabled id="input--concessionaria_id"
                                                        value="{{ $comercial->concessionaria->name }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="select--service" class="@error('service_id') is-invalid-label @enderror">Tipo de Obra/Serviço</label>

                                                    <input type="text" name="concessionaria_id" class="form-control" readonly disabled id="input--concessionaria_id"
                                                        value="{{ $comercial->concessionaria->name }}">
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
                                                    <input type="text" name="client-id" class="form-control" readonly disabled id="input--client-id"
                                                        value="{{ $comercial->client->company_name }}">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="build_at">Data</label>
                                                    <input type="text" class="form-control date @error('build_at') is-invalid @enderror" name="build_at" id="input--build_at"
                                                        value="{{ isset($comercial) ? dataLimpa($comercial->build_at) : date('d/m/Y') }} {{ old('build_at') ?? date('d/m/Y') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="build_at">Descrição da Obra</label>
                                                    <textarea name="description" id="textarea-description" cols="5" rows="2"
                                                        class="form-control @error('description') is-invalid @enderror">{{ $comercial->description ?? old('description') }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="participantes">Participantes</label>
                                                    <input type="text" class="form-control @error('viabilizacao.participantes') is-invalid @enderror" name="viabilizacao[participantes]"
                                                        id="input--participantes"
                                                        value="{{ isset($comercial) && $comercial->viabilizacao->participantes ? $comercial->viabilizacao->participantes : old('viabilizacao.participantes') }}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                        </form>
                    </div>
                    <div class="tab-pane" id="financeiro" role="tabpanel">
                        <form role="form-update-financeiro-comercial" action="{{ route('comercial.update.financeiro', $comercial->id) }}" method="POST">
                            @csrf
                            @include('pages.painel.obras.comercial.financeiro.index')
                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                        </form>
                    </div>
                    <div class="tab-pane" id="iso" role="tabpanel">
                        <form role="form-update-comercial" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('comercial.update', $comercial->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
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
                                                        <input type="checkbox" class="custom-control-input" value="sim" name="viabilizacao[elaboracao]" id="elaboracao"
                                                            {{ isset($comercial) && $comercial->viabilizacao->elaboracao == 'sim' ? 'checked' : '' }}
                                                            {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="elaboracao">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input type="text" class="form-control" name="viabilizacao[elaboracao_comentario]" id="elaboracao_comentario"
                                                        value="{{ isset($comercial) ? $comercial->viabilizacao->elaboracao_comentario : old('viabilizacao.elaboracao_comentario.') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Atende os requisitos do sitema de Gestão de Qualidade?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" value="sim" name="viabilizacao[qualidade]" id="qualidade"
                                                            {{ isset($comercial) && $comercial->viabilizacao->qualidade == 'sim' ? 'checked' : '' }}
                                                            {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="qualidade">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input type="text" class="form-control" name="viabilizacao[qualidade_comentario]" id="qualidade_comentario"
                                                        value="{{ isset($comercial) ? $comercial->viabilizacao->qualidade_comentario : old('viabilizacao.qualidade_comentario') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Atende os requisitos do sitema de Gestão de Ambiental?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" value="sim" name="viabilizacao[ambiental]" id="ambiental"
                                                            {{ isset($comercial) && $comercial->viabilizacao->ambiental == 'sim' ? 'checked' : '' }}
                                                            {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="ambiental">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input type="text" class="form-control" name="viabilizacao[ambiental_comentario]" id="ambiental_comentario"
                                                        value="{{ isset($comercial) ? $comercial->viabilizacao->ambiental_comentario : old('viabilizacao.ambiental_comentario') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Atende os requisitos de Saúde e Segurança?</label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" value="sim" name="viabilizacao[seguranca_via]" id="seguranca_via"
                                                            {{ isset($comercial) && $comercial->viabilizacao->seguranca_via == 'sim' ? 'checked' : '' }}
                                                            {{ !isset($comercial) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="seguranca_via">Sim</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <input type="text" class="form-control" name="viabilizacao[seguranca_comentario]" id="seguranca_comentario"
                                                        value="{{ isset($comercial) ? $comercial->viabilizacao->seguranca_comentario : '' }}">
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
                                                    <input type="text" class="form-control" name="viabilizacao[responsavel]" id="responsavel"
                                                        value="{{ isset($comercial) ? $comercial->viabilizacao->responsavel : old('viabilizacao.responsavel') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6 align-self-center">
                                                @foreach (Config::get('constants.status_final_comercial') as $status)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="viabilizacao[viavel]" id="{{ $status['id'] }}" value="{{ $status['id'] }}"
                                                            {{ isset($comercial) && $comercial->viabilizacao->viavel == $status['id'] ? 'checked' : '' }}
                                                            {{ !isset($comercial) && $status['id'] == 'viavel' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{ $status['id'] }}">{{ $status['name'] }}</label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Observações</label>
                                                    <textarea type="text" class="form-control" name="viabilizacao[observacoes]"
                                                        id="observacoes">{{ isset($comercial) ? $comercial->viabilizacao->observacoes : old('viabilizacao.observacoes') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 align-self-center">
                        <h4 class="text-center my-3">Atualize o Financeiro</h4>
                    </div>
                    <form role="form-update-financeiro-comercial" action="{{ route('comercial.update.financeiro', $comercial->id) }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            @include('pages.painel.obras.comercial.financeiro.index')
                            <button type="button" class="btn btn-primary btn-submit float-right">Salvar</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <script async>
        $(document).ready(function() {
            tab = localStorage.getItem('nav-tabs_comercial')
            console.log(tab);
            $('#v-tab a#' + tab).tab('show')
        })

    </script>
@stop
