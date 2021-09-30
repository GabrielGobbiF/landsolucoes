<div class='modal' id='modal-update-obra' tabindex='-1' role='dialog'>
    <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
        <div class='modal-content'>
            <form id='form-update-obra' role='form' class='needs-validation' action='{{ route('obras.update', $obra->id) }}' method='POST'>
                @csrf
                @method('put')
                <div class='modal-header'>
                    <h5 class='modal-title'>Obra {{ $obra->name }}</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-7">
                            <div class="form-group">
                                <label for="input--razao_social">Razão Social</label>
                                <input type="text" name="razao_social" class="form-control @error('razao_social') is-invalid @enderror" id="input--razao_social"
                                    value="{{ $obra->razao_social ?? old('razao_social') }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="input--build_at">Data Criação</label>
                                <input type="text" name="build_at" class="form-control date" id="input--build_at" value="{{ return_format_date($obra->build_at, 'pt', '/') ?? old('build_at') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-group">
                                <label for="input--id">ID</label>
                                <input type="text" class="form-control" disabled readonly id="input--id" value="{{ $obra->id }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="input--concessionaria_id">Concessionaria</label>
                                <input type="text" name="concessionaria_id" class="form-control" readonly disabled id="input--concessionaria_id"
                                    value="{{ $obra->concessionaria->name }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="input--service_id">Tipo de Obra/Serviço</label>
                                <input type="text" name="service_id" class="form-control" disabled readonly id="input--service_id" placeholder="Tipo de Obra/Serviço"
                                    value="{{ $obra->service->name }}">
                            </div>
                        </div>
                    </div>

                    <hr class="my-2">
                    <div class="box box-default box-solid">
                        <div class="box-header">
                            <h3 class="box-title">Cliente {{ $obra->client->company_name }}</h3>
                        </div>

                        <div class="box-body">
                            <div class="row department">
                                <input type="hidden" id="input--departmentId" value="{{ $obra->departments_id }}">
                                <div class="col-md-3">
                                    <div class='form-group'>
                                        <label>Responsável</label>
                                        <select name='department_id' id="select--department_id" class='form-control select2'>
                                            <option value='' selected>Selecione</option>
                                            @foreach ($clientsDepartaments as $departmentResponse)
                                                <option {{ isset($obraDepartamentoCliente) && $obraDepartamentoCliente->id == $departmentResponse->id ? 'selected' : '' }}
                                                    value='{{ $departmentResponse->id }}'>{{ $departmentResponse->dep_responsavel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="input--dep_telefone_celular">Celular</label>
                                        <input type="text" class="form-control departments" id="input--dep_telefone_celular" disabled
                                            value="{{ $obraDepartamentoCliente->dep_telefone_celular ?? old('dep_telefone_celular') }}" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="input--dep_telefone_fixo">Telefone</label>
                                        <input type="text" class="form-control departments" id="input--dep_telefone_fixo" disabled
                                            value="{{ $obraDepartamentoCliente->dep_telefone_fixo ?? old('dep_telefone_fixo') }}" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="input--dep_email">Email</label>
                                        <input type="text" class="form-control departments" disabled id="input--dep_email"
                                            value="{{ $obraDepartamentoCliente->dep_email ?? old('dep_email') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-default box-solid">
                        <div class="box-header">
                            <h3 class="box-title">Endereço</h3>
                        </div>

                        <div class="box-body">
                            @include('pages.painel._partials.forms.form_address')
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="input--cnpj">Razão Social da Obra</label>
                                        <input type="text" name="razao_social_obra_cliente" class="form-control" id="input--razao_social_obra_cliente" placeholder="Razão Social C"
                                            value="{{ $obra->razao_social_obra_cliente }}">
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="input--cnpj">CNPJ</label>
                                        <input type="text" name="cnpj" class="form-control cnpj" id="input--cnpj" placeholder="CNPJ"
                                            value="{{ $obra->cnpj }}">
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="input--cno">CNO</label>
                                        <input type="text" name="cno" class="form-control" id="input--cno" value="{{ $obra->cno != '' ? $obra->cno : $address->inscEstado }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-primary btn-submit'>Salvar</button>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>
