@extends('app')

@section('title', 'Cadastrar Usuário')

@section('content')
    <div class="container">
        <h1 class="text-center">Novo Usuário</h1>
        <div class="card mt-3">
            <form role="form" class="needs-validation" enctype="multipart/form-data" novalidate id="form"
                autocomplete="off" novalidate="novalidate" action="{{ route('users.store') }}" method="POST">
                @csrf
                <input type="hidden" id="user_id" value="{{ $user->id ?? '' }}" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="input--name">Nome</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="input--name"
                                    value="{{ $user->name ?? old('name') }}" autocomplete="off">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="input--name">Usuario</label>
                                <input type="text" name="username"
                                    class="form-control @error('username') is-invalid @enderror" id="input--username"
                                    value="{{ $user->username ?? old('username') }}" autocomplete="off">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="input--email">Email</label>
                                <input type="text" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="input--email"
                                    value="{{ $user->email ?? old('email') }}" autocomplete="off">
                                <div class="invalid-feedback">
                                    email </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="input--telefone_celular">Telefone</label>
                                <input type="text" name="telefone_celular"
                                    class="form-control @error('telefone_celular') is-invalid @enderror"
                                    id="input--telefone_celular"
                                    value="{{ $user->telefone_celular ?? old('telefone_celular') }}" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input--type">Tipo de Usuário</label>
                                <select class="select2 form-control" required multiple id="input--type" name="roles[]">
                                    @foreach ($roles as $role)
                                        <option
                                            {{ isset($roles_user) && in_array($role['name'], $roles_user) ? 'selected' : '' }}
                                            value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input--type">Senha</label>
                                <input type="password" name="password" class="form-control" id="input--password"
                                    value="" autocomplete="autocomplete_off_randString" list="autocompleteOff">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    @if (Auth::user()->HasRole('admin') || Auth::user()->id == $user->id)
                        <button type="submit" class="btn btn-success">
                            <i class='fas fa-edit'></i> Salvar
                        </button>
                    @endif
                </div>

            </form>
        </div>
    </div>
@stop
