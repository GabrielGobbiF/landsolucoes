<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link href="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-style">
    <link href="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/dist/css/AdminLTE.min.css" rel="stylesheet" id="app-style">
    <link href="{{ asset('panel/icons/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/icons/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">

    <script src="{{ asset('panel/js/bootstrap.js') }}"></script>

    <script>
        var BASE_URL = `{{ env('APP_URL') }}`;

    </script>

</head>

<body class="fixed skin-blue layout-top-nav" style="background-color: rgb(237, 237, 237); height: auto; min-height: 100%;">
    <div class="wrapper" style="height: auto; min-height: 100%;">

      <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="http://www2.cena.com.br//home" class="navbar-brand"><b>Admin</b>Land</a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>

            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                                <li class=""><a href="http://www2.cena.com.br/usuario">Usuarios <span class="sr-only">(current)</span></a></li>

                                <li class=""><a href="http://www2.cena.com.br/clientes">Clientes <span class="sr-only">(current)</span></a></li>

                                <li class=""><a href="http://www2.cena.com.br/servicos">Serviços <span class="sr-only">(current)</span></a></li>


                                <li class=""><a href="http://www2.cena.com.br/concessionarias">Concessionarias <span class="sr-only">(current)</span></a></li>

                                <li class=""><a href="http://www2.cena.com.br/comercial">Comercial <span class="sr-only">(current)</span></a></li>


                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Obras <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="http://www2.cena.com.br/obras"><i class="fa fa-building-o"></i> Todas</a></li>
                      <li><a href="http://www2.cena.com.br/obras?filtros%5Bconsessionaria%5D=RedeSubterranea"><i class="fa fa-building-o"></i> Rede Subterrânea</a></li>
                      <li><a href="http://www2.cena.com.br/obras?filtros%5Bconsessionaria%5D=etds"><i class="fa fa-building-o"></i> ETDs</a></li>
                      <li><a href="http://www2.cena.com.br/obras?filtros%5Bconsessionaria%5D=enel"><i class="fa fa-building-o"></i> Obr/Ass - Enel</a></li>
                      <li><a href="http://www2.cena.com.br/obras?filtros%5Bconsessionaria%5D=edp"><i class="fa fa-building-o"></i> Obr/Ass - EDP</a></li>

                      <li><a href="http://www2.cena.com.br/obras/relatorio"><i class="fa fa-bar-chart"></i> Relatorio</a></li>
                    </ul>
                  </li>

                <li class="active"><a href="http://app.landsolucoes.com.br/l/arquivos">Arquivos <span class="sr-only">(current)</span></a></li>

                                <li class=""><a href="http://www2.cena.com.br/financeiro"> Financeiro <span class="sr-only">(current)</span></a></li>

                                <li class="active"><a href="http://www2.cena.com.br/veiculos">Veiculos <span class="sr-only">(current)</span></a></li>

              </ul>

            </div>


                        <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                                    <li class="dropdown messages-menu">
                      <a href="http://www2.cena.com.br/notificacao" class="dropdown-toggle drop-notific">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-success notificacao-mensagem fa-blink">114</span>
                      </a>

                    </li>
                                        <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                          <i class="fa fa-fw fa-dollar"></i>
                          <span class="label label-success">9</span>
                        </a>
                        <ul class="dropdown-menu">
                          <li class="header">Total Faturamento Receber: 9</li>
                          <li>
                            <ul class="menu">

                                                                <li>
                                    <a href="http://www2.cena.com.br/financeiro/obra/343?hist=1074&amp;histNota=333">
                                      <h4>
                                        Poste Iluminação Wide                                      <!--<small><i class="fa fa-clock-o"></i> 5 mins</small>-->
                                      </h4>
                                      <p>R$ 13.310,00</p>

                                    </a>
                                  </li>
                                                                <li>
                                    <a href="http://www2.cena.com.br/financeiro/obra/236?hist=737&amp;histNota=335">
                                      <h4>
                                        Vitacon 51 - Baiuca                                      <!--<small><i class="fa fa-clock-o"></i> 5 mins</small>-->
                                      </h4>
                                      <p>R$ 10.425,00</p>

                                    </a>
                                  </li>
                                                                <li>
                                    <a href="http://www2.cena.com.br/financeiro/obra/236?hist=740&amp;histNota=334">
                                      <h4>
                                        Vitacon 51 - Baiuca                                      <!--<small><i class="fa fa-clock-o"></i> 5 mins</small>-->
                                      </h4>
                                      <p>R$ 5.000,00</p>

                                    </a>
                                  </li>
                                                                <li>
                                    <a href="http://www2.cena.com.br/financeiro/obra/226?hist=681&amp;histNota=337">
                                      <h4>
                                        Millennium - Instalação CT                                      <!--<small><i class="fa fa-clock-o"></i> 5 mins</small>-->
                                      </h4>
                                      <p>R$ 10.425,00</p>

                                    </a>
                                  </li>
                                                                <li>
                                    <a href="http://www2.cena.com.br/financeiro/obra/226?hist=679&amp;histNota=337">
                                      <h4>
                                        Millennium - Instalação CT                                      <!--<small><i class="fa fa-clock-o"></i> 5 mins</small>-->
                                      </h4>
                                      <p>R$ 10.425,00</p>

                                    </a>
                                  </li>
                                                                <li>
                                    <a href="http://www2.cena.com.br/financeiro/obra/367?hist=1115&amp;histNota=339">
                                      <h4>
                                        Nex One Consolação                                       <!--<small><i class="fa fa-clock-o"></i> 5 mins</small>-->
                                      </h4>
                                      <p>R$ 20.000,00</p>

                                    </a>
                                  </li>
                                                                <li>
                                    <a href="http://www2.cena.com.br/financeiro/obra/339?hist=1131&amp;histNota=344">
                                      <h4>
                                        Ligação galpões emergencial                                      <!--<small><i class="fa fa-clock-o"></i> 5 mins</small>-->
                                      </h4>
                                      <p>R$ 10.620,00</p>

                                    </a>
                                  </li>
                                                                <li>
                                    <a href="http://www2.cena.com.br/financeiro/obra/332?hist=1061&amp;histNota=NF 000353">
                                      <h4>
                                        Assessoria - São Francesco                                      <!--<small><i class="fa fa-clock-o"></i> 5 mins</small>-->
                                      </h4>
                                      <p>R$ 5.000,00</p>

                                    </a>
                                  </li>
                                                                <li>
                                    <a href="http://www2.cena.com.br/financeiro/obra/291?hist=911&amp;histNota=NF 000356">
                                      <h4>
                                        Remoção de Postes - Tegra                                      <!--<small><i class="fa fa-clock-o"></i> 5 mins</small>-->
                                      </h4>
                                      <p>R$ 7.000,00</p>

                                    </a>
                                  </li>
                                                                                      </ul>
                          </li>
                          <!--<li class="footer"><a href="#">See All Messages</a></li>-->
                        </ul>
                      </li>

                    <li class="dropdown user user-menu">
                      <a href="http://www2.cena.com.br//login/logout">
                        <span class="hidden-xs"> Gabriel</span>
                      </a>
                    </li>

                    <li>
                      <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>

                </ul>
              </div>
                    </div>
        </nav>
      </header>
      <div class="content-wrapper" style="min-height: 574px;">
        <div class="container-fluid">
          <section class="content-header">
            <h1 style="text-align: center;">

              Casd x Câmara Transformadora
            </h1>
          </section>

          <section class="content">


            <div class="modal" id="modalImportar1" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <form id="formDuplicar1" action="http://www2.cena.com.br/concessionarias/duplicarEtapa" method="POST">
                  <input type="hidden" class="form-control" name="id_concessionaria" id="id_concessionaria" value="11" autocomplete="off">
                  <input type="hidden" class="form-control" name="id_servico" id="id_servico" value="1" autocomplete="off">
                  <div class="modal-header">
                      <h2 class="modal-title text-center">Duplicação de "Câmara Transformadora"</h2>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <div class="box-body">
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Concessionaria</label>
                                      <select class="form-control select2 concessionaria_select select2-hidden-accessible" style="width: 100%;" name="concessionaria" id="concessionaria" aria-hidden="true" required="" tabindex="-1">
                                          <option value="">selecione</option>
                                                                                      <option value="1">ENEL Distribuidora</option>
                                                                                      <option value="2">EDP Bandeirantes</option>
                                                                                      <option value="3">CPFL ENERGIA</option>
                                                                                      <option value="4">ELEKTRO</option>
                                                                                      <option value="9">ENEL - Redes Subterrânea Civil</option>
                                                                                      <option value="10">ENEL - ETDs</option>
                                                                                      <option value="11">casd</option>
                                                                              </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-concessionaria-container"><span class="select2-selection__rendered" id="select2-concessionaria-container" title="selecione">selecione</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label>Nome do Serviço</label>
                                      <input type="text" class="form-control" name="sev_nome" id="sev_nome" autocomplete="off">
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <div onclick="formSubmit(1)" class="btn btn-primary">Duplicar</div>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <script>
      function formSubmit(id) {
          $("#formDuplicar" + id).submit();
      }
  </script>
  <div class="col-md-12">
      <div class="box box-default">
          <div class="box-header with-border">
              <i class="fa fa-warning"></i>
              <h3 class="box-title"> Etapas </h3>
              <a type="button" data-toggle="tooltip" title="" data-original-title="Duplicar" class="btn btn-warning pull-right" onclick="openImport(1)"><i class="fa fa-paste"></i></a>
          </div>
          <div class="box-body">
              <div class="row">
                  <div class="col-md-2">
                      <label>Tipo</label>
                      <select class="select2 tipo_etapa select2-hidden-accessible" style="width:100%" id="tipoEtapa" name="tipoEtapa" aria-hidden="true" tabindex="-1">
                          <option selected="" value="0">selecione</option>
                          <option value="concessionaria">Concessionaria</option>
                          <option value="administrativa">Administrativa</option>
                          <option value="obra">Obras</option>
                          <option value="compra">Compras</option>
                          <option value="vistoria">Vistoria</option>
                      </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-tipoEtapa-container"><span class="select2-selection__rendered" id="select2-tipoEtapa-container" title="Concessionaria">Concessionaria</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                  </div>
              </div>
              <br>
              <div class="row" id="rowEtapa" style="">
                  <div class="col-xs-12">
                      <div class="box">
                          <div class="box-header">
                              <h3 class="box-title"> Etapas </h3>

                              <div class="box-tools">

                                  <button class="btn btn-default btn-sm pull-left" onclick="add_etapa()">
                                      <i class="fa fa-fw fa-plus-circle"></i> Novo
                                  </button>
                                  <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                      <input type="text" name="table_search" id="table_search" class="form-control pull-right" placeholder="buscar">
                                      <div class="input-group-btn">
                                          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                      </div>
                                  </div>

                              </div>
                          </div>
                          <div class="box-body table-responsive no-padding" style="    max-height: 293px">
                              <table class="table table-hover">
                                  <tbody>
                                      <tr>
                                          <th style="width: 10%;">Ação</th>
                                          <th style="width: 7%;">#</th>
                                          <th>Etapa</th>
                                          <th>Tipo</th>
                                          <th></th>
                                      </tr>
                                  </tbody>
                                  <tbody id="listEtapa"><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(591, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/591/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>591</td>    <td>Abertura Nota Custo de Rede</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(591)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(379, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/379/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>379</td>    <td>Aceitação Termo de Doação de Ativos Anexo I</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(379)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(562, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/562/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>562</td>    <td>Agendamento assinatura Servidão rede aérea</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(562)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(366, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/366/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>366</td>    <td>Agendamento da Assinatura da Escritura</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(366)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(297, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/297/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>297</td>    <td>Agendar Assinatura Enel e Cliente na Matrícula </td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(297)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(401, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/401/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>401</td>    <td>Alteração da Demanda Contratada</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(401)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(400, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/400/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>400</td>    <td>Alteração do enquadramento Tarifário</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(400)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(27, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/27/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>27</td>    <td>Aprovação APPJ</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(27)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(163, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/163/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>163</td>    <td>Aprovação Centro de Medição</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(163)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(355, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/355/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>355</td>    <td>Aprovação Civil Comissionameno da REDE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(355)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(357, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/357/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>357</td>    <td>Aprovação Elétrica Comissionamento da REDE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(357)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(296, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/296/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>296</td>    <td>Aprovação Minuta Matrícula Servidão </td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(296)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(293, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/293/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>293</td>    <td>Aprovação Processo de Servidão </td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(293)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(2, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/2/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>2</td>    <td>Aprovação projeto Civil RDS</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(2)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(54, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/54/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>54</td>    <td>Aprovação Projeto Elétrico Executivo RDS</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(54)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(1, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/1/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>1</td>    <td>Aprovação projeto implantação</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(1)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(162, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/162/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>162</td>    <td>Aprovação projeto QDC e Barramento</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(162)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(557, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/557/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>557</td>    <td>Aprovação Projeto Rede Aérea</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(557)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(348, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/348/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>348</td>    <td>Aprovação Projeto SEE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(348)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(566, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/566/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>566</td>    <td>Aprovação projeto SEE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(566)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(345, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/345/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>345</td>    <td>Aprovação Projetos Padrões de Entrada</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(345)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(599, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/599/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>599</td>    <td>Aprovação Servidão de passagem</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(599)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(560, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/560/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>560</td>    <td>Aprovação Servidão rede aérea</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(560)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(308, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/308/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>308</td>    <td>Aprovação Vistoria Civil</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(308)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(271, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/271/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>271</td>    <td>Aprovação Vistoria Elétrica</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(271)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(570, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/570/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>570</td>    <td>Aprovação Vistoria SEE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(570)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(367, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/367/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>367</td>    <td>Assinatura da matricula executada</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(367)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(280, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/280/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>280</td>    <td>Boleto Encaminhado Para Cliente Pagar</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(280)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(265, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/265/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>265</td>    <td>Cadastramento Dados Mestres</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(265)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(475, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/475/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>475</td>    <td>Cadastro Terceirizadas</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(475)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(352, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/352/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>352</td>    <td>Carta em papel timbrado da CENA informando a ENEL a data de iníco das obras</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(352)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(361, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/361/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>361</td>    <td>Certificado de Garantia dos equipamentos QDC e QDP e ETC</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(361)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(264, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/264/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>264</td>    <td>Comprovante de Pgto Boleto Obras</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(264)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(602, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/602/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>602</td>    <td>Comunicar data início obras</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(602)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(636, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/636/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>636</td>    <td>Confecção Projeto de Servidão</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(636)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(238, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/238/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>238</td>    <td>Consulta Preliminar</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(238)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(413, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/413/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>413</td>    <td>Contratação do serviço de Parametrização</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(413)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(572, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/572/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>572</td>    <td>Contrato de fornecimento encaminhado p/ assinatura cliente</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(572)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(273, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/273/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>273</td>    <td>Contrato de fornecimento Entregue Concessionária</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(273)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(278, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/278/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>278</td>    <td>Contrato de Obras Encaminhado Para Assinatura do Cliente</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(278)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(279, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/279/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>279</td>    <td>Contrato de Obras Entregue na Concessionária</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(279)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(381, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/381/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>381</td>    <td>CROQUI DE REMOÇÃO OU REPOSICIONAMENTO DE POSTE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(381)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(571, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/571/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>571</td>    <td>Definição da tarifa e demanda a ser contratada SEE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(571)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(298, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/298/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>298</td>    <td>Entrega do Termo de Doação de ativos </td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(298)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(600, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/600/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>600</td>    <td>Entregar matricula com servidão averbada</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(600)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(446, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/446/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>446</td>    <td>Enviar Grades para instalar dispositivo de segurança</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(446)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(603, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/603/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>603</td>    <td>Enviar Medição</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(603)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(358, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/358/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>358</td>    <td>Envio da Carta de Conclusão das Obras</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(358)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(365, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/365/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>365</td>    <td>Envio das Notas Fiscais e ANEXO i da doação de Ativos</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(365)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(448, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/448/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>448</td>    <td>Envio do Asbuilt dos Projetos CIVIL</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(448)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(359, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/359/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>359</td>    <td>Envio do Asbuilt dos Projetos CIVIL / ElÉTRICO Primário e Secundário</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(359)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(380, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/380/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>380</td>    <td>Envio do termo de Garantia</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(380)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(360, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/360/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>360</td>    <td>Envio do Termo de Garantia da REDE de 60 meses</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(360)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(364, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/364/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>364</td>    <td>Envio Laudo de Aterramento</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(364)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(4, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/4/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>4</td>    <td>Execução do serviço de rede</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(4)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(362, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/362/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>362</td>    <td>Garantia dos Cabos </td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(362)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(43, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/43/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>43</td>    <td>Laudo de isolação do BW</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(43)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(269, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/269/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>269</td>    <td>Liberação da Reserva de Equipamentos TC/TP</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(269)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(504, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/504/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>504</td>    <td>Liberação de materiais</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(504)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(275, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/275/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>275</td>    <td>Ligação Executada</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(275)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(476, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/476/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>476</td>    <td>Locação das interferências e serviços</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(476)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(563, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/563/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>563</td>    <td>Matricula com averbação da servidão rede aérea</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(563)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(314, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/314/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>314</td>    <td>Números de Tomabamento Transformadores</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(314)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(414, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/414/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>414</td>    <td>Parametrização do Relê</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(414)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(263, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/263/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>263</td>    <td>Pedido Boleto de Obras</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(263)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(409, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/409/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>409</td>    <td>Pedido Corrente de Curto Concessionária</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(409)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(398, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/398/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>398</td>    <td>Pedido de Aferição do Medidor</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(398)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(228, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/228/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>228</td>    <td>Pedido de aumento de demanda</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(228)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(353, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/353/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>353</td>    <td>Pedido de Comissionamento da Rede</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(353)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(411, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/411/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>411</td>    <td>Pedido de confecção Estudo de Seletividade</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(411)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(316, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/316/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>316</td>    <td>Pedido de interligação da rede aérea</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(316)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(567, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/567/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>567</td>    <td>Pedido de ligação SEE IDSR</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(567)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(299, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/299/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>299</td>    <td>Pedido de Número de Patrimonio e Equipamentos BF e Etc</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(299)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(315, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/315/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>315</td>    <td>Pedido de Numeros de BFs e etc</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(315)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(8, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/8/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>8</td>    <td>Pedido de Ordem de Serviço para Ligação</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(8)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(397, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/397/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>397</td>    <td>Pedido de revisão da faura de energia</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(397)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(44, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/44/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>44</td>    <td>Pedido de vistoria Civil</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(44)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(284, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/284/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>284</td>    <td>Pedido de Vistoria Elétrica</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(284)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(399, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/399/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>399</td>    <td>Pedido de Vistoria para conferir relação TC e TP</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(399)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(568, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/568/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>568</td>    <td>Pedido de vistoria SEE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(568)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(6, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/6/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>6</td>    <td>Pedido do Contrato de Fornecimento</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(6)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(28, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/28/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>28</td>    <td>Pedido do Contrato de obras</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(28)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(69, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/69/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>69</td>    <td>Pedido do Custo de rede e Corrente de Curto Circuito</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(69)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(5, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/5/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>5</td>    <td>Pedido Reserva de Equipamento TC/TP</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(5)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(336, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/336/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>336</td>    <td>Pedido Reserva Tampão de Ferro Pedestal</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(336)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(332, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/332/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>332</td>    <td>Pedido Viabilidade Técnica</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(332)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(74, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/74/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>74</td>    <td>Processo de doação da Rede</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(74)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(558, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/558/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>558</td>    <td>Processo Servidão de Passagem rede Aérea</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(558)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(473, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/473/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>473</td>    <td>Projeto Executivo</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(473)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(555, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/555/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>555</td>    <td>Protocolo Analise de Projeto Rede Aérea</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(555)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(592, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/592/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>592</td>    <td>Protocolo Analise de Projeto Rede Subterrânea</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(592)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(294, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/294/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>294</td>    <td>Protocolo Minuta da Matrícula da Servidão </td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(294)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(261, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/261/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>261</td>    <td>Protocolo Pedido Custo de Rede</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(261)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(73, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/73/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>73</td>    <td>Protocolo Processo de Servidão de Passagem</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(73)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(559, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/559/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>559</td>    <td>Protocolo processo de servidão rede aérea</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(559)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(259, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/259/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>259</td>    <td>PROTOCOLO PROJETO CIVIL RDS</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(259)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(333, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/333/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>333</td>    <td>Protocólo Projeto de Implantação</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(333)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(268, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/268/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>268</td>    <td>Protocolo Projeto Elétrico Executivo RDS</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(268)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(346, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/346/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>346</td>    <td>Protocolo Projeto SEE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(346)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(564, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/564/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>564</td>    <td>Protocolo projeto SEE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(564)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(343, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/343/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>343</td>    <td>Protocolo Projetos Padrões de Entrada</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(343)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(260, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/260/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>260</td>    <td>PROTOCOLO PROJETOS PARA ABERTURA APPJ</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(260)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(378, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/378/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>378</td>    <td>Protocolo Termo de Doação de Ativos Anexo I</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(378)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(29, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/29/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>29</td>    <td>Recebimento Boleto de obras</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(29)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(262, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/262/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>262</td>    <td>Recebimento Contrato de Obras</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(262)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(410, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/410/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>410</td>    <td>Recebimento Corrente de Curto Concessionária</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(410)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(229, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/229/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>229</td>    <td>Recebimento do custo de rede</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(229)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(412, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/412/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>412</td>    <td>Recebimento do Estudo de Seletividade</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(412)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(404, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/404/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>404</td>    <td>Recebimento projetos construtivos</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(404)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(237, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/237/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>237</td>    <td>Recebimento Viabilidade Técnica </td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(237)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(363, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/363/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>363</td>    <td>Relatório e ensaio dos cabos MT e BT</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(363)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(466, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/466/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>466</td>    <td>Relatório Fotográfico</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(466)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(277, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/277/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>277</td>    <td>Ressalva APPJ</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(277)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(354, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/354/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>354</td>    <td>Ressalva Civil Comissionamento da Rede</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(354)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(276, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/276/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>276</td>    <td>Ressalva de Projeto Civil RDS</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(276)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(356, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/356/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>356</td>    <td>Ressalva Elérica Comissionamento da REDE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(356)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(295, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/295/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>295</td>    <td>Ressalva Minuta Matrícula Servidão </td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(295)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(274, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/274/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>274</td>    <td>Ressalva na Vistoria de Ligação</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(274)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(292, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/292/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>292</td>    <td>Ressalva Processo Servidão </td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(292)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(334, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/334/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>334</td>    <td>Ressalva Projeto de Implantação</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(334)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(291, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/291/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>291</td>    <td>Ressalva Projeto Elétrico Exec RDS</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(291)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(556, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/556/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>556</td>    <td>Ressalva projeto Rede Aérea</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(556)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(347, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/347/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>347</td>    <td>Ressalva Projeto SEE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(347)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(344, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/344/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>344</td>    <td>Ressalva Projetos Padrões de Entrada</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(344)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(598, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/598/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>598</td>    <td>Ressalva Servidão de passagem</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(598)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(561, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/561/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>561</td>    <td>Ressalva Servidão rede aérea</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(561)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(281, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/281/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>281</td>    <td>Ressalva Vistoria Civil</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(281)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(270, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/270/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>270</td>    <td>Ressalva Vistoria Elétrica</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(270)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(569, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/569/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>569</td>    <td>Ressalva Vistoria SEE</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(569)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(283, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/283/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>283</td>    <td>Retirada Dos Equipamentos TC/TP</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(283)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(447, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/447/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>447</td>    <td>Retirar Grades com  dispositivo de segurança</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(447)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(554, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/554/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>554</td>    <td>Revisão Projeto Elétrico Rede Aérea</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(554)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(403, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/403/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>403</td>    <td>Solicitar projetos Construtivos Cliente/ Fabricante</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(403)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(335, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/335/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>335</td>    <td>Suspensão do prazo de obras</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(335)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(444, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/444/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>444</td>    <td>Suspensão do prazo de obras motivo Insp Civil</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(444)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(445, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/445/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>445</td>    <td>Suspensão do prazo de obras motivo Insp Ele</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(445)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(337, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/337/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>337</td>    <td>Tampão de ferro retirado</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(337)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr><tr>    <td>        <a type="button" class="btn btn-info" onclick="edit_etapa(474, 'Con')"><i class="ion-android-create"></i></a>        <a class="btn btn-danger" href="http://www2.cena.com.br/concessionarias/delete_etapa/474/11/1/concessionaria">                <i class="ion ion-trash-a"></i>         </a>    </td>    <td>474</td>    <td>TPOV</td>    <td>CONCESSIONARIA</td>    <td>        <a onclick="addEtapaConcessionariaServico(474)" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>    </td></tr></tbody>

                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade bd-example-modal-lg" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <h2 class="modal-title fc-center" align="center"></h2>

              </div>
              <form id="form_update" method="POST" class="form-horizontal">
                  <div class="modal-body form">

                      <input type="hidden" value="" name="id_etapa">
                      <input type="hidden" value="" name="id_concessionaria">
                      <input type="hidden" value="" name="id_servico">
                      <input type="hidden" value="" name="tipo">

                      <div class="box box-default ">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="box-header with-border">
                                      <h3 class="box-title">Dados</h3>
                                  </div>
                                  <div class="box-body">

                                      <div class="col-md-4">
                                          <div class="input-group">
                                              <label for="">Nome da Etapa</label>
                                              <input class="form-control" name="nome" value="" placeholder="Nome da Etapa">

                                          </div>
                                      </div>
                                      <div id="etapaCompra" style="display:none">
                                          <div class="col-md-2">
                                              <div class="input-group">
                                                  <label for="">Quantidade</label>
                                                  <input class="form-control" name="quantidade" value="0" placeholder="Nome da Etapa">
                                              </div>
                                          </div>

                                          <div class="col-md-2">
                                              <div class="input-group">
                                                  <label for="">Tipo</label>
                                                  <input class="form-control" name="tipo_compra" value="" placeholder="Nome da Etapa">
                                              </div>
                                          </div>

                                          <div class="col-md-4">
                                              <div class="input-group">
                                                  <label for="">Preço</label>
                                                  <input class="form-control" name="preco" value="" placeholder="Nome da Etapa">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="box box-primary" id="variaveis">
                          <div class="box-header with-border">
                              <h3 class="box-title">Variaveis</h3>

                              <div class="box-tools pull-right">
                                  <a class="btn btn-sm btn-info btn-flat new_variavel_edit"> <i class="fa fa-fw fa-plus-circle"></i></a>

                              </div>
                          </div>
                          <div class="box-body">
                              <div id="new_variavel_edit"> </div>

                              <div id="variavel_etapa">
                              </div>

                          </div>
                      </div>

                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Salvar</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                      <a type="button" data-toggle="tooltip" title="" data-original-title="Duplicar" class="btn btn-warning pull-right" id="duplicar">Duplicar</a>
                  </div>
              </form>
          </div>
      </div>
  </div>


  </section></div>


  <div class="container-fluid" style="    display: flex;overflow-x: scroll;">
      <div class="row" style="    display: flex;width: 100%;">

          <div class="col-3 col-lg-3 col-sm-12 col-xl-3">
              <div class="box box-primary">
                  <div class="box-header ui-sortable-handle">
                      <i class="ion ion-clipboard"></i>
                      <h3 class="box-title">Concessionaria</h3>
                  </div>
                  <div class="box-body">
                      <ul class="todo-list ui-sortable lista" id="listaEtapaCONCESSIONARIA"><li id="4765">    <span class="handle ui-sortable-handle">        <i class="fa fa-ellipsis-v"></i>        <i class="fa fa-ellipsis-v"></i>    </span>    <span class="text">Abertura de Nota para Vistoria Elétrica</span>    <div class="tools">        <i onclick="edit_etapa(45,'Con')" class="fa fa-edit"></i>        <i onclick="remove_etapa(4765)" class="fa fa-trash-o"></i>    </div></li></ul>
                  </div>
              </div>
          </div>

          <div class="col-3 col-lg-3 col-sm-12 col-xl-3">
              <div class="box box-primary">
                  <div class="box-header ui-sortable-handle">
                      <i class="ion ion-clipboard"></i>
                      <h3 class="box-title">Administrativa</h3>
                  </div>
                  <div class="box-body">
                      <ul class="todo-list ui-sortable lista" id="listaEtapaADMINISTRATIVA"></ul>
                  </div>
              </div>
          </div>

          <div class="col-3 col-lg-3 col-sm-12 col-xl-3">
              <div class="box box-primary">
                  <div class="box-header ui-sortable-handle">
                      <i class="ion ion-clipboard"></i>
                      <h3 class="box-title">Obras</h3>
                  </div>
                  <div class="box-body">
                      <ul class="todo-list ui-sortable lista" id="listaEtapaOBRA"></ul>
                  </div>
              </div>
          </div>

          <div class="col-3 col-lg-3 col-sm-12 col-xl-3">
              <div class="box box-primary">
                  <div class="box-header ui-sortable-handle">
                      <i class="ion ion-clipboard"></i>
                      <h3 class="box-title">Compras</h3>
                  </div>
                  <div class="box-body">
                      <ul class="todo-list ui-sortable lista" id="listaEtapaCOMPRA"></ul>
                  </div>
              </div>
          </div>

          <div class="col-3 col-lg-3 col-sm-12 col-xl-3">
              <div class="box box-primary">
                  <div class="box-header ui-sortable-handle">
                      <i class="ion ion-clipboard"></i>
                      <h3 class="box-title">Vistoria</h3>
                  </div>
                  <div class="box-body">
                      <ul class="todo-list ui-sortable lista" id="listaEtapaVISTORIA"></ul>
                  </div>
              </div>
          </div>
      </div>
  </div>


  <script>
      $(document).ready(function() {
          $(function() {
              $(".lista").sortable({
                  update: function() {
                      var ordem_atual = $(this).sortable("toArray");
                      $.post(BASE_URL + "ajax/attOrdemEtapaSerCon", {
                          itens: ordem_atual
                      }, function(retorno) {
                          retorno ? toastr.success('ordenado com sucesso!') : toastr.error('deu erro, me chama');


                      });
                  }
              });
          });

      });
  </script>


  <script>
      var id_concessionaria = '11';
      var id_servico = '1';
      $(document).ready(function() {
          getTabelaEtapas();
          getEtapasByServicoConcessionaria();

      });

      $('#tipoEtapa').change(function() {
          getTabelaEtapas();

      });

      $('#table_search').keyup(function() {
          getTabelaEtapas();

      });

      function getTabelaEtapas() {

          var select = $('.tipo_etapa').select2('data');
          var id_concessionaria = '11';
          var id_servico = '1';
          var table_search = $('#table_search').val();
          var tipo = $('#tipoEtapa').val();


          if ($('#tipoEtapa').val() != 0) {

              $('#rowEtapa').css('display', '');

              $.getJSON(BASE_URL + 'ajax/getEtapasByTipo/true?search=', {
                  id_concessionaria: id_concessionaria,
                  id_servico: id_servico,
                  tipo: select[0].id,
                  filtro: table_search,
                  ajax: 'true'
              }, function(j) {
                  var options = '';

                  if (j.length != 0) {
                      for (var i = 0; i < j.length; i++) {
                          options += '<tr>'
                          options += '    <td>'
                          options += `        <a type="button" class="btn btn-info" onclick="edit_etapa(` + j[i].id + `, 'Con')"><i class="ion-android-create"></i></a>`
                          options += `        <a class="btn btn-danger" href='` + BASE_URL + `concessionarias/delete_etapa/` + j[i].id + `/` + id_concessionaria + `/` + id_servico + `/` + tipo + `'>`
                          options += `                <i class="ion ion-trash-a"></i>`
                          options += `         </a>`
                          options += '    </td>'
                          options += '    <td>' + j[i].id + '</td>'
                          options += '    <td>' + j[i].etp_nome + '</td>'
                          options += '    <td>' + j[i].nome + '</td>'
                          options += '    <td>'
                          options += '        <a  onclick="addEtapaConcessionariaServico(' + j[i].id + ')" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>'

                          options += '    </td>'
                          options += '</tr>'

                      }
                  } else {
                      options += '<tr>'
                      options += '    <td style="text-center>'
                      options += '        não encontrado'
                      options += '    </td>'
                      options += '</tr>'


                  }
                  $('#listEtapa').html(options).show();


              });
          } else {

              $('#rowEtapa').css('display', 'none');
          }
      };

      function edit_etapa(id) {
          save_method = 'update';
          $('#form_update')[0].reset();

          $('.form-group').removeClass('has-error');
          $('.help-block').empty();

          $('#variaveis').hide();

          //Ajax Load data from ajax
          $.ajax({
              url: BASE_URL + 'ajax/getEtapaComprabyId/' + id,
              type: "GET",
              dataType: "JSON",
              success: function(data) {

                  const tipo = data.tipo;

                  $('[name="id_etapa"]').val(data.id);
                  $('[name="tipo"]').val($('#tipoEtapa').val());
                  $('[name="id_concessionaria"]').val('11');
                  $('[name="id_servico"]').val('1');

                  $('[name="nome"]').val(data.etp_nome);

                  if (tipo == 4) {
                      getvariaveis(data.id);
                      $('[name="quantidade"]').val(data.quantidade);
                      $('[name="tipo_compra"]').val(data.tipo_compra);
                      $('[name="preco"]').val('R$ ' + formata(data.preco));
                      $('#etapaCompra').show();

                  } else {
                      $('#etapaCompra').hide();

                  }

                  $('.modal-title').text('Editar Etapa "' + data.etp_nome + '"');
                  $('#modal_form').modal('show');


              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert('Error get data from ajax');
              },
          });

      }

      function add_etapa(id) {
          $('#form_update')[0].reset();

          $('#etapaCompra').hide();
          $('#variaveis').hide();
          $('#variavel_etapa').hide();

          $('.modal-title').text('Cadastro de nova etapa "' + $('#tipoEtapa').val() + '"');

          if ($('#tipoEtapa').val() == 'compra') {
              $('#etapaCompra').show();
              $('#variaveis').show();
          }

          $('[name="tipo"]').val($('#tipoEtapa').val());
          $('[name="id_concessionaria"]').val('11');
          $('[name="id_servico"]').val('1');
          $('#modal_form').modal('show');


      }

      function getvariaveis(id) {

          $.ajax({
              url: BASE_URL + 'ajax/getVariavelEtapa/' + id,
              type: "GET",
              dataType: "JSON",
              success: function(data) {
                  options = '';

                  for (var i = 0; i < data.length; i++) {

                      options += '<input type="hidden" class="form-control" value="' + data[i].id_variavel_etapa + '" name="variavel[id][]" id="id_variavel" autocomplete="off">'
                      options += '<div class="row" style="    left: 10px;position: relative;">'
                      options += '    <div class="col-md-6">'
                      options += '        <div class="form-group" style="margin-right: 26px;margin-left: -10px;">'
                      options += '            <label>Nome da Variavel</label>'
                      options += '            <input type="text" class="form-control" value="' + data[i].nome_variavel + '" name="variavel[nome_variavel][]" id="nome_variavel" autocomplete="off">'
                      options += '        </div>'
                      options += '    </div>'

                      options += '    <div class="col-md-2">'
                      options += '        <div class="form-group"  style="margin-right: 26px;margin-left: -10px;">'
                      options += '            <label>Preço</label>'
                      options += '            <input type="text" class="form-control" name="variavel[preco_variavel][]" value="R$ ' + data[i].preco_variavel + '" id="preco_variavel" autocomplete="off">'
                      options += '        </div>'
                      options += '    </div>'
                      options += '    <div class="col-md-2">'
                      options += '        <button type="button" style="position: relative;top: 25px;" data-toggle="tooltip" title="" onclick="deleteVariavelEtapa(' + data[i].id_variavel_etapa + ')" data-original-title="Deletar" class="btn btn-danger"><i class="ion ion-trash-a"></i></button>'
                      options += '    </div>'
                      options += '</div>'

                  }

                  $('#variaveis').show();
                  $('#variavel_etapa').html(options).show();


              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert('Error get data from ajax');
              },
          });

      }

      function deleteVariavelEtapa(id) {

          $(function() {

              $.ajax({

                  url: BASE_URL + 'ajax/deleteVariavelEtapa',
                  type: 'POST',
                  data: {
                      id: id
                  },
                  dataType: 'json',
                  success: function(json) {
                      location.reload();
                  },
              });

          });
      }

      function getEtapasByServicoConcessionaria() {

          $.ajax({
              url: BASE_URL + 'ajax/getEtapasByServicoConcessionaria/',
              data: {
                  id_concessionaria: id_concessionaria,
                  id_servico: id_servico
              },
              type: "GET",
              dataType: "JSON",
              success: function(data) {
                  optionsCon = '';
                  optionsCompra = '';
                  optionsObra = '';
                  optionsAdm = '';
                  optionsVistoria = '';

                  var type = '';
                  if (data['concessionaria'] ||
                      data['administrativa'] ||
                      data['obra'] ||
                      data['compra'] ||
                      data['vistoria']
                  ) {
                      for (var i = 0; i < data['concessionaria'].length; i++) {
                          optionsCon += '<li id="' + data['concessionaria'][i].id_serv_conce + '">'
                          optionsCon += '    <span class="handle ui-sortable-handle">'
                          optionsCon += '        <i class="fa fa-ellipsis-v"></i>'
                          optionsCon += '        <i class="fa fa-ellipsis-v"></i>'
                          optionsCon += '    </span>'
                          optionsCon += '    <span class="text">' + data['concessionaria'][i].etp_nome + '</span>'
                          optionsCon += '    <div class="tools">'
                          optionsCon += `        <i onclick="edit_etapa(` + data['concessionaria'][i].id_etapa + `,'Con')" class="fa fa-edit"></i>`
                          optionsCon += '        <i onclick="remove_etapa(' + data['concessionaria'][i].id_serv_conce + ')" class="fa fa-trash-o"></i>'
                          optionsCon += '    </div>'
                          optionsCon += '</li>'

                          $('#listaEtapaCONCESSIONARIA').html(optionsCon).show();

                      }

                      for (var i = 0; i < data['administrativa'].length; i++) {

                          optionsAdm += '<li id="' + data['administrativa'][i].id_serv_conce + '">'
                          optionsAdm += '    <span class="handle ui-sortable-handle">'
                          optionsAdm += '        <i class="fa fa-ellipsis-v"></i>'
                          optionsAdm += '        <i class="fa fa-ellipsis-v"></i>'
                          optionsAdm += '    </span>'
                          optionsAdm += '    <span class="text">' + data['administrativa'][i].etp_nome + '</span>'
                          optionsAdm += '    <div class="tools">'
                          optionsAdm += `        <i onclick="edit_etapa(` + data['administrativa'][i].id_etapa + `,'Adm')" class="fa fa-edit"></i>`
                          optionsAdm += '        <i onclick="remove_etapa(' + data['administrativa'][i].id_serv_conce + ')" class="fa fa-trash-o"></i>'
                          optionsAdm += '    </div>'
                          optionsAdm += '</li>'

                          $('#listaEtapaADMINISTRATIVA').html(optionsAdm).show();

                      }

                      for (var i = 0; i < data['obra'].length; i++) {
                          optionsObra += '<li id="' + data['obra'][i].id_serv_conce + '">'
                          optionsObra += '    <span class="handle ui-sortable-handle">'
                          optionsObra += '        <i class="fa fa-ellipsis-v"></i>'
                          optionsObra += '        <i class="fa fa-ellipsis-v"></i>'
                          optionsObra += '    </span>'
                          optionsObra += '    <span class="text">' + data['obra'][i].etp_nome + '</span>'
                          optionsObra += '    <div class="tools">'
                          optionsObra += `        <i onclick="edit_etapa(` + data['obra'][i].id_etapa + `,'Obr')" class="fa fa-edit"></i>`
                          optionsObra += '        <i onclick="remove_etapa(' + data['obra'][i].id_serv_conce + ')" class="fa fa-trash-o"></i>'
                          optionsObra += '    </div>'
                          optionsObra += '</li>'

                          $('#listaEtapaOBRA').html(optionsObra).show();

                      }

                      for (var i = 0; i < data['compra'].length; i++) {
                          optionsCompra += '<li id="' + data['compra'][i].id_serv_conce + '">'
                          optionsCompra += '    <span class="handle ui-sortable-handle">'
                          optionsCompra += '        <i class="fa fa-ellipsis-v"></i>'
                          optionsCompra += '        <i class="fa fa-ellipsis-v"></i>'
                          optionsCompra += '    </span>'
                          optionsCompra += '    <span class="text">' + data['compra'][i].etp_nome + '</span>'
                          optionsCompra += '    <div class="tools">'
                          optionsCompra += `        <i onclick="edit_etapa(` + data['compra'][i].id_etapa + `,'Compra')" class="fa fa-edit"></i>`
                          optionsCompra += '        <i onclick="remove_etapa(' + data['compra'][i].id_serv_conce + ')" class="fa fa-trash-o"></i>'
                          optionsCompra += '    </div>'
                          optionsCompra += '</li>'

                          $('#listaEtapaCOMPRA').html(optionsCompra).show();

                      }

                      for (var i = 0; i < data['vistoria'].length; i++) {
                          optionsVistoria += '<li id="' + data['vistoria'][i].id_serv_conce + '">'
                          optionsVistoria += '    <span class="handle ui-sortable-handle">'
                          optionsVistoria += '        <i class="fa fa-ellipsis-v"></i>'
                          optionsVistoria += '        <i class="fa fa-ellipsis-v"></i>'
                          optionsVistoria += '    </span>'
                          optionsVistoria += '    <span class="text">' + data['vistoria'][i].etp_nome + '</span>'
                          optionsVistoria += '    <div class="tools">'
                          optionsVistoria += `        <i onclick="edit_etapa(` + data['vistoria'][i].id_etapa + `,'Vistoria')" class="fa fa-edit"></i>`
                          optionsVistoria += '        <i onclick="remove_etapa(' + data['vistoria'][i].id_serv_conce + ')" class="fa fa-trash-o"></i>'
                          optionsVistoria += '    </div>'
                          optionsVistoria += '</li>'

                          $('#listaEtapaVISTORIA').html(optionsVistoria).show();

                      }

                  } else {
                      $('#listaEtapaVISTORIA').html('').show();
                      $('#listaEtapaCOMPRA').html('').show();
                      $('#listaEtapaOBRA').html('').show();
                      $('#listaEtapaADMINISTRATIVA').html('').show();
                      $('#listaEtapaCONCESSIONARIA').html('').show();
                  }

              },
              error: function(jqXHR, textStatus, errorThrown) {
                  toastr.error('Erro contate o administrador GETETAPAX2');
              },
          });

      }

      function addEtapaConcessionariaServico(id_etapa) {
          var tipo = '';
          switch ($('#tipoEtapa').val()) {
              case 'concessionaria':
                  tipo = 'com'
                  break;
              case 'administrativa':
                  tipo = 'adm'
                  break;
              case 'obra':
                  tipo = 'obr'
                  break;
              case 'compra':
                  tipo = 'compra'
                  break;
              case 'vistoria':
                  tipo = 'vistoria'
                  break;

              default:
                  break;
          }

          $.ajax({
              url: BASE_URL + 'ajax/addEtapaConcessionariaServico/',
              data: {
                  id_concessionaria,
                  id_servico,
                  id_etapa,
                  tipo
              },
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                  data ? '' : toastr.error('Erro contate o administrador');
                  getEtapasByServicoConcessionaria();
                  getTabelaEtapas();
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  toastr.error('Erro contate o administrador CODADDETAPACONX1');
              },
          });

      }

      function remove_etapa(id_etapa) {
          $.ajax({
              url: BASE_URL + 'ajax/removeEtapa/' + id_etapa,
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                  data ? toastr.success('Retirado') : toastr.error('Erro contate o administrador');
                  getEtapasByServicoConcessionaria();
                  getTabelaEtapas();
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  toastr.error('Erro contate o administrador CODADDETAPACONX1');
              },
          });

      }

      $("#duplicar").on("click", function() {

          var id_concessionaria = 11;
          var id_servico = 1;
          var id_etapa = $('[name="id_etapa"]').val();

          $.ajax({

              url: BASE_URL + 'ajax/duplicarEtapa',
              type: 'POST',
              data: {
                  id_etapa: id_etapa,
                  id_concessionaria: id_concessionaria,
                  id_servico: id_servico
              },
              dataType: 'json',
              success: function(json) {

                  window.location.href = BASE_URL + "concessionarias/editService/" + id_concessionaria + '/' + id_servico + '?tipo=compra';
              },
          });
      });

      function openImport(id) {

          $('#modalImportar' + id).modal('toggle');
      }
  </script>
        </div>
      </div>

      <footer class="main-footer">
        <div class="container">
          <div class="pull-right hidden-xs">
          </div>
          <strong></strong> All rights reserved. Land.20 fpt
        </div>
      </footer>

        <div style="    position: fixed;z-index: 999999;right: 12px;bottom: 3px;">
        <div id="chat" class="" style=" width: 70px;    display: block;;">
          <div id="colapse" class="box box-info direct-chat direct-chat-info collapsed-box" style="margin-bottom: 31px;">
            <div class="box-header with-border">
              <h3 class="box-title chat-title"></h3>

              <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="" class="badge bg-info titlemensagem" data-original-title="0 Nova(s) Mensagen(s)">0</span>
                <button type="button" onclick="openChat(this)" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <br>
              <div class="direct-chat-messages" style="overflow: auto; display: flex;flex-direction: column-reverse; height:250px;margin-bottom: 0px;">

                <div id="chatFor">
                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 22,Jan 16:18:50</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Leo vc esta de parabéns
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 22,Jan 16:20:57</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gratidão
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 23,Jan 11:15:36</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  alguem sentiu o sistema lento?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 23,Jan 18:12:02</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  um pouco
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 23,Jan 19:03:04</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  vish
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 23,Jan 19:03:18</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  já pode trocar a senha dos clientes que estão cadastrados como usuarios
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 24,Jan 14:52:19</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  otimo
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 12,Feb 18:03:04</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  teste
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 12,Feb 18:11:11</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  teste
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Feb 16:47:39</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel, pode ser colocado  o cliente em destaque?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Feb 16:51:16</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Acho uma boa idéia
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 14,Feb 16:55:01</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  onde
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 14,Feb 17:46:12</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  teste pisca pisca
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Feb 09:47:01</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gostei do chat piscando, nos chama a atenção
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Feb 12:33:33</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  o chat parou de piscar, mas foi uma boa, nos lembrar de olhar, ja o sininho de notificação não para de piscar mesmo clicando nele e na notificação
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Feb 22:08:03</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Pra mim parou de piscar depois que dei a ciencia da obra
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Feb 22:08:25</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  tem que descer até o final da obra e selecionar a caixinha de visto
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 17,Feb 07:46:03</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  jÁ FIZ E NÃO MUDA
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 18,Feb 08:53:16</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel, bom dia!
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 18,Feb 08:53:38</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Por favor adicionar obra: Trimais - Assessoria Cubiculo
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 18,Feb 08:54:43</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Adicionar: RESERVA EQUIPAMENTOS entre a etapa   Execução do serviço de rede e   Pedido de Vistoria Elétrica
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 18,Feb 08:55:56</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Quis dizer adicionar na obra  Trimais - Assessoria Cubículo
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 18,Feb 10:04:13</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  ok
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 18,Feb 10:18:41</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Obrigada
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 18,Feb 11:55:14</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  leo, qual o id da obra trismais por favor
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 18,Feb 14:14:43</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Pedido Reserva de Equipamento TC/TP é esse?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 19,Feb 09:59:37</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel, bom dia!
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 19,Feb 09:59:48</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  TRIMAIS seria:
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 19,Feb 09:59:51</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  http://www.landsolucoes.com.br/obras/edit/153
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 19,Feb 10:02:05</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Pergunta: Como sei quando uma obra esta ativa ou não?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 19,Feb 10:02:36</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                   quando uso o filtro OBRAS e seleciono uma obra especifica e vem mais de uma com mesmo nome?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 19,Feb 10:03:00</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Ah, desculpe por não ter lhe respondido de imediato baby
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 19,Feb 10:46:45</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  como assim ativa?
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 19,Feb 10:48:13</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  mandei no whats, por ser imagem
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 10:37:56</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  GENTEEE
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 10:38:01</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  SOCORRO
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 10:38:09</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  EXCLUI O FE DO SISTEMA :)
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 10:51:43</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Tadinho dele...
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 10:53:28</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Foi sem querer kkkk
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 10:56:21</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Fala tudo pra sua mãe Kiko
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 11:02:20</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  kkkkkkkkkkkkkkkkk
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 11:28:46</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  pelo que vi ja recadastraram certo?
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 11:32:04</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  sim
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 14:34:57</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  como esta salvo tancredo pois não estou localizando ?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 14:36:43</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Tancredo GS
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 14:37:29</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  não aparece pra mim
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 14:37:36</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  pelo menos pela busca não
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 14:38:13</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  ops foi
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 16:39:31</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Lu, todos os documentos da FAGRON estão no sistema
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> luana varella</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 16:52:44</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Eu vi Camis!! Obrigada
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 16:54:14</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  por nada
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Feb 19:47:46</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  se a notificação der erro, apertem ctrl + f5
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 21,Feb 11:02:17</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Biel, o chat ele fica piscando mesmo quando o abrimos, ele para após clicarmos 3 vezes
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 21,Feb 13:05:10</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  não, ele para depois de 10 segundos kkk
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 21,Feb 13:05:16</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  vou arrumar
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 21,Feb 13:42:58</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  ^-^
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 27,Feb 16:56:03</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Lu, falta docs do cliente obra REC-G3A Assessoria no sistema amore
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 27,Feb 19:36:29</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  ela disse que não esta ciente dessa obra, disse que vai ver
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 27,Feb 19:46:21</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Essa obra não precisamos de documentos, a Léo se enganou, ja temos o que prevcisa no sistema
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 27,Feb 19:46:37</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  blz
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 27,Feb 19:49:09</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">

                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> luana varella</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 28,Feb 12:46:45</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Carta de Autorização da Chabad ja esta no sistema, preciso que adicione ela no servidor do escritorio por favor
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 03,Mar 14:54:40</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gente só eu que não consigo abir os arquivos que está em anexo nos documentos, por exemplo a proposta
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 03,Mar 15:10:26</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  o que acontece
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 03,Mar 15:13:14</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  tenta agora ari
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 03,Mar 15:15:58</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Obrigadaaa!! ;) consegui sim!!
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 03,Mar 15:16:58</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  beleza
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 03,Mar 15:17:02</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  precisar, só chamar
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 04,Mar 09:47:17</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel, bom dia! Tudo bem ? ta dando problema para abrir alguns documentos, o mesmo problema que ontem, não só comigo com outros usuários também
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 04,Mar 09:47:50</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  pode verificar , por favor
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 04,Mar 12:16:10</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Consegue anotar quais documentos são?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 04,Mar 13:05:08</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Por enquanto são as proposta que eu abro.
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 04,Mar 14:26:14</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  depois me fala a obra
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 04,Mar 14:28:30</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  a maioria kkkkkkkk
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 04,Mar 18:55:52</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  quando você abre aparece algo, fica tudo branco, da algum erro ?
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 04,Mar 18:56:04</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  http://www.landsolucoes.com.br/assets/documentos/proposta%20aprovada_cna%20spitaletti%20construtora%20e%20incorporadora%20ltda.pdf
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 04,Mar 18:56:11</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  tem abrir esse depois
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 05,Mar 08:09:48</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  BOM DIAAA!! quando eu abro fica branco
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 05,Mar 08:10:19</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  consegui abrir esse que vc mandou
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> silvio</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 09,Mar 12:52:07</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">

                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 11,Mar 17:00:53</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Marcos, pode anexar a proposta da Rocontec Caiubi ao sistema, por favor? A mesma não abre
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 11,Mar 17:38:15</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel, conseguimos colocar na obra Temon Safra - 120 dois clientes, sendo TEMON e ROCONTEC?
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 12,Mar 18:03:01</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  não, uma obra = um cliente
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 12,Mar 18:07:34</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Puxa...
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 18,Mar 14:05:03</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">

                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 18,Mar 16:13:05</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">

                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 19,Mar 21:03:19</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel,  é sinalizada NOVA ETAPA EM SEU NOME - Etapa colocada por Luana Varella, mas quando tico  apenas some e eu não entro na tarefa adicionada.
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 20,Mar 08:43:53</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">

                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 23,Mar 16:04:23</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  marcos não esquece de inserir as proposta na obra
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 23,Mar 16:04:26</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Obrigada!!
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 24,Mar 00:03:25</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">

                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 24,Mar 14:29:47</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  OBRA DIRECIONAL - MAL TITO - ASSESSORIA - 198, com documentação necessária para Confecção dos Projetos
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 24,Mar 14:30:54</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Só não consegui salvar Contrato no Sistema (Gabriel, please)
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 24,Mar 15:54:57</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  pode mandar pra mim*
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 24,Mar 16:36:09</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  botado leo
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 24,Mar 17:24:16</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Muito tks!!
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 24,Mar 17:24:19</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">

                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 24,Mar 17:33:38</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">

                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> felipe</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 07:13:29</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">

                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 08:11:25</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  bom dia, vou mexer hoje em algumas partes do sistema, que podem afetar as partes de documentação (alguns vão abrir, outros não)
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 08:11:32</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  agradeço a compreensão de todos
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 08:11:33</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  kkkk
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 10:53:33</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  mas depois voltam ao normal, ou esses que não abrirem teremos que colocar novamente?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcia</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 10:54:01</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">

                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 10:59:35</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  não, normal
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 10:59:42</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  ja fiz já, tudo certo
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 11:00:15</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  veja se ficou bom marcão, o nome da obra
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 11:07:38</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">

                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 11:08:34</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Ficou ótimo
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 11:08:45</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Camila agora não precisa mais fechar para ver a obra
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 11:10:26</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  ok estou testando
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 11:13:13</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  agora quando vc entra na etapa não tem mais o x pra fechar é só clicar fora dela que sai ?
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 11:13:59</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  sim
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 11:14:42</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  gabriel o chat não para de piscar mesmo clicando para escrever
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 11:14:57</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  estou digitando mas ele não parou rsrsrs
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 11:20:38</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  é que eu acho que quando a mensagem chegou o chat estava aberto, clica pra ele fechar e abre de novo
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 11:21:03</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  kkk
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 12:04:34</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">

                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 12:11:52</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  agora sim rsrs
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 13:45:30</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel, quando me marcam em alguma etapa só aparece como nova etapa em seu nome
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 13:46:06</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  será que não consegue ao inves disso colocar o nome da obra
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 13:46:57</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  e quando eu concluir a etapa colocar algum botão para concluir e sair essa notificação que fica piscando ?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 13:48:01</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  só sugestão, porque CNL foi feita a inclusão do ASBUILT, etapa que a Léo me marcou, porém não consigo tirar ela das notificações que ficam piscando como marcada
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 14:26:41</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  ela sai das suas notificações se você chegar ela
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 14:26:53</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  sim, em vez de por etapa em seu nome vou por o nome da obra
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 14:27:00</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  estava sem criatividade kkk
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 14:27:14</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  chekar ela *
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 14:34:05</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  e recarregar a pagina
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 25,Mar 14:34:32</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  chat ta com 1h de atraso kkk vou arrumar
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 26,Mar 12:11:23</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Oi Gabriel
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 26,Mar 12:11:47</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  então mas onde clico para checar a etapa ?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 26,Mar 12:12:13</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  pois entro e não vejo onde dar o ok para que pare de piscar
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 26,Mar 13:43:47</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  do lado tem um quadradinho, só clicar nele
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 27,Mar 07:06:00</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  blz
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 27,Mar 07:06:09</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  obrigada Gabriel
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> silvio</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 27,Mar 07:47:27</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel, bom dia.  Essa  Nova Obra :Casa Av Morumbi Albert Einstein ; clico nela mas não abre e consequentemente não para de piscar aqui para mim
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 27,Mar 08:37:14</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  silvio bom dia, você tem que clicar em "nova obra", ela vai abrir para você, quando abrir, no topo tem um checkbox escrito "visto" é so clicar nela e confirmar
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> silvio</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 27,Mar 13:40:04</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  obrigado Gabriel! mas estava com problema para abrir esta obra e clicar como obra vista; agora consegui
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 31,Mar 13:59:39</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Asbuilt Acqua Park em sistema
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 31,Mar 16:30:17</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Obrigada Camila
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 31,Mar 16:30:31</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Silvio as fotos para o relatório
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 03,Apr 10:33:10</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  MARCOS: CLP - SANCA - Assessoria, será necessário docs? Quem é o gestor da obra?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 03,Apr 11:39:34</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gestor o CEZAR
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Apr 07:35:01</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Bom dia Gabriel
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Apr 07:35:04</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  udo bem ?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Apr 07:35:19</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  *tudo bem
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Apr 07:35:49</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  preciso corrigir  a quilometragem do veiculo do Marquinho porém não está me dando essa opção
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Apr 07:36:54</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  consegue corrigir a quilometragem inicial a partir do ultimo que inseri
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Apr 07:37:50</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  KM inicial 139610 e KM Final 139624
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> josemar</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Apr 10:05:59</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Estou usando o aplicativo marcao pode ver se esta dando certo
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Apr 10:18:15</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  ja falo
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> josemar</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Apr 10:18:50</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Obrigado
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Apr 10:19:44</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  vc precisa colocar a KM inicial quando for sair para atividade e a final quando chegar no local da ativiade
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Apr 10:20:00</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  assim vc terá as duas horas de lançamento
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> josemar</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 13,Apr 10:21:58</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Blz vou ver isso,assim ja vou aprendendo a mexer mais
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 14,Apr 08:59:36</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Marcoa e gabriel
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 14,Apr 08:59:52</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  o pereira está tendo problema com o QR Code
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 14,Apr 09:00:20</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  não esta dando opção de inserir mais atividades
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 14,Apr 10:42:24</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  qual é a ultima atividade que aparece pra ele?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 14,Apr 13:41:08</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Marcos poderia adicionar as propostas nas Obras novas por favor!
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> glaucio</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Apr 10:23:30</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Sim já faço
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Apr 13:39:53</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Quais propostas vc sentiu falta
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Apr 13:51:08</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  As propostas novas que você criou
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Apr 14:37:57</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Marcos e Léo, saiu nota do Mal Tito - Direcional, já atualizado em sistema
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Apr 14:40:52</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  ok obg
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Apr 14:40:59</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  ja passei para o Erik aprovar
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Apr 16:12:53</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Camila vc só tinha esquecido de checar  como ultima nota
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 17,Apr 08:16:42</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  teste
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 04,May 09:17:57</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel, bom dia!
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 04,May 09:20:49</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Nos recados que enviamos um para o outro nas Etapas, há possibilidade de ficar registrada a nossa pergunta quando o outro responder, pois são tantas coisas que qdo a pessoa responde já não nos recordamos do desenrolar do assunto podendo se perder algo já que não fica o histórico.
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 04,May 11:54:51</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  não entendi
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 06,May 10:27:07</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel Bom dia
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 06,May 10:27:09</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  udi bem ?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 06,May 10:27:14</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  tudi bem?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 06,May 10:27:33</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  tudo bem
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 06,May 10:27:39</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  agora sim rsrs
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 06,May 10:28:20</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  me diz uma coisa, se eu consigo alterar o KM final do veiculo o correto não é atualizar o KM inicial da próxima atividade ?
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 06,May 13:44:05</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  o ideal é ñ deixar editar.
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 06,May 13:44:27</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  tirando a permissão dele de edição...
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 07,May 09:23:30</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  07/05 (LM) Ligação executada, confirmado com José Rodolfo
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 07,May 09:23:53</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Me refiro Obra BSP acima
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leandro</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 11,May 12:12:23</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel: é possivel na etapa mesmo que o fincionario nao coloque os dados apareça o log do usuario que alterou?
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 11,May 14:52:40</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  me explique melhor
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 11,May 14:52:46</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  pode me chamar no whats
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 29,May 08:47:06</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel, bom dia!
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 29,May 08:47:39</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  O sino no alto da página não para de piscar e não tem nada dentro.
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 29,May 11:08:33</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  deve ser sua lista de atividades que vc cadastrou
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 29,May 11:34:50</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  hum....
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 29,May 11:35:29</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Ele fica acusando mesmo que ainda vá vencer?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 29,May 11:36:16</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  outra coisa, elas ficarão salvas que possamos puxa-las?
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 29,May 11:55:41</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  sim, clicando em mostrar concluidos
                  </div>

                  <div class="direct-chat-msg right" style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> gabriel</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 29,May 11:55:57</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  eu deixei o alerta por que é bom saber que tem algo na lista, caso esqueça
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> camila</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 08,Jul 09:32:00</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  gabriel está dando erro no Qrcode
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 06,Nov 14:28:43</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Oi
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 29,Jan 14:47:48</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 29,Jan 14:48:04</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Criei uma pasta em uma obra e ela não quer aparecer
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 02,Feb 08:41:25</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Gabriel, bom dia! Na obra 6429 não consigo ticar confirmando minha ciencia qto a obra
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Feb 16:53:26</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Silvio/ Anderson, vcs farão visita à obra Shopping Metropole - Riacguelo?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 12,Mar 13:01:44</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Boa tarde! Alguém poderia criar um login para Adriane, não estou conseguindo
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 12,Mar 16:01:44</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Login aqui no Sistema Land?
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Mar 08:57:45</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  eu faço
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> marcos</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Mar 09:00:35</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  vc ja tinha criado 3 vezes kkk
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> adriane</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Mar 09:04:41</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  senha 123cena
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> leo martins</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Mar 09:10:57</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  Eita....
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Mar 12:34:43</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  sim , mas foi kkk desculpa kkk
                  </div>

                  <div class="direct-chat-msg " style="margin-bottom:0px">
                      <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left" style="margin-top:10px"> arianne</span>
                      <span class="direct-chat-timestamp pull-right" style="margin-top:10px"> 15,Mar 12:34:50</span>
                  </div>
                  <div class="direct-chat-text" style="margin: 1px 1px 1px 1px">
                  obrigdaaa
                  </div>
                  </div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>

              </div>
              <div class="box-footer">
                <form action="http://www2.cena.com.br/ajax/newMensageChat" id="newMensageChat" method="post">
                  <div class="input-group">
                    <input type="text" name="message" placeholder="nova mensagem" class="form-control">
                    <span class="input-group-btn">
                      <button type="submit" id="buttonChat" class="btn btn-info btn-flat">Enviar</button>
                    </span>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>


    <aside class="control-sidebar control-sidebar-dark" id="notepad" style="background: #f1f1f1;">

      <div class="tab-content">

        <h3 style="color:#000">Bloco de notas</h3>
                      <textarea id="story" style="color:#000; padding: 18px 9px;resize: none;" name="story" rows="30" cols="93"></textarea>

        <div>
          <span id="saveding" style="color:#000; display: none;"> salvando...</span>
          <span id="saved" style="color:#000; display: none;"> salvo</span>

        </div>

    </div></aside>



    <aside class=" control-sidebar-dark control-sidebar-open" style="display:none;position: absolute;top: 0;right: 5px;width: 21%;margin-top: 100px;max-height: 531px;">
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane" id="control-sidebar">

        </div>
      </div>
    </aside>



    <div class="modal fade" id="pesquisaGlobalModal" tabindex="-1" role="dialog" aria-labelledby="pesquisaGlobalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="pesquisaGlobalLabel">Pesquisa Global</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="">Digite sua pesquisa</label>

              <div class="input-group margin">
                <input type="text" class="form-control" id="pesquisaGlobalInput" name="pesquisaGlobalInput">
                <span class="input-group-btn">
                  <button type="button" id="pesquisaGlobalButton" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="box ">
                  <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                  </div>
                  <div class="box-body" id="listPesquisa">
                    <div class="overlay" id="carregando" style="display:none">
                      <i class="fa fa-refresh fa-spin"></i>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>


    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {

          $("#control-side_meu").slideToggle("slow");
          $("#goaway").fadeOut().empty();
        }, 3000);

      }, false);



      function verificarNotificacao() {

        $.ajax({
          url: BASE_URL + 'ajax/verificarMensagem',
          type: 'POST',
          dataType: 'json',
          success: function(json) {

            if (json.quantidade > 0) {
              $('.notificacao-mensagem').html(json.quantidade);
              $(".notificacao-mensagem").addClass("fa-blink")

            } else {
              $('.notificacao-mensagem').html('0');
              $('.notificacao-mensagem-header').html('Você não tem nenhuma notificação');
            }

          }
        });

      }

      $(function() {

        //setInterval(verificarNotificacao, 50000);
        //verificarNotificacao();

        $('.drop-notific').on('click', function() {
          $('.notificacao-mensagem').removeClass('fa-blink');

        });

        $('.addNotif').on('click', function() {
          $.ajax({
            url: 'add.php'
          });
        });

      });
    </script>

    <script src="http://www2.cena.com.br/node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/plugins/datatables/jquery.dataTables.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/dist/js/adminlte.min.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/dist/js/demo.js"></script>
    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/bower_components/select2/dist/js/select2.full.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">
    <script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
    <script src="http://www2.cena.com.br/assets/js/validateJquery/dist/jquery.validate.min.js"></script>

    <script src="http://www2.cena.com.br/assets/css/AdminLTE-2.4.5/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

    <script type="text/javascript">
      //$(document).ready(function() {
      //  var contagem = 0;
      //
      //  $(document).keyup(function(e) {
      //
      //    if (e.wich == 17 || e.keyCode == 17) {
      //      contagem++
      //    }
      //    if (contagem == 5) {
      //      contagem = 0;
      //      $('#pesquisaGlobalModal').modal('show');
      //    }
      //  })
      //})
      var count = 0;
      $(document).ready(function() {
        var count = 0;

        function clicou() {
          count = 0
        }
        $(document).keyup(function(e) {
          e.preventDefault();
          if (e.wich == 17 || e.keyCode == 17) {
            count++
          }
          if (count == 4) {
            count = 0;
            $('#pesquisaGlobalModal').modal('show');
          }
        })
        setInterval(function() {
          clicou()
        }, 2000);
      })








      var BASE_URL = 'http://www2.cena.com.br/';
      var temporiza;
      $("#story").on("input", function() {

        $("#saveding").show();
        $("#saved").hide();

        clearTimeout(temporiza);

        var text = $("#story").val();

        temporiza = setTimeout(function() {
          $.ajax({
            url: BASE_URL + 'ajax/saveNotepad',
            type: 'POST',
            data: {
              text: text,

            },
            dataType: 'json',
            success: function(json) {
              $("#saveding").hide();
              $("#saved").show();
            }
          });

        }, 2500);
      });
    </script>




    <script>
            var cont = 1;
        mensagem();

        function mensagem() {
          if (cont == 1) {
            getMensageNaoLidas()
            getMensage()
            verificarNotificacao()
          }
        }
        setInterval("mensagem()", 10000);
        </script>



    <script type="text/javascript">
      var save_method;

      $(function() {

        $('#table').on('length.dt', function(e, settings, len) {
          localStorage.setItem('max_obras', len);
        });

        $('#table').on('page.dt', function() {
          var table = $('#table').DataTable();
          var info = table.page.info();
        });


      });
    </script>





  </body>

</html>
