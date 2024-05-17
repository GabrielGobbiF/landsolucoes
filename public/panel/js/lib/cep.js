
/*
<div class=" col-md-12 card mg-b-20 mg-lg-b-25">
    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
        <h6 class="tx-uppercase tx-semibold mg-b-0">Endereço</h6>
    </div>
    <div class="card-body pd-20 pd-lg-25 form-row">
        <div class="form-group col-md-3">
            <label for="inputcep">Cep</label>
            <input type="text" class="form-control" id="input_cep" name="endereco[cep]" maxlength="9" onblur="pesquisacep(this.value);" value="">
        </div>
        <div class="form-group col-md-7">
            <label for="inputrua">Rua</label>
            <input type="text" class="form-control" id="input--street" name="endereco[rua]" value="">
        </div>
        <div class="form-group col-md-2">
            <label for="inputnumero">Nº </label>
            <input type="text" class="form-control" id="input_numero" name="endereco[numero]" value="">
        </div>
        <div class="form-group col-md-4">
            <label for="inputcomplemento">Complemento</label>
            <input type="text" class="form-control" id="input_complemento" name="endereco[complemento]" value="">
        </div>
        <div class="form-group col-md-3">
            <label for="inputbairro">Bairro</label>
            <input type="text" class="form-control" id="input--district" name="endereco[bairro]" value="">
        </div>
        <div class="form-group col-md-3">
            <label for="inputcidade">Cidade</label>
            <input type="text" class="form-control" id="input--city" name="endereco[cidade]" value="">
        </div>

        <div class="form-group col-md-2">
            <label for="inputestado">Estado</label>
            <input type="text" class="form-control" id="input--state" name="endereco[estado]" value="">
        </div>

    </div>
</div>
<script src="cep.js"></script>
*/

function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('input--street').value = ('');
    document.getElementById('input--district').value = ('');
    document.getElementById('input--city').value = ('');
    document.getElementById('input--state').value = ('');
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('input--street').value = (conteudo.logradouro);
        document.getElementById('input--district').value = (conteudo.bairro);
        document.getElementById('input--city').value = (conteudo.localidade);
        document.getElementById('input--state').value = (conteudo.uf);

    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('input--street').value = "consultando";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = '//viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};



