<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcessionariaServiceEtapas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('con_service_etp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('concessionaria_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('etapa_id');
            $table->integer('order')->default('0');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('concessionaria_id')->references('id')->on('concessionarias')->onDelete('cascade');
            $table->foreign('etapa_id')->references('id')->on('etapas')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('con_service_etp');
    }
}
