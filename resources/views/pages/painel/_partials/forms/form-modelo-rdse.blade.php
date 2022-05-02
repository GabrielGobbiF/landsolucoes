@csrf
<style>
    #inputs-form__rdse input {
        text-transform: uppercase
    }

</style>
<div class="row" id="inputs-form__rdse">
    <input type="hidden" value="{{ $rdse->id ?? '' }}" id="rdse_id">
    <input type="hidden" value="{{ $priceUps ?? '0' }}" id="price_ups">

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--description">Descrição</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="input--description"
                value="{{ $rdse->description ?? old('description') }}"
                autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--type">Tipo</label>
            <select name='type' class='form-control select2'>
                @foreach (config('admin.rdse.type') as $status)
                    <option
                        {{ isset($rdse) && $rdse->type == $status['name'] ? 'selected="selected"' : '' }}
                        value='{{ $status['name'] }}'>
                        {{ $status['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
