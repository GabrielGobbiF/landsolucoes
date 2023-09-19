@csrf
<div class="row">

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--linha">Linha</label>
            <input type="text" name="linha" class="form-control @error('linha') is-invalid @enderror sp_celphones" id="input--linha" value="{{ $celular->linha ?? old('linha') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--usuario">Usuário</label>
            <input type="text" name="usuario" class="form-control @error('usuario') is-invalid @enderror" id="input--usuario" value="{{ $celular->usuario ?? old('usuario') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--equipe">Equipe</label>
            <input type="text" name="equipe" class="form-control @error('equipe') is-invalid @enderror" id="input--equipe" value="{{ $celular->equipe ?? old('equipe') }}" autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="input--responsavel">Responsável</label>
            <input type="text" name="responsavel" class="form-control @error('responsavel') is-invalid @enderror" id="input--responsavel" value="{{ $celular->responsavel ?? old('responsavel') }}"
                autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="select-departamento">Departamento</label>
            <select name='departamento' class='form-control select2'>
                <option value='' selected>Selecione</option>
                @foreach (config('admin.celulares.departamento') as $celularrow)
                    <option {{ isset($celular) && $celular->departamento == $celularrow ? 'selected' : '' }} value='{{ $celularrow }}'>
                        {{ $celularrow }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--centro_custo">Centro de Custo</label>
            <input type="text" name="centro_custo" class="form-control @error('centro_custo') is-invalid @enderror" id="input--centro_custo"
                value="{{ $celular->centro_custo ?? old('centro_custo') }}"
                autocomplete="off">
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label for="input--imei">IMEI</label>
            <input type="text" name="imei" class="form-control @error('imei') is-invalid @enderror" id="input--imei"
                value="{{ $celular->imei ?? old('imei') }}"
                autocomplete="off">
        </div>
    </div>
</div>
