<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_form_invoicings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('cnpj');
            $table->string('inscricao_estadual');
            $table->string('inscricao_municipal');
            $table->string('razao_social');
            $table->string('nome_fantasia');
            $table->string('endereco_cobranca');
            $table->string('email_financeiro');
            $table->string('email_engenheiro');
            $table->string('telefones');
            $table->string('nome_obra');
            $table->string('endereco_obra');
            $table->string('cno');
            $table->string('sfobras');
            $table->string('n_contrato_proposta');
            $table->string('n_pedido_os');
            $table->boolean('retencao_contratual');
            $table->boolean('isencao_iss');
            $table->text('observations')->nullable();
            $table->date('data_preenchimento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_form_invoicings');
    }
};
