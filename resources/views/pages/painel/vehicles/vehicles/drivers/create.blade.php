@extends('app')

@section('title', 'Cadastrar Motorista')

@section('content')
    <h1 class="text-center">Novo Motorista</h1>
    <div class="card mt-3">
        <form role="form" class="needs-validation" novalidate id="form-driver" autocomplete="off" novalidate="novalidate" action="{{ route('vehicles.drivers.store') }}" method="POST">
            @csrf
            <input type="hidden" id="vehicle_id" value="{{ $vehicle->id ?? '' }}" />
            <h4 class="header mt-0 pt-3 pl-3">Dados</h4>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="input--name">Nome</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name" value="{{ $vehicle->name ?? old('name') }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="input--username">Username</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="input--username" value="{{ $vehicle->username ?? old('username') }}"
                                autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="input--email">Email</label>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="input--email" value="{{ $vehicle->email ?? old('email') }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="input--re">RE</label>
                            <input type="text" name="re" class="form-control @error('re') is-invalid @enderror" id="input--re" value="{{ $user->re ?? old('re') }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <span class="">a senha padrão será cena1234</span>
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
