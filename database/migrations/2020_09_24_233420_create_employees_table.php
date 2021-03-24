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
            $table->date('date_contract');
            $table->string('cnh_number')->nullable();
            $table->string('equipe')->nullable();
            $table->double('salario', 10, 2);
            $table->enum('cnh', ['0', '1'])->default('0')->nullable();
            $table->string('cnh_validity')->nullable();
            $table->enum('dispense', ['0', '1'])->default('0')->nullable();
            $table->string('email')->unique();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

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
