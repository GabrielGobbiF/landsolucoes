<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConcessionariasServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concessionaria_service', function (Blueprint $table) {
            $table->unsignedBigInteger('concessionaria_id');
            $table->unsignedBigInteger('service_id');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('concessionaria_id')->references('id')->on('concessionarias')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
            $table->primary(['concessionaria_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concessionaria_service');
    }
}
