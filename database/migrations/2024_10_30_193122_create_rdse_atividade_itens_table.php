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
        Schema::create('rdse_atividade_itens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rdse_atividade_id');
            $table->unsignedBigInteger('rdse_id');
            $table->unsignedBigInteger('handsworks_id');
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
        Schema::dropIfExists('rdse_atividade_itens');
    }
};
