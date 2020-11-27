@csrf
<input type="hidden" id="role_id" value="{{ $role->id ?? '' }}" />
<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="input--name">Nome</label>
                <input type="text" name="name" disabled class="form-control @error('name') is-invalid @enderror" id="input--name"
                    value="{{ $role->name ?? old('name') }}" autocomplete="off">
            </div>
        </div>
        @foreach ($all_groups as $groups)
            <div class="col-md-4 mg-t-20">
                <h1> {{ $groups['title'] }} </h1>
                @foreach ($groups['permissions'] as $permission)
                    <div class="col-md-12 ">
                        <input type="checkbox" name="permissions[]" {{ in_array($permission['name'], $rolePermissions) ? 'checked' : '' }} value="{{ $permission['id'] }}">
                        <label for="">{{ $permission['name'] }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-success">
        <i class='fas fa-edit'></i> Salvar
    </button>
</div>
