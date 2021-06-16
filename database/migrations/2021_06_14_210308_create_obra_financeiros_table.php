<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObraFinanceirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obras_financeiro', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('id_obra');

            $table->double('valor_proposta', 10, 2);
            $table->double('valor_negociado', 10, 2);
            $table->double('valor_desconto', 10, 2);
            $table->double('valor_custo', 10, 2);
            $table->enum('metodo_pagamento', ['boleto', 'transferência'])->default('boleto');

            $table->timestamp('envio_at')->nullable();

            $table->foreign('id_obra')
                ->references('id')
                ->on('obras')
                ->onDelete('cascade');


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
        Schema::dropIfExists('obras_financeiro');
    }
}
