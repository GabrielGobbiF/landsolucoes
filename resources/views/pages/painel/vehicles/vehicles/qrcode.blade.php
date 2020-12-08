<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Veiculos Land</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        var BASE = `{{ env('APP_URL') }}`;

    </script>

    <script src="{{ asset('mobile/js/app.js') }}"></script>

    <style>
        .select2-selection__rendered {
            line-height: 31px !important;
        }

        .select2-container .select2-selection--single {
            height: 35px !important;
        }

        .select2-selection__arrow {
            height: 34px !important;
        }

    </style>

</head>

<body>
    <div id="app">
        <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column " style="    max-width: 42em; height: 100vh;">
            <header class="masthead mb-3 mt-2">
                <div class="text-center">
                    <h4 class="cover-heading ">{{ $vehicle->name }}</h4>
                    <span>{{ $vehicle->board }}</span>
                </div>
            </header>

            <main role="main">
                <div class="mb-1 text-center"><span class="mb-2">Clique para selecionar</span></div>

                <div class="justify-content-center d-flex mb-5">
                    <button class="btn btn-primary btn-atividade ml-1 p-2" data-type="atividade">Nova Atividade</button>
                    <button class="btn btn-primary btn-atividade ml-1 p-2" data-type="manutencao">Nova Manutenção</button>
                    <button class="btn btn-primary btn-atividade ml-1 p-2" data-type="abastecimento">Novo Abastecimento</button>
                </div>

                <div class="d-none" id="dados">

                    <div class="row dados_type manutencao">
                        <div class="col-md-12 manutencao d-none">
                            <div class="form-group text-center">
                                <label for="input--tipo_manutencao ">Tipo de Manutenção</label>
                                <!-- <select class="form-control select2" name="tipo_manutencao" required id="input--tipo_manutencao">
                                    <option value="">Selecione</option>
                                    <option value="mecanico">Mêcanico</option>
                                    <option value="iluminacao">Iluminação</option>
                                    <option value="avarias">Avarias</option>
                                </select>-->
                                <div class="justify-content-center d-flex mb-5">
                                    <button class="btn btn-primary btn-manutencao ml-1 p-2" data-type="mecanico">Mêcanico</button>
                                    <button class="btn btn-primary btn-manutencao ml-1 p-2" data-type="iluminacao">Iluminação</button>
                                    <button class="btn btn-primary btn-manutencao ml-1 p-2" data-type="avarias">Avarias</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 div--manutencao d-none">
                            <div class="form-group text-center">
                                <label for="input--tipo_manutencao_descricao">Nome da Manutenção</label>
                                <div class="justify-content-center d-flex mb-5" id="select--tipo_manutencao_descricao"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row dados_type abastecimento d-none">
                        <div class="col-md-12 abastecimento">
                            <label for="image">Foto da Nota</label>
                            <div class="custom-file">
                                <input lang="pt" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image"
                                    value="{{ $vehicle_activities->nota_fiscal ?? old('image') }}">
                                <label class="custom-file-label" for="customFile"></label>
                            </div>
                        </div>
                    </div>


                    <div class="row dados_type atividade d-none">
                        <div class="col-md-12 atividade d-none">
                            <div class="form-group text-center">
                                <label for="input--tipo_atividade ">Tipo de Atividade</label>
                                <div class="justify-content-center d-flex mb-5">
                                    <button class="btn btn-primary btn-tipo_atividade ml-1 p-2" data-type="saida">Saida</button>
                                    <button class="btn btn-primary btn-tipo_atividade ml-1 p-2" data-type="retorno">Retorno</button>
                                    <button class="btn btn-primary btn-tipo_atividade ml-1 p-2" data-type="cliente">Cliente</button>
                                    <button class="btn btn-primary btn-tipo_atividade ml-1 p-2" data-type="obra">Obra</button>
                                    <button class="btn btn-primary btn-tipo_atividade ml-1 p-2" data-type="outros">Outros</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 div--nome_atividade d-none">
                            <div class="form-group text-center">
                                <label for="input--tipo_atividade_descricao">Nome da Atividade</label>
                                <div class="justify-content-center d-flex mb-5" id="select--tipo_atividade_descricao"></div>
                            </div>
                        </div>
                    </div>

                    <div class="obra d-none dados_type row mb-2">
                        <div class="col-md-12">
                            <div class="form-group text-center">
                                <label for="input--obra ">Obra</label>
                                <!-- <select class="form-control select2" name="obra" required id="input--obra">
                                    <option value="">Selecione</option>
                                    <option value="mecanico">Mêcanico</option>
                                    <option value="iluminacao">Iluminação</option>
                                    <option value="avarias">Avarias</option>
                                </select>-->

                                <select class="form-control" id="obra--select">

                                </select>

                            </div>
                        </div>

                        <div class="col-md-12 mt-3 mb-3 d-none text-center div--endereco_obra">
                            <span class="endereco_obra"></span>
                        </div>
                    </div>

                    <div class="descricao d-none row dados_type">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input--km_start">Kilometragem do carro (apenas numeros)</label>
                                <input type="number" name="km_start" onkeyup="description()" class="form-control @error('km_start') is-invalid @enderror" id="input--km_start"
                                    value="{{ $ultimaKM ?? old('km_start') }}"
                                    autocomplete="off">
                                <input type="hidden" name="ultimaKM" value="{{ $ultimaKM ?? old('km_start') }}" autocomplete="off">
                                <div class="invalid-feedback">
                                    KM precisa ser maior que o KM Atual
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input--description">Descrição</label>
                                <textarea type="text" name="description" onkeyup="description()" placeholder="Digite um breve detalhamento"
                                    class="form-control @error('description') is-invalid @enderror"
                                    id="input--description"
                                    autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center d-none mt-2" id="div--button-submit">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>

