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
            $table->string('status_closing')->default('in_closing');       // in_closing
            $table->string('modelo')->default(false);           // 1 true = é um modelo
            $table->string('sigeo', 2)->default(false);           // 0 = não 1 sim

            $table->longtext('observations')->nullable();
            $table->longtext('observations_execution')->nullable();
            $table->longtext('observations_viabilidade')->nullable();
            $table->longtext('observations_programacao')->nullable();
            $table->longtext('observations_adicionais')->nullable();
            $table->longtext('observation_status')->nullable();
            $table->integer('tipo_obra')->nullable();

            /*resb*/
            $table->timestamp('resb_enel')->nullable();
            $table->timestamp('resb_viabilidade')->nullable();
            $table->timestamp('resb_execucao')->nullable();
            $table->string('resb_status')->nullable();

            $table->integer('parcial_1')->default('0')->nullable();
            $table->integer('parcial_2')->default('0')->nullable();
            $table->integer('parcial_3')->default('0')->nullable();

            $table->boolean('is_civil')->default('0')->nullable();

            $table->timestamp('parcial_1_at')->nullable();
            $table->timestamp('parcial_2_at')->nullable();
            $table->timestamp('parcial_3_at')->nullable();

            $table->string('nf')->nullable();
            $table->timestamp('date_nfe_at')->nullable();

            $table->string('croqui_atualizado_data')->nullable();
            $table->string('croqui_atualizado_responsavel')->nullable();
            $table->string('croqui_validado_data')->nullable();
            $table->string('croqui_validado_responsavel')->nullable();
            $table->string('croqui_finalizado_data')->nullable();
            $table->string('croqui_finalizado_responsavel')->nullable();
            $table->string('status_execution')->nullable();

            $table->string('apr_at')->nullable();
            $table->string('apr_id')->nullable();

            $table->timestamp('month_date')->nullable();

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
