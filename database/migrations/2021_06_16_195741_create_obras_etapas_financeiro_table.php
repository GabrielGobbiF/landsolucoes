<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObrasEtapasFinanceiroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obras_etapas_financeiro', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('etapa_id')->nullable();
            $table->unsignedBigInteger('obra_id')->nullable();

            $table->string('nome_etapa')->nullable();
            $table->enum('metodo_pagamento', ['%', 'R$'])->default('R$');
            $table->double('valor', 10, 2)->nullable();
            $table->double('valor_receber', 10, 2)->nullable();

            $table->timestamps();

            //$table->foreign('etapa_id')
            //    ->references('id')
            //    ->on('obras_etapas')
            //    ->onDelete('cascade');

            $table->foreign('obra_id')
                ->references('id')
                ->on('obras')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obras_etapas_financeiro');
    }
}
