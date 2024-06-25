@extends('pages.painel.vehicles.portaria.app')

@section('content')
    <main role="main">
        <form id="form-register" role="form" class="needs-validation" action="{{ route('vehicles.portaria.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="veiculo_tipo" value="cena">

            <div class="row">

                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{ route('vehicles.portaria.register') }}" class="">
                                <div class="card widget-flat active">
                                    <div class="card-body text-center">
                                        <h5 class=" fw-normal mt-0">Veiculos Cena</h5>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-sm-6">
                            <a href="{{ route('vehicles.portaria.visitors.register') }}" class="">
                                <div class="card widget-flat">
                                    <div class="card-body text-center">
                                        <h5 class=" fw-normal">Veiculos Terceiros</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 text-center mb-4">
                    CONTROLE DE ENTRADA E SAÍDA DE VEÍCULO
                </div>

                <div class="col-md-12 mb-3">

                    <div class="row">
                        <div class="col-12">
                            <div class="form-check">
                                <input
                                       id="op1" {{ old('controlador') == 'josue augusto de oliveira' ? 'checked' : '' }} class="form-check-input"
                                       type="radio" name="controlador" value="josue augusto de oliveira" required />
                                <label class="form-check-label" for="op1"> {{ titleCase('josue augusto de oliveira') }} </label>
                            </div>
                            <div class="form-check">
                                <input
                                       id="op2" {{ old('controlador') == 'carlos alberto fernandes dos santos' ? 'checked' : '' }} class="form-check-input"
                                       type="radio" name="controlador" value="carlos alberto fernandes dos santos" required />
                                <label class="form-check-label" for="op2">
                                    {{ titleCase('carlos alberto fernandes dos santos') }}
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input
                                       id="op3" {{ old('controlador') == 'jose barbosa de menezes' ? 'checked' : '' }} class="form-check-input" type="radio"
                                       name="controlador" value="jose barbosa de menezes" required />
                                <label class="form-check-label" for="op3"> {{ titleCase('JOSE BARBOSA DE MENEZES') }}</label>
                            </div>

                            <div class="form-check">
                                <input
                                       id="op4" {{ old('controlador') == 'phillyp santos da silva' ? 'checked' : '' }} class="form-check-input"
                                       type="radio" name="controlador" value="phillyp santos da silva" required />
                                <label class="form-check-label" for="op4">
                                    {{ titleCase('phillyp santos da silva') }}
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
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
                        <label>Veiculo</label>
                        <select id="vehicle_id" name="vehicle_id" class="select2" required>
                            <option value="">Selecione</option>
                            @foreach ($vehicles as $vehicle)
                                <option {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }} required value="{{ $vehicle->id }}">
                                    {{ $vehicle->name }} - {{ $vehicle->board }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Motorista</label>
                        <select id="motorista_id" name="motorista_id" class="select2" required>
                            <option value="">Selecione</option>
                            @foreach ($drivers as $drive)
                                <option
                                        {{ old('motorista_id') == $drive->id ? 'selected' : '' }} required value="{{ $drive->id }}">
                                    {{ $drive->re }} - {{ $drive->name }}

                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="" class="form-label">Kilometragem</label>
                            <input id="" type="number" class="form-control" name="km" required value="{{ old('km') }}" />
                        </div>
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

                <div class="col-md-12 mt-3 mb-4">
                    <label for="" class="">Departamento</label>
                    <div class="row" style="    gap: 1rem;">
                        @foreach (config('admin.departamentos_veiculos') as $depVeic)
                            <div class="col-auto">
                                <div class="form-check">
                                    <input id="dep{{ $depVeic }}" {{ old('departamento') == $depVeic ? 'checked' : '' }} class="form-check-input"
                                           type="radio" name="departamento" value="{{ $depVeic }}" required />
                                    <label class="form-check-label" for="dep{{ $depVeic }}"> {{ $depVeic }} </label>
                                </div>
                            </div>
                        @endforeach
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
