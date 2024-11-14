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
        Schema::create('resb_requisicoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('resb_id');

            $table->integer('user_id');
            $table->integer('item_id');
            $table->integer('rdse_id');
            $table->integer('unique');

            $table->decimal('qnt', 10, 2)->default(0);

            $table->foreign('resb_id')->references('id')->on('resbs')->onDelete('cascade');
            $table->timestamp('at');
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
        Schema::dropIfExists('resb_requisicoes');
    }
};
