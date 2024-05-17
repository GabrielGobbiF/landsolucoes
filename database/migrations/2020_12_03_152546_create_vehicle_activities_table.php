<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('km_start');
            $table->string('km_end')->nullable();
            $table->string('type')->nullable();
            $table->string('obr_razao_social')->nullable();
            $table->string('description_return')->nullable();

            $table->integer('obra_id')->nullable();
            $table->integer('notify_send')->default('0');

            $table->string('driver_name');
            $table->integer('driver_id');
            $table->unsignedBigInteger('vehicle_id');

            $table->text('observation')->nullable();
            $table->text('observation_return')->nullable();

            $table->enum('status', ['0', '1'])->default('0');

            $table->string('nota_fiscal')->nullable();

            #$table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');

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
        Schema::dropIfExists('vehicle_activities');
    }
}
