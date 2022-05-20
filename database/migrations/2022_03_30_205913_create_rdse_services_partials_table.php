<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRdseServicesPartialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdse_services_partials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rdse_service_id');
            $table->unsignedBigInteger('rdse_id');

            $table->double('preco', 10, 2)->default('0.00');
            $table->string('quantidade')->nullable()->default('0'); 
            $table->integer('partial')->nullable()->default('1'); 

            $table->foreign('rdse_service_id')
                ->references('id')
                ->on('rdse_services');

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
