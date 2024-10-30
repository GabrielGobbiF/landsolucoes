@csrf
<div class="row">

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--name">Name</label>
            <input id="input--name" type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ $equipe->name ?? old('name') }}">
        </div>
    </div>

</div>
