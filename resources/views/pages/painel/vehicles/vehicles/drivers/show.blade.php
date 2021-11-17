@extends('app')

@section('title', 'Cadastrar Veiculo')

@section('content')
    <h1 class="text-center">Editar Motorista</h1>
    <div class="card mt-3">
        <form role="form" class="needs-validation" novalidate id="form-driver" autocomplete="off" action="{{ route('vehicles.drivers.update', $user->id) }}" method="POST">
            @csrf
            @method('put')
            <h4 class="header mt-0 pt-3 pl-3">Dados</h4>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="input--name">Nome</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name" value="{{ $user->name ?? old('name') }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="input--username">Username</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="input--username" value="{{ $user->username ?? old('username') }}"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="input--email">Email</label>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="input--email" value="{{ $user->email ?? old('email') }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <span class="">a senha padrão será cena1234</span>
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="form-group">
                            <label for="input--cnh">CNH</label>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="cnh_check" name="cnh" value="1"
                                        {{ isset($user->cnh) && $user->cnh == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cnh_check">
                                        Sim
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 {{ isset($user->cnh) && $user->cnh != 0 ? '' : 'd-none' }} div--cnh_number">
                        <div class="form-group">
                            <label for="input--cnh_number">CNH Nº</label>
                            <input type="text" name="cnh_number" class="form-control @error('cnh_number') is-invalid @enderror"
                                id="input--cnh_number" value="{{ $user->cnh_number ?? old('cnh_number') }}">
                        </div>
                    </div>
                    <div class="col-md-3 {{ isset($user->cnh) && $user->cnh != 0 ? '' : 'd-none' }} div--cnh_validity">
                        <div class="form-group">
                            <label for="input--cnh_validity">CNH Validade</label>
                            <input type="text" name="cnh_validity" class="form-control date @error('cnh_validity') is-invalid @enderror"
                                id="input--cnh_validity" value="{{ $user->cnh_validity ?? old('cnh_validity') }}">
                        </div>
                    </div>
                    <div class="col-md-3 {{ isset($user->cnh) && $user->cnh != 0 ? '' : 'd-none' }} div--cnh_validity">
                        <div class="form-group">
                            <label for="input--cnh_category">Categoria</label>
                            <input type="text" max="3" name="cnh_category" class="form-control @error('cnh_category') is-invalid @enderror"
                                id="input--cnh_category" value="{{ $user->cnh_category ?? old('cnh_category') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <input type="submit" class="btn btn-primary"
                    onclick="this.disabled = true; this.value = 'Salvando…'; this.form.submit();" value="Salvar">
            </div>
        </form>
    </div>
@stop
