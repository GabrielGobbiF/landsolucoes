@csrf
<style>
    #inputs-form__rdse input {
        text-transform: uppercase
    }

</style>
<div class="row" id="inputs-form__rdse">
    <input type="hidden" value="{{ $rdse->id ?? '' }}" id="rdse_id">
    <input type="hidden" value="{{ $priceUps ?? '0' }}" id="price_ups">

    <input type="hidden" value="{{ $rdse->parcial_1 }}" id="parcial_1">
    <input type="hidden" value="{{ $rdse->parcial_2 }}" id="parcial_2">
    <input type="hidden" value="{{ $rdse->parcial_3 }}" id="parcial_3">

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
            <label for="input--solicitante">Solicitante</label>
            <input type="text" name="solicitante" class="form-control @error('solicitante') is-invalid @enderror" id="input--solicitante"
                value="{{ !empty($rdse->solicitante) ? $rdse->solicitante : old('solicitante') ?? 'Marcos' }}"
                autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--n_order">Nº de Ordem</label>
            <input type="text" name="n_order" class="form-control @error('n_order') is-invalid @enderror" id="input--n_order" value="{{ $rdse->n_order ?? old('n_order') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--equipe">Equipe</label>
            <input type="text" name="equipe" class="form-control @error('equipe') is-invalid @enderror" id="input--equipe" value="{{ $rdse->equipe ?? old('equipe') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--at">Data</label>
            <input type="text" name="at" class="form-control @error('at') is-invalid @enderror date"
                id="input--at"
                value="{{ !empty($rdse->at) ? dataLimpa($rdse->at) : old('at') ?? date('d/m/Y') }}"
                autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
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
