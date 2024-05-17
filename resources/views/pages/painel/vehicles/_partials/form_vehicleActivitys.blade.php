@csrf
<input type="hidden" id="vehicle_id" value="{{ $vehicle->id ?? '' }}" />
<input type="hidden" name="vehicle_activities" id="input--vehicle_activities" value="{{ $vehicle_activities->id ?? old('id') }}" autocomplete="off">

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pr-3 ">
    <h4 class="header mt-0 pt-3 pl-3">Nova Atividade</h4>
    <div class="tollbar btn-toolbar mb-2 mb-md-0 float-right">KM Atual: {{ $ultimaKM ?? '' }} </div>
</div>

<div class="card-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="input--title">Titulo</label>
                <select name="title" class="form-control w-100 select2 @error('title') is-invalid @enderror" id="input--title">
                    <option {{ old('title') == '' ? 'selected' : '' }} value="">Selecione</option>
                    <option {{ old('title') == 'galpao' ? 'selected' : '' }} value="galpao">Galpão</option>
                    <option {{ old('title') == 'cliente' ? 'selected' : '' }} value="cliente">Cliente</option>
                    <option {{ old('title') == 'obra' ? 'selected' : '' }} value="obra">Obra</option>
                    <option {{ old('title') == 'manutencao' ? 'selected' : '' }} value="manutencao">Manutenção</option>
                    <option {{ old('title') == 'abastecimento' ? 'selected' : '' }} value="abastecimento">Abrastecimento</option>
                    <option {{ old('title') == 'outros' ? 'selected' : '' }} value="outros">Outros</option>
                </select>
            </div>
        </div>
    </div>

    <div id="dados">
        <div class="row">
            <div class="col-md-5 d-none descricao">
                <div class="form-group">
                    <label for="input--description">Descrição</label>
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="input--description"
                        value="{{ $vehicle_activities->description ?? old('description') }}" autocomplete="off">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="input--km_start">KM</label>
                    <input type="text" name="km_start" class="form-control @error('km_start') is-invalid @enderror" id="input--km_start"
                        value="{{ $ultimaKM ?? old('km_start') }}"
                        autocomplete="off">
                    <input type="hidden" name="ultimaKM" value="{{ $ultimaKM ?? old('km_start') }}" autocomplete="off">
                    <div class="invalid-feedback">
                        KM precisa ser maior que o KM Atual
                    </div>
                </div>
            </div>

            <div class="col-md-5 d-none abastecimento">
                <label for="input--liters">Nota Fiscal</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" value="{{ $vehicle_activities->nota_fiscal ?? old('image') }}">
                    <label class="custom-file-label" for="customFile">Selecione</label>
                </div>
            </div>

            <!--<div class="col-md-3 mt-3">
                <div class="form-group">
                    <label for="input--created_at">Data</label>
                    <input type="text" name="created_at" disabled class="form-control datetime @error('created_at') is-invalid @enderror" id="input--created_at"
                        value="{{ $vehicle_activities->created_at ?? date('d/m/Y H:i:s') }}" autocomplete="off">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="input--driver_name">Motorista</label>
                    <input type="text" disabled class="form-control" value="{{ Auth::user()->name }}" autocomplete="off">
                </div>
            </div>-->
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="input--observation">Observação</label>
                    <textarea type="text" name="observation" class="form-control @error('observation') is-invalid @enderror"
                        id="input--observation">{{ $vehicle_activities->observation ?? '' }}</textarea>
                </div>
            </div>
        </div>
    </div>


    <input type="submit" class="btn btn-success d-none" id="btn-save-activiy"
        onclick="this.disabled = true; this.value = 'Salvando…'; this.form.submit();" value="Salvar">
</div>



<script>
    $(document).ready(function() {
        loadActivity();
        $('#input--title').on('change', function() {
            loadActivity();
        });
    });

    function loadActivity() {
        $('#abastecimento').addClass('d-none');
        $('#dados').addClass('d-none');
        $('#btn-save-activiy').addClass('d-none');

        var titulo = $('#input--title').select2('data');
        var coluna = titulo[0].id;

        if (coluna != 0) {
            switch (coluna) {
                case 'abastecimento':
                    $('.abastecimento').removeClass('d-none');
                    $('.descricao').addClass('d-none');

                    break
                case 'obra':
                    $('.abastecimento').addClass('d-none');
                    $('.descricao').removeClass('d-none');

                    break;
                case 'outros':
                    $('.abastecimento').addClass('d-none');
                    $('.descricao').removeClass('d-none');

                    break;
                default:
                    $('.abastecimento').addClass('d-none');
                    $('.descricao').removeClass('d-none');

                    break;
            }
            $('#dados').removeClass('d-none');
            $('#btn-save-activiy').removeClass('d-none');
        }
    }

</script>
