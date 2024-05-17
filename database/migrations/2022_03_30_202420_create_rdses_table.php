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
            $table->string('lote')->nullable();                 // Lote
            $table->date('at')->nullable();                     // Data
            $table->string('type');                             // Emergencia, LDS, Manutenção, Futurabilit, Civil
            $table->string('status')->default('pending');       // pending, review, approved, approval
            $table->string('modelo')->default(false);           // 1 true = é um modelo
            $table->longtext('observations')->nullable();   
            $table->longtext('observations_execution')->nullable();   
            
            $table->integer('parcial_1')->default('0')->nullable();          
            $table->integer('parcial_2')->default('0')->nullable();          
            $table->integer('parcial_3')->default('0')->nullable();    
            
            $table->timestamp('parcial_1_at')->nullable();          
            $table->timestamp('parcial_2_at')->nullable();          
            $table->timestamp('parcial_3_at')->nullable();          
            
            
            $table->string('nf')->nullable();          
            $table->timestamp('date_nfe_at')->nullable();          

            $table->timestamps();

            $table->softDeletes();
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
