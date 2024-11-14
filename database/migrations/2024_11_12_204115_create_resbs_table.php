<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resbs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rdse_id');
            $table->integer('item_id')->nullable();

            $table->decimal('qnt_planejada', 10, 2)->nullable();
            $table->decimal('qnt_viabilidade', 10, 2)->nullable();
            $table->decimal('qnt_executada', 10, 2)->nullable();

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
        Schema::dropIfExists('resbs');
    }
};
