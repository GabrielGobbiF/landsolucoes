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
            $table->longText('file')->nullable();
            $table->enum('type', ['saida', 'retorno'])->default('saida');

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
