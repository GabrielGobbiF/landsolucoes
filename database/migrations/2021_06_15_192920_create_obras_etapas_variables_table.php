<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObrasEtapasVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obras_etapas_variables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('etapa_id')->nullable();
            $table->unsignedBigInteger('obra_id')->nullable();
            $table->string('nome');
            $table->string('preco')->nullable();
            $table->integer('quantidade')->default('0');
            $table->timestamps();

            $table->foreign('etapa_id')
                ->references('id')
                ->on('obras_etapas')
                ->onDelete('cascade');

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
        Schema::dropIfExists('obras_etapas_variables');
    }
}
