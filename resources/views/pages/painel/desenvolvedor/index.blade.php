@extends('app')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">RH</div>
                    <div class="card-body">
                        <div id="accordion" class="custom-accordion">
                            <div class="card mb-1 shadow-none">
                                <a href="#collapseOne" class="text-dark collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="collapseOne">
                                    <div id="headingOne" class="card-header">
                                        <h6 class="m-0">
                                            Alterar nome de documento em todos Funcionário
                                            <i class="mdi mdi-minus float-right accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
                                    <div class="card-body">
                                        <form id="form-alter-name-all-emp" role="form" class="needs-validation"
                                              action="{{ route('dev.alter.name.all.employee') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="de">De</label>
                                                <input id="input--de" type="text" class="form-control" name="de" autocomplete="off" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="para">Para</label>
                                                <input id="input--para" type="text" class="form-control" name="para" autocomplete="off" placeholder="">
                                            </div>
                                            <button class="btn btn-primary btn-submit">Salvar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-1 shadow-none">
                                <a href="#collapseTwo" class="text-dark collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="collapseTwo">
                                    <div id="headingTwo" class="card-header">
                                        <h6 class="m-0">
                                            Excluir Documento em todos os funcionarios
                                            <i class="mdi mdi-minus float-right accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        <form id="form-delet-all-emp" role="form" class="needs-validation" action="{{ route('dev.delete.name.all.employee') }}"
                                              method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Nome</label>
                                                <input id="input--name" type="text" class="form-control" name="name" autocomplete="off" placeholder="">
                                            </div>
                                            <button class="btn btn-primary btn-submit">Salvar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-0 shadow-none">
                                <a href="#collapseThree" class="text-dark collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="collapseThree">
                                    <div id="headingThree" class="card-header">
                                        <h6 class="m-0">
                                            Excluir documento em Array Auditoria
                                            <i class="mdi mdi-minus float-right accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <form id="form-delet-all-emp" role="form" class="needs-validation" action="{{ route('dev.delete.doc.auditory') }}"
                                              method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Nome</label>
                                                <input id="input--name" type="text" class="form-control" name="name" autocomplete="off" placeholder="">
                                            </div>
                                            <button class="btn btn-primary btn-submit">Salvar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-0 shadow-none">
                                <a href="#collapseFor" class="text-dark collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="collapseFor">
                                    <div id="headingThree" class="card-header">
                                        <h6 class="m-0">
                                            Alterar documento em Array Auditoria
                                            <i class="mdi mdi-minus float-right accor-plus-icon"></i>
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseFor" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <form id="form-alter-name-all-emp" role="form" class="needs-validation"
                                              action="{{ route('dev.alter.doc.auditory') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="de">De</label>
                                                <input id="input--de" type="text" class="form-control" name="de" autocomplete="off" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label for="para">Para</label>
                                                <input id="input--para" type="text" class="form-control" name="para" autocomplete="off" placeholder="">
                                            </div>
                                            <button class="btn btn-primary btn-submit">Salvar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card text-start">
                    <div class="card-body">
                        <h4 class="card-title">Subir Planilha Condutores</h4>
                        <a class="btn btn-secondary" href="{{ route('dev.script.condutores') }}" target="_blank">
                            Subir
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
