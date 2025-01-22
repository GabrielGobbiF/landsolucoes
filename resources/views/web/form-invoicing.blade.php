<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados para Faturamento</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="js-base_url" content="{{ env('APP_URL') }}">
    <meta name="js-base_url_api" content="{{ env('APP_URL_API') }}">
    <meta name="url" content="{{ str_replace([Request::getQueryString(), '?'], '', Request::getPathInfo()) }}">
    <link id="bootstrap-style" href="{{ _mix('panel/css/bootstrap.css') }}" rel="stylesheet">
    <link id="app-style" href="{{ _mix('panel/css/app.css') }}" rel="stylesheet">
    <script src="{{ _mix('panel/js/bootstrap.js') }}"></script>

    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }



        .form-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #1d4038;
            color: #ffffff;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .btn-custom {
            background-color: #1d4038;
            color: #ffffff;
            border: none;
        }

        .btn-custom:hover {
            background-color: #143028;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-xl-6">
                <div class="form-container">

                    @if (auth()->check())
                        <div class="card-body">
                            <a href="{{ route('admin.clients.form.invoicing') }}" class="">Ver todas</a>
                        </div>
                    @endif

                    <div class="card-body">
                        <img class="card-img-top" src="{{ asset('panel/images/logo.png') }}" alt="CenaLogo" style="width: 200px" />
                        <h5 class=" my-5">Dados para Faturamento</h5>
                        <form action="/clients/form-invoicing" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- CNPJ -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputCNPJ">CNPJ</label>
                                <div class="col-sm-8">
                                    <input id="inputCNPJ" required name="cnpj" class="form-control" type="text"
                                           value="{{ $contato->cnpj ?? old('cnpj') }}" required />
                                </div>
                            </div>

                            <!-- Inscrição Estadual -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputInscricaoEstadual">Inscrição Estadual</label>
                                <div class="col-sm-8">
                                    <input id="inputInscricaoEstadual" required name="inscricao_estadual" class="form-control" type="text"
                                           value="{{ $contato->inscricao_estadual ?? old('inscricao_estadual') }}" />
                                </div>
                            </div>

                            <!-- Inscrição Municipal -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputInscricaoMunicipal">Inscrição Municipal</label>
                                <div class="col-sm-8">
                                    <input id="inputInscricaoMunicipal" required name="inscricao_municipal" class="form-control" type="text"
                                           value="{{ $contato->inscricao_municipal ?? old('inscricao_municipal') }}" />
                                </div>
                            </div>

                            <!-- Razão Social -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputRazaoSocial">Razão Social</label>
                                <div class="col-sm-8">
                                    <input id="inputRazaoSocial" required name="razao_social" class="form-control" type="text"
                                           value="{{ $contato->razao_social ?? old('razao_social') }}" required />
                                </div>
                            </div>

                            <!-- Nome Fantasia -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputNomeFantasia">Nome Fantasia</label>
                                <div class="col-sm-8">
                                    <input id="inputNomeFantasia" required name="nome_fantasia" class="form-control" type="text"
                                           value="{{ $contato->nome_fantasia ?? old('nome_fantasia') }}" />
                                </div>
                            </div>

                            <!-- Endereço completo de cobrança -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputEnderecoCobranca">Endereço completo de cobrança</label>
                                <div class="col-sm-8">
                                    <textarea id="inputEnderecoCobranca" required name="endereco_cobranca" class="form-control" rows="3">{{ $contato->endereco_cobranca ?? old('endereco_cobranca') }}</textarea>
                                </div>
                            </div>

                            <!-- E-mail do responsável financeiro -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputEmailFinanceiro">E-mail do responsável financeiro</label>
                                <div class="col-sm-8">
                                    <input id="inputEmailFinanceiro" required name="email_financeiro" class="form-control" type="email"
                                           value="{{ $contato->email_financeiro ?? old('email_financeiro') }}" />
                                </div>
                            </div>

                            <!-- E-mail do engenheiro responsável -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputEmailEngenheiro">E-mail do engenheiro responsável</label>
                                <div class="col-sm-8">
                                    <input id="inputEmailEngenheiro" required name="email_engenheiro" class="form-control" type="email"
                                           value="{{ $contato->email_engenheiro ?? old('email_engenheiro') }}" />
                                </div>
                            </div>

                            <!-- Telefones -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputTelefones">Telefones</label>
                                <div class="col-sm-8">
                                    <input id="inputTelefones" required name="telefones" class="form-control" type="text"
                                           value="{{ $contato->telefone ?? old('telefone') }}" />
                                </div>
                            </div>

                            <!-- Nome da obra -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputNomeObra">Nome da obra</label>
                                <div class="col-sm-8">
                                    <input id="inputNomeObra" required name="nome_obra" class="form-control" type="text"
                                           value="{{ $contato->nome_obra ?? old('nome_obra') }}" />
                                </div>
                            </div>

                            <!-- Endereço completo da obra -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputEnderecoObra">Endereço completo da obra</label>
                                <div class="col-sm-8">
                                    <textarea id="inputEnderecoObra" required name="endereco_obra" class="form-control" rows="3">{{ $contato->endereco_obra ?? old('endereco_obra') }}</textarea>
                                </div>
                            </div>

                            <!-- CNO -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputCNO">CNO</label>
                                <div class="col-sm-8">
                                    <input id="inputCNO" required name="cno" class="form-control" type="text"
                                           value="{{ $contato->cno ?? old('cno') }}" />
                                </div>
                            </div>

                            <!-- SFOBRAS -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">SFOBRAS</label>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input id="sfobrasSim" required class="form-check-input" type="radio" name="sfobras" value="sim"
                                               {{ (isset($contato) && $contato->sfobras == 'sim') || old('sfobras') == 'sim' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sfobrasSim">Sim</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="sfobrasNao" required class="form-check-input" type="radio" name="sfobras" value="nao"
                                               {{ (isset($contato) && $contato->sfobras == 'nao') || old('sfobras') == 'nao' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sfobrasNao">Não</label>
                                    </div>
                                </div>
                            </div>

                            <!-- CNO -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputn_contrato_proposta">Nº do contrato ou proposta</label>
                                <div class="col-sm-8">
                                    <input id="inputn_contrato_proposta" required name="n_contrato_proposta" class="form-control" type="text"
                                           value="{{ $contato->n_contrato_proposta ?? old('n_contrato_proposta') }}" />
                                </div>
                            </div>

                            <!-- Retenção contratual -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputn_pedido_os">Nº pedido ou OS</label>
                                <div class="col-sm-8">
                                    <input id="inputn_pedido_os" required name="n_pedido_os" class="form-control" type="text"
                                           value="{{ $contato->n_pedido_os ?? old('n_pedido_os') }}" />
                                </div>
                            </div>

                            <!-- Retenção contratual -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputRetencaoContratual">Terá retenção contratual? (Percentual sobre valor
                                    bruto)</label>
                                <div class="col-sm-8">
                                    <input id="inputRetencaoContratual" required name="retencao_contratual" class="form-control" type="text"
                                           value="{{ $contato->retencao_contratual ?? old('retencao_contratual') }}" />
                                </div>
                            </div>

                            <!-- isenção de ISS -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label">A obra possui isenção de ISS?</label>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input id="isencao_issSim" required class="form-check-input" type="radio" name="isencao_iss" value="sim"
                                               {{ (isset($contato) && $contato->isencao_iss == 'sim') || old('isencao_iss') == 'sim' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="isencao_issSim">Sim</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="isencao_issNao" required class="form-check-input" type="radio" name="isencao_iss" value="nao"
                                               {{ (isset($contato) && $contato->isencao_iss == 'nao') || old('isencao_iss') == 'nao' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="isencao_issNao">Não</label>
                                    </div>
                                </div>
                            </div>

                            <div id="liberacao_prefeitura_div" class="card text-start d-none">
                                <div class="card-body">
                                    <div>
                                        <h6 class="card-title">Anexar liberação da prefeitura:</h6>
                                        <input id="liberacao_prefeitura" type="file" name="upload[]" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Incua qualquer particularidade relevante não mencionada anteriormente:-->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputObservations">Incua qualquer particularidade relevante não mencionada
                                    anteriormente:
                                </label>
                                <div class="col-sm-8">
                                    <textarea id="inputObservations" required name="observations" class="form-control" rows="3">{{ $contato->observations ?? old('observations') }}</textarea>
                                </div>
                            </div>

                            <!-- Data do preenchimento -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputDataPreenchimento">Data do preenchimento</label>
                                <div class="col-sm-8">
                                    <input id="inputDataPreenchimento" required name="data_preenchimento" class="form-control" type="date"
                                           value="{{ $contato->data_preenchimento ?? (old('data_preenchimento') ?? formatDateAndTime(now(), 'd/m/Y')) }}" />
                                </div>
                            </div>

                            <!-- responsavel preenchimento -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputResponsible">Responsável pelo Preenchimento </label>
                                <div class="col-sm-8">
                                    <input id="inputResponsible" required name="responsible_preenchimento" class="form-control" type="text"
                                           value="{{ $contato->responsible_preenchimento ?? old('responsible_preenchimento') }}" />
                                </div>
                            </div>

                            <!-- email responsavel preenchimento -->
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label" for="inputEmail_responsavel_medicao">Email do Responsável pelo preenchimento </label>
                                <div class="col-sm-8">
                                    <input id="inputEmail_responsavel_medicao" required name="email_responsavel_medicao" class="form-control" type="text"
                                           value="{{ $contato->email_responsavel_medicao ?? old('email_responsavel_medicao') }}" />
                                </div>
                            </div>

                            <div class="row  ft10" style="margin-top: 4rem">
                                <div class="col-12">
                                    <h4 class="mb-3">Informações importantes:</h4>
                                    <p class="m-0">As notas fiscais da Land Soluções serão emitidas sob os Código do Serviço ou CNAE relacionados
                                        abaixo:</p>
                                    <p class="m-0">• 03158 - Datilografia, digitação, estenografia, expediente, secretaria em geral.</p>
                                    <p class="m-0">• 01023 - Execução, por administração, empreitada.</p>
                                    <p class="m-0">Composição da NFe: 30% mão de obra, 70% materiais e equipamentos.</p>
                                </div>
                            </div>

                            <div class="alert alert-danger mt-4" role="alert">
                                <p>*Quailquer outras informações que não constem neste relatório NÃO poderão ser pleiteadas
                                    posteriormente.
                                </p>
                                <hr />
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <button class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ _mix('panel/js/all.js') }}"></script>
    <script src="{{ _mix('panel/js/app.js') }}"></script>

    <script>
        @include('components.toastr')

        $(document).ready(function() {
            // Esconde ou mostra a div dependendo da escolha do usuário
            $('input[name="isencao_iss"]').on('change', function() {
                if ($('#isencao_issSim').is(':checked')) {
                    $('#liberacao_prefeitura_div').removeClass('d-none');
                    $('#liberacao_prefeitura').removeAttr('readonly');
                } else {
                    $('#liberacao_prefeitura_div').addClass('d-none');
                    $('#liberacao_prefeitura').add('readonly');
                }
            });
        });
    </script>
</body>

</html>
