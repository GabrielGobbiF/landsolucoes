<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('board');
            $table->string('observation')->nullable();
            $table->string('year');
            $table->enum('secure', ['1', '0'])->default('0');

            $table->string('name_company_secure')->nullable();
            $table->string('number_policy')->nullable();
            $table->string('vigency_secure')->nullable();

            $table->string('color')->nullable();

            $table->enum('tracker', ['1', '0'])->default('0');
            $table->enum('external_camera', ['1', '0'])->default('0');
            $table->enum('internal_camera', ['1', '0'])->default('0');
            $table->enum('rented', ['1', '0'])->default('0');
            $table->enum('is_active', ['Y', 'N'])->default('Y');

            $table->string('tracker_company')->nullable();
            $table->string('rented_company')->nullable();

            $table->string('qrcode')->nullable();
            $table->string('mtr')->nullable();
            $table->string('chassi')->nullable();
            $table->string('renavam')->nullable();

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
        Schema::dropIfExists('vehicles');
    }
}
