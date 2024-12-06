@csrf
<style>
    #inputs-form__rdse input {
        text-transform: uppercase
    }
</style>

<div id="inputs-form__rdse" class="row">
    <input id="rdse_id" type="hidden" value="{{ $rdse->id ?? '' }}">
    <input id="price_ups" type="hidden" value="{{ $priceUps ?? '0' }}">

    <input id="parcial_1" type="hidden" value="{{ $rdse->parcial_1 ?? 0 }}">
    <input id="parcial_2" type="hidden" value="{{ $rdse->parcial_2 ?? 0 }}">
    <input id="parcial_3" type="hidden" value="{{ $rdse->parcial_3 ?? 0 }}">
    <input id="rdse-status" type="hidden" value="{{ $rdse->status ?? '' }}">

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--description">Descrição / Endereço</label>
            <input id="input--description" type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                   value="{{ $rdse->description ?? old('description') }}" autocomplete="off" required>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--type">Tipo</label>
            <select name='type' class='form-control select2'>
                @foreach (config('admin.rdse.type') as $status)
                    <option
                            {{ isset($rdse) && $rdse->type == $status['name'] ? 'selected="selected"' : '' }} value='{{ $status['name'] }}'>
                        {{ $status['name'] }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="input--solicitante">Solicitante</label>
            <input id="input--solicitante" type="text" name="solicitante" class="form-control @error('solicitante') is-invalid @enderror"
                   value="{{ !empty($rdse->solicitante) ? $rdse->solicitante : old('solicitante') ?? 'Marcos' }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="input--n_order">Nº de Ordem</label>
            <input id="input--n_order" type="text" name="n_order" class="form-control @error('n_order') is-invalid @enderror"
                   value="{{ $rdse->n_order ?? old('n_order') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label for="input--equipe">Nº de Nota</label>
            <input id="input--equipe" type="text" name="equipe" class="form-control @error('equipe') is-invalid @enderror"
                   value="{{ $rdse->equipe ?? old('equipe') }}" autocomplete="off">
        </div>
    </div>


</div>

<div class="row">
    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="input--at">Data</label>
            <input id="input--at" type="text" name="at" class="form-control @error('at') is-invalid @enderror date"
                   value="{{ !empty($rdse->at) ? dataLimpa($rdse->at) : old('at') ?? date('d/m/Y') }}" autocomplete="off">
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="form-group">
            <label for="input--at">Data Mês</label>
            <select id="mes" name="month_date" class="form-control" required>
                <option>Selecione</option>
                <option {{ isset($rdse) && $rdse->Month == '01' ? 'selected' : null }} value="01">Janeiro </option>
                <option {{ isset($rdse) && $rdse->Month == '02' ? 'selected' : null }} value="02">Fevereiro </option>
                <option {{ isset($rdse) && $rdse->Month == '03' ? 'selected' : null }} value="03">Março </option>
                <option {{ isset($rdse) && $rdse->Month == '04' ? 'selected' : null }} value="04">Abril </option>
                <option {{ isset($rdse) && $rdse->Month == '05' ? 'selected' : null }} value="05">Maio </option>
                <option {{ isset($rdse) && $rdse->Month == '06' ? 'selected' : null }} value="06">Junho </option>
                <option {{ isset($rdse) && $rdse->Month == '07' ? 'selected' : null }} value="07">Julho </option>
                <option {{ isset($rdse) && $rdse->Month == '08' ? 'selected' : null }} value="08">Agosto </option>
                <option {{ isset($rdse) && $rdse->Month == '09' ? 'selected' : null }} value="09">Setembro </option>
                <option {{ isset($rdse) && $rdse->Month == '10' ? 'selected' : null }} value="10">Outubro </option>
                <option {{ isset($rdse) && $rdse->Month == '11' ? 'selected' : null }} value="11">Novembro </option>
                <option {{ isset($rdse) && $rdse->Month == '12' ? 'selected' : null }} value="12">Dezembro </option>
            </select>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <label>Ano </label>
        <select id="mes" name="year" class="form-control " required>
            <option selected value="">Selecione</option>
            <option {{ isset($rdse) && $rdse->Year == '2024' ? 'selected' : null }} value="2024">2024 </option>
            <option {{ isset($rdse) && $rdse->Year == '2025' ? 'selected' : null }} value="2025">2025 </option>
        </select>
    </div>
</div>

<div class="row">


    @if (!empty($rdse->nf))
        <div class="col-12">
            <div class='card'>
                <div class='card-body row'>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="input--nf">Nota Fiscal</label>
                            <input id="input--nf" type="text" name="nf" class="form-control @error('nf') is-invalid @enderror"
                                   value="{{ !empty($rdse->nf) ? $rdse->nf : old('nf') }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="input--date_nfe_at">Data</label>
                            <input id="input--date_nfe_at" type="text" name="date_nfe_at" class="form-control date"
                                   value="{{ !empty($rdse->date_nfe_at) ? return_format_date($rdse->date_nfe_at) : old('date_nfe_at') ?? date('d/m/Y') }}"
                                   autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
