@csrf
<div class="row g-5 mb-3">
    <div class="col-12 col-md-10 col-xl-12 col-xxl-12">
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="input-item_name">Nome</label>
            <div class="col-sm-10">
                <input id="input-item_name" class="form-control" type="text" name="name" value="{{ isset($inventory) ? $inventory->name : old('name') }}" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="unit">Unidade</label>
            <div class="col-sm-10">
                <select id="select-unit" name="unit" class="form-control" required>
                    @foreach (config('admin.unidade') as $medida)
                        <option {{ isset($inventory) && $inventory->unit == $medida ? 'selected' : null }}
                                {{ old('unit') == $medida['name'] ? 'selected' : null }} value="{{ $medida['name'] }}">
                            {{ $medida['name'] }}</option>
                    @endforeach
                </select>
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="code_omie">Código</label>
            <div class="col-sm-10">
                <input id="input-code_omie" class="form-control" type="text" name="code_omie" value="{{ isset($inventory) ? $inventory->code_omie : old('code_omie') }}" />
                <div class="mb-3 row"></div>
            </div>

        </div>

        <div class="my-5 mt-5"></div>

        <h4 class="mb-3">Inventário</h4>

        <div class="col-12 col-lg-12 mt-4">
            <label class="mb-2 text-body-highlight">Estoque de abertura</label>
            <input class="form-control" type="number" name="opening_stock" value="{{ isset($inventory) ? $inventory->opening_stock : old('opening_stock') ?? 0 }}" required />
        </div>

        <div class="col-12 col-lg-12 mt-4">
            <label class="mb-2 text-body-highlight">Ponto de Reabastecimento</label>
            <input class="form-control" type="number" name="refueling_point" value="{{ isset($inventory) ? $inventory->refueling_point : old('refueling_point') ?? 0 }}" required />
        </div>
    </div>
</div>
