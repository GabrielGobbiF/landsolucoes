@csrf
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--name">Nome</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="input--name"
                value="{{ $epi->name ?? old('name') }}" autocomplete="off">
        </div>
    </div>
</div>
