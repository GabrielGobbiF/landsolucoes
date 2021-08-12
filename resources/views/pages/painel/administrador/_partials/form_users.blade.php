@csrf
<input type="hidden" id="user_id" value="{{ $user->id ?? '' }}" />
<div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="input--name">Nome</label>
                <input type="text" name="name" {{ isset($user->id) && (Auth::user()->id == $user->id || Auth::user()->hasRole('admin')) ? '' : 'disabled' }}
                    class="form-control @error('name') is-invalid @enderror" id="input--name"
                    value="{{ $user->name ?? old('name') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="input--name">Usuario</label>
                <input type="text" name="username" {{ isset($user->id) && (Auth::user()->id == $user->id || Auth::user()->hasRole('admin')) ? '' : 'disabled' }}
                    class="form-control @error('username') is-invalid @enderror" id="input--username"
                    value="{{ $user->username ?? old('username') }}" autocomplete="off">

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="input--email">Email</label>
                <input type="text" name="email" {{ isset($user->id) && (Auth::user()->id == $user->id || Auth::user()->hasRole('admin')) ? '' : 'disabled' }}
                    class="form-control @error('email') is-invalid @enderror" id="input--email"
                    value="{{ $user->email ?? old('email') }}" autocomplete="off">
                <div class="invalid-feedback">
                    email </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="input--telefone_celular">Telefone</label>
                <input type="text" name="telefone_celular" {{ isset($user->id) && (Auth::user()->id == $user->id || Auth::user()->hasRole('admin')) ? '' : 'disabled' }}
                    class="form-control @error('telefone_celular') is-invalid @enderror"
                    id="input--telefone_celular"
                    value="{{ $user->telefone_celular ?? old('telefone_celular') }}"
                    autocomplete="off">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="input--type">Tipo de Usuário</label>
                <select class="select2Multiple form-control" required multiple id="input--type"
                    name="roles[]" {{ Request::user()->hasRole('admin') ? '' : 'disabled' }}>
                    @foreach ($roles as $role)
                        <option {{ isset($roles_user) && in_array($role['name'], $roles_user) ? 'selected' : '' }} value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="input--type">Senha (deixe vazio se não quiser trocar)</label>
                <input type="password" name="password"
                    class="form-control"
                    id="input--password"
                    value=""
                    autocomplete="autocomplete_off_randString"
                    list="autocompleteOff">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 mg-t-10">
            <div class="custom-control custom-switch">
                <input type="checkbox" name="is_active" class="custom-control-input"
                    id="input--is_active" {{ isset($user->is_active) && $user->is_active == '0' ? 'checked' : '' }} value="0">
                <label class="custom-control-label" for="input--is_active">Ativo</label>
            </div>
        </div>

        <div class="col-md-2 mg-t-10">
            <div class="custom-control custom-switch">
                <input type="checkbox" name="email_verified_at" {{ isset($user->id) && (Auth::user()->id == $user->id || Auth::user()->hasRole('admin')) ? '' : 'disabled' }}
                    class="custom-control-input"
                    id="input--email_verified_at" {{ isset($user->email_verified_at) && $user->email_verified_at != '' ? 'checked' : '' }} value="1">
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
</div>
