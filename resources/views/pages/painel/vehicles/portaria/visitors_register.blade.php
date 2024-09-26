@extends('pages.painel.vehicles.portaria.app')

@section('content')
    <main role="main">
        <form id="form-register" role="form" class="needs-validation" action="{{ route('vehicles.portaria.visitors.create') }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="veiculo_tipo" value="terceiro">
            <div class="row">

                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('vehicles.portaria.register') }}" class="">
                                <div class="card widget-flat ">
                                    <div class="card-body text-center">
                                        <h5 class=" fw-normal mt-0">Veiculos Cena</h5>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-sm-6">
                            <a href="{{ route('vehicles.portaria.visitors.register') }}" class="">
                                <div class="card widget-flat active">
                                    <div class="card-body text-center">
                                        <h5 class=" fw-normal">Veiculos Terceiros</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 text-center mb-4">
                    CONTROLE DE ENTRADA E SAÍDA DE VEÍCULO TERCEIROS
                </div>

                <div class="col-md-12 mb-3">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-check">
                                <input
                                       id="op1" {{ old('controlador') == 'josue augusto de oliveira' ? 'checked' : '' }} class="form-check-input"
                                       type="radio" name="controlador" value="josue augusto de oliveira" required />
                                <label class="form-check-label" for="op1"> {{ titleCase('josue augusto de oliveira') }} </label>
                            </div>
                            <div class="form-check">
                                <input
                                       id="op2" {{ old('controlador') == 'valnei de almeida' ? 'checked' : '' }} class="form-check-input"
                                       type="radio" name="controlador" value="valnei de almeida" required />
                                <label class="form-check-label" for="op2">
                                    {{ titleCase('valnei de almeida') }}
                                </label>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-check">
                                <input
                                       id="op3" {{ old('controlador') == 'jose barbosa de menezes' ? 'checked' : '' }} class="form-check-input" type="radio"
                                       name="controlador" value="jose barbosa de menezes" required />
                                <label class="form-check-label" for="op3"> {{ titleCase('JOSE BARBOSA DE MENEZES') }}</label>
                            </div>

                            <div class="form-check">
                                <input
                                       id="op4" {{ old('controlador') == 'valdivino da silva' ? 'checked' : '' }} class="form-check-input"
                                       type="radio" name="controlador" value="valdivino da silva" required />
                                <label class="form-check-label" for="op4">
                                    {{ titleCase('valdivino da silva') }}
                                </label>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-check">
                                <input
                                       id="op5" {{ old('controlador') == 'magna calasans sousa' ? 'checked' : '' }} class="form-check-input" type="radio"
                                       name="controlador" value="magna calasans sousa" required />
                                <label class="form-check-label" for="op5">
                                    {{ titleCase('magna calasans sousa') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 my-4 d-flex justify-content-between">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input id="typeOption" {{ old('type') == 'saida' ? 'checked' : '' }} type="radio" name="type" value="saida" required>
                            </div>
                        </div>
                        <label class="form-control" for="typeOption">Saida</label>
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input
                                       id="typeOption2" {{ old('type') == 'retorno' ? 'checked' : '' }} type="radio" name="type" value="retorno" required>
                            </div>
                        </div>
                        <label class="form-control" for="typeOption2">Entrada</label>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Veiculo (Nome)</label>
                        <input id="" type="text" class="form-control" name="veiculo_nome" required value="{{ old('veiculo_nome') }}" required />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Veiculo (Placa)</label>
                        <input id="" type="text" class="form-control" name="veiculo_placa" required value="{{ old('veiculo_placa') }}" required />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Motorista</label>
                        <input id="" type="text" class="form-control" name="motorista" required value="{{ old('motorista') }}" required />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="" class="form-label">Finalidade</label>
                            <input id="" type="text" class="form-control" name="finality" required value="{{ old('finality') }}" required />
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="images">Fotos</label>
                        <input id="images" type="file" class="form-control-file" name="attachments[]" multiple accept='image/*'>
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="form-group">
                        <label for="observations">Observações</label>
                        <textarea id="observations" name="observations" cols="30" rows="4" class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <div id="div--button-submit" class="row justify-content-center mt-2">
                <button type="submit" class="btn btn-success">Enviar</button>
            </div>

        </form>


    </main>
@endsection
