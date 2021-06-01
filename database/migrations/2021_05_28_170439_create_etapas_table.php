<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tipo_id');
            $table->longText('name');
            $table->string('slug')->nullable();
            $table->longText('descricao')->nullable();
            $table->integer('quantidade')->nullable();
            $table->float('preco', 10, 2)->nullable();
            $table->string('unidade')->nullable();

            $table->foreign('tipo_id')
                ->references('id')
                ->on('tipos')
                ->onDelete('cascade');

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
        Schema::dropIfExists('etapas');
    }
}
