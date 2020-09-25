<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('name')->unique();
            $table->string('rg')->unique();
            $table->string('ctps')->unique();
            $table->string('endereco');
            $table->string('estado_civil');
            $table->string('cargo');
            $table->double('salario', 10, 2);
            $table->enum('cnh', ['0', '1'])->default('0');
            $table->string('email')->unique();
            $table->string('url')->unique();

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
        Schema::dropIfExists('employees');
    }
}
