<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->morphs('departments');
            $table->string('dep_responsavel');
            $table->string('dep_telefone_celular')->nullable();
            $table->string('dep_telefone_fixo')->nullable();
            $table->string('dep_email')->nullable();
            $table->string('dep_funcao')->nullable();
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
        Schema::dropIfExists('departments');
    }
}
