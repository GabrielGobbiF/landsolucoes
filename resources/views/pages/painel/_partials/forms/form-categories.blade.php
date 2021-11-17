@csrf
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--nome">Nome</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name" value="{{ $category->name ?? old('name') }}" autocomplete="off" required>
        </div>
    </div>
</div>
