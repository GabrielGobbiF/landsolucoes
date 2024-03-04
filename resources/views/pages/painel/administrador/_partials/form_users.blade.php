@csrf
<input id="user_id" type="hidden" value="{{ $user->id ?? '' }}" />
<div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="input--name">Nome</label>
                <input id="input--name" type="text" name="name"
                       {{ isset($user->id) && (Auth::user()->id == $user->id || Auth::user()->hasRole('admin')) ? '' : 'disabled' }}
                       class="form-control @error('name') is-invalid @enderror" value="{{ $user->name ?? old('name') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="input--name">Usuario</label>
                <input id="input--username" type="text" name="username"
                       {{ isset($user->id) && (Auth::user()->id == $user->id || Auth::user()->hasRole('admin')) ? '' : 'disabled' }}
                       class="form-control @error('username') is-invalid @enderror" value="{{ $user->username ?? old('username') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="input--email">Email</label>
                <input id="input--email" type="text" name="email"
                       {{ isset($user->id) && (Auth::user()->id == $user->id || Auth::user()->hasRole('admin')) ? '' : 'disabled' }}
                       class="form-control @error('email') is-invalid @enderror" value="{{ $user->email ?? old('email') }}" autocomplete="off">
                <div class="invalid-feedback">
                    email </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="input--telefone_celular">Telefone</label>
                <input id="input--telefone_celular" type="text" name="telefone_celular"
                       {{ isset($user->id) && (Auth::user()->id == $user->id || Auth::user()->hasRole('admin')) ? '' : 'disabled' }}
                       class="form-control @error('telefone_celular') is-invalid @enderror" value="{{ $user->telefone_celular ?? old('telefone_celular') }}"
                       autocomplete="off">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="input--type">Tipo de Usuário</label>
                <select id="input--type" class="select2 form-control" required multiple name="roles[]"
                        {{ Request::user()->hasRole('admin') ? '' : 'disabled' }}>
                    @foreach ($roles as $role)
                        <option {{ isset($roles_user) && in_array($role['name'], $roles_user) ? 'selected' : '' }} value="{{ $role['id'] }}">
                            {{ $role['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="input--re">RE</label>
                <input id="input--re" type="text" name="re" class="form-control" value="{{ $user->re }}" autocomplete="autocomplete_off_randString"
                       list="autocompleteOff">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="input--type">Senha (deixe vazio se não quiser trocar)</label>
                <input id="input--password" type="password" name="password" class="form-control" value="" autocomplete="autocomplete_off_randString"
                       list="autocompleteOff">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 mg-t-10">
            <div class="custom-control custom-switch">
                <input id="input--is_active" type="checkbox" name="is_active" class="custom-control-input"
                       {{ isset($user->is_active) && $user->is_active == '0' ? 'checked' : '' }} value="0">
                <label class="custom-control-label" for="input--is_active">Ativo</label>
            </div>
        </div>

        <div class="col-md-2 mg-t-10">
            <div class="custom-control custom-switch">
                <input id="input--email_verified_at" type="checkbox" name="email_verified_at"
                       {{ isset($user->id) && (Auth::user()->id == $user->id || Auth::user()->hasRole('admin')) ? '' : 'disabled' }}
                       class="custom-control-input" {{ isset($user->email_verified_at) && $user->email_verified_at != '' ? 'checked' : '' }} value="1">
                <label class="custom-control-label" for="input--email_verified_at">Email Verificado</label>
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

    <a href="{{ route('user.auth', $user->id) }}" class="btn btn-outline-secondary">Visualizar conta</a>
</div>
