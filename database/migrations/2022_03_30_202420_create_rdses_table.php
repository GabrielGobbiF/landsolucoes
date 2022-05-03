<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRdsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('obra_id')->nullable();  //Alocado em um obra

            $table->longtext('description')->nullable();        // Descrição
            $table->string('n_order')->nullable();              // Nº de ordem
            $table->string('equipe')->nullable();               // Descrição
            $table->string('solicitante')->nullable();          // Descrição
            $table->date('at')->nullable();                     // Data
            $table->string('type');                             // Emergencia, LDS, Manutenção, Futurabilit, Civil
            $table->string('status')->default('pending');       // pending, review, approved
            $table->string('modelo')->default(false);           // 1 true = é um modelo

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
        Schema::dropIfExists('rdses');
    }
}
