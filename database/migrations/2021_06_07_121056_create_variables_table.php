<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //id_variavel_etapa
        //id_etapa
        //nome_variavel
        //preco_variavel

        Schema::create('variables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('etapa_id')->nullable();
            $table->string('name');
            $table->string('price')->nullable();
            $table->timestamps();

            $table->foreign('etapa_id')
                ->references('id')
                ->on('etapas')
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
        Schema::dropIfExists('variables');
    }
}