<script>
    function description() {
        $('#div--button-submit').addClass('d-none');
        if ($('#input--description').val() != '' && $('#input--km_start').val() != '') {
            $('#div--button-submit').removeClass('d-none');
        }
    }

    $('#image').on('change', function() {
        $('#div--button-submit').addClass('d-none');
        if ($('#image').val() != '') {
            $('#div--button-submit').removeClass('d-none');
        }
    })

    $('.btn-atividade').on('click', function() {

        $('.btn-atividade').removeClass('btn-success');
        $('.btn-atividade').addClass('btn-primary');

        $('.btn-manutencao').removeClass('btn-success');
        $('.btn-manutencao').addClass('btn-primary');

        $('.btn-tipo_atividade').removeClass('btn-success');
        $('.btn-tipo_atividade').addClass('btn-primary');

        $('#dados').addClass('d-none');
        $('.dados_type').addClass('d-none');
        $('.descricao').addClass('d-none');
        $('#div--button-submit').addClass('d-none');
        $('.div--manutencao').addClass('d-none');

        $(this).toggleClass('btn-primary');
        $(this).toggleClass('btn-success');

        var type = $(this).attr('data-type');

        switch (type) {
            case 'abastecimento':
                $('.abastecimento').removeClass('d-none');
                break;

            case 'manutencao':
                $('.manutencao').removeClass('d-none');
                break;

            case 'atividade':
                $('.atividade').removeClass('d-none');
                break;

            default:
                break;

        }
        $('#dados').removeClass('d-none');
    })


    $('.btn-manutencao').on('click', function() {

        $('.btn-manutencao').removeClass('btn-success');
        $('.btn-manutencao').addClass('btn-primary');

        $(this).toggleClass('btn-primary');
        $(this).toggleClass('btn-success');

        $('.div--manutencao').addClass('d-none');
        $('.descricao').addClass('d-none');

        var coluna = $(this).attr('data-type');
        var options = '';

        if (coluna != 0) {

            switch (coluna) {
                case 'mecanico':

                    options += '<button class="btn btn-primary btn-nome_manutencao ml-1 p-2" onclick="changetype(this)" data-type="oleo">Óleo</button>'
                    options += '<button class="btn btn-primary btn-nome_manutencao ml-1 p-2" onclick="changetype(this)" data-type="motor">Motor</button>'
                    options += '<button class="btn btn-primary btn-nome_manutencao ml-1 p-2" onclick="changetype(this)" data-type="revisao">Revisão</button>'

                    break;

                case 'iluminacao':

                    options += '<button class="btn btn-primary btn-nome_manutencao ml-1 p-2" onclick="changetype(this)" data-type="farois">Farois</button>'
                    options += '<button class="btn btn-primary btn-nome_manutencao ml-1 p-2" onclick="changetype(this)" data-type="fusiveis">Fusiveis</button>'
                    break;

                case 'avarias':
                    options += '<button class="btn btn-primary btn-nome_manutencao ml-1 p-2" onclick="changetype(this)" data-type="amassados">Amassados</button>'
                    options += '<button class="btn btn-primary btn-nome_manutencao ml-1 p-2" onclick="changetype(this)" data-type="riscos">Riscos</button>'
                    break;

                default:
                    options += '';
                    break;
            }

            options += '<button class="btn btn-primary btn-nome_manutencao ml-1 p-2" onclick="changetype(this)" data-type="outros">Outros</button>';

            $('#select--tipo_manutencao_descricao').html(options).show();
            $('.div--manutencao').removeClass('d-none');
        }
    })

    $('#input--tipo_manutencao').on('change', function() {
        $('.div--manutencao').addClass('d-none');
        $('.descricao').addClass('d-none');

        var titulo = $('#input--tipo_manutencao').select2('data');
        var coluna = titulo[0].id;
        var options = '<option value="">Selecione</option>';

        if (coluna != 0) {

            switch (coluna) {
                case 'mecanico':
                    options += '<option value="oleo">Óleo</option>';
                    options += '<option value="motor">Motor</option>';
                    options += '<option value="revisao">Revisão</option>';
                    break;

                case 'iluminacao':
                    options += '<option value="farois">Farois</option>';
                    options += '<option value="fusiveis">Fusiveis</option>';
                    break;

                case 'avarias':
                    options += '<option value="farois">Farois</option>';
                    options += '<option value="fusiveis">Fusiveis</option>';

                    options += '<option value="amassados">Amassados</option>';
                    options += '<option value="riscos">Riscos</option>';
                    break;

                default:
                    options += '<option value="oleo">Óleo</option>';
                    break;
            }
            $('#select--tipo_manutencao_descricao').html(options).show();
            $('.div--manutencao').removeClass('d-none');
        }

    })

    $('.btn-tipo_atividade').on('click', function() {
        $('.descricao').addClass('d-none');
        $('.obra').addClass('d-none');

        $('.btn-tipo_atividade').removeClass('btn-success');
        $('.btn-tipo_atividade').addClass('btn-primary');

        $(this).toggleClass('btn-primary');
        $(this).toggleClass('btn-success');

        var type = $(this).attr('data-type');

        switch (type) {
            case 'saida':

                break;

            case 'obra':
                $('.obra').removeClass('d-none');
                getObra()

            default:
                $('.descricao').removeClass('d-none');
                break;

        }
        $('#dados').removeClass('d-none');
    })

    function changetype(v) {
        $('.btn-nome_manutencao').removeClass('btn-success');
        $('.btn-nome_manutencao').addClass('btn-primary');

        $(v).toggleClass('btn-primary');
        $(v).toggleClass('btn-success');

        $('.descricao').removeClass('d-none');
    }

    function getObra() {
        $('.div--endereco_obra').addClass('d-none');
        $('.endereco_obra').html('').show();

        $("#obra--select").select2({
                placeholder: "Buscar",
                minimumInputLength: 1,
                language: "pt-br",
                formatNoMatches: function() {
                    return "Pesquisa não encontrada";
                },
                inputTooShort: function() {
                    return "Digite para Pesquisar";
                },
                ajax: {
                    url: 'http://www.landsolucoes.com.br/api/getAllObrasTokenUDsddi',
                    dataType: 'json',
                    data: function(term, page) {
                        return {
                            q: term, //search term
                        };
                    },
                    results: function(data, page) {
                        return {
                            results: data.results,
                        };
                    }
                },
                escapeMarkup: function(m) {
                    return m;
                }
            }

        );

        $('#obra--select').on('select2:select', function(e) {

            var titulo = $(this).select2('data');
            var coluna = titulo[0].id;

            $.ajax({
                url: 'http://www.landsolucoes.com.br/api/getEnderecoObraByTokenUDDS',
                type: 'GET',
                data: {
                    id: coluna
                },
                dataType: 'json',
            }).done(function(response) {
                $('.div--endereco_obra').removeClass('d-none');

                html = '<a target="_blank" href="https://www.waze.com/ul?q="' + response.endereco + '> ' + response.endereco + ' </a>';

                $('.endereco_obra').html(html).show();
            });

        });

    }

</script>

</html>
