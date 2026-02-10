<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portarias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id'); //id do usuário (porteiro)
            $table->integer('motorista_id');
            $table->integer('vehicle_id');
            $table->string('observations')->nullable();
            $table->string('rms')->nullable();
            $table->longText('file')->nullable();
            $table->string('base')->nullable();
            $table->enum('type', ['saida', 'retorno'])->default('saida');

            $table->string('veiculo_tipo')->default('cena');
            $table->string('veiculo_placa')->nullable();
            $table->string('veiculo_nome')->nullable();
            $table->string('motorista')->nullable();


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
        Schema::dropIfExists('portarias');
    }
}
