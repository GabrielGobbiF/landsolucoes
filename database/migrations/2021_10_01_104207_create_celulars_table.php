<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCelularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('celulares', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('linha')->nullable();
            $table->string('usuario')->nullable();
            $table->string('equipe')->nullable();
            $table->string('responsavel')->nullable();
            $table->string('departamento')->nullable();
            $table->string('centro_custo')->nullable();

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
        Schema::dropIfExists('celulares');
    }
}
