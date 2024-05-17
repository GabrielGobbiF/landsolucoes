<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRdseServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdse_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rdse_id');
            $table->unsignedBigInteger('codigo_sap')->nullable();

            $table->time('chegada')->nullable();                // Data de chegada;
            $table->time('saida')->nullable();                  // Data de saida;
            $table->integer('minutos')->default('0');           // Qnt de Minutos;
            $table->time('horas')->nullable();                  // Qnt de Horas;
            $table->longtext('description')->nullable();        // Descrição;
            $table->integer('qnt_atividade')->default('0');     // Quantidade de atividade ou qnt de horas;
            $table->double('preco', 10, 2)->default('0');
            $table->string('type')->nullable();                 // emergencia, espera
            $table->integer('order')->default('0');             // Ordem da atividade

            $table->integer('p_quantidade1')->default('0');     // Quantidade Parcial 1;
            $table->double('p_preco1', 10, 2)->default('0');    // Preço Parcial 1;

            $table->integer('p_quantidade2')->default('0');     // Quantidade Parcial 2;
            $table->double('p_preco2', 10, 2)->default('0');    // Preço Parcial 2;

            $table->integer('p_quantidade3')->default('0');     // Quantidade Parcial 3;
            $table->double('p_preco3', 10, 2)->default('0');    // Preço Parcial 3;

            $table->timestamps();

            $table->foreign('codigo_sap')
                ->references('id')
                ->on('handsworks');

            $table->foreign('rdse_id')
                ->references('id')
                ->on('rdses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rdses');
    }
}
