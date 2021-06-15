<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObraEtapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obras_etapas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('id_obra');
            $table->unsignedBigInteger('id_etapa')->nullable();
            $table->unsignedBigInteger('tipo_id');

            $table->string('nome')->nullable();

            $table->enum('check', ['C', 'EM', 'P'])->default('EM');  // C = CONCLUIDA, E = EM ANDAMENTO, P = PARCIALMENTE FEITA
            $table->enum('status', ['P', 'AF', 'F'])->default('P');  // P = PENDENTE, AF = A FATURAR, F = FATURADO

            $table->integer('ordem')->default('0');

            $table->string('nota_numero')->nullable();
            $table->string('responsavel')->nullable();
            $table->string('cliente_responsavel')->nullable();
            $table->string('preco')->nullable();
            $table->string('quantidade')->nullable();
            $table->string('unidade')->nullable();
            $table->longText('observacao')->nullable();
            $table->longText('observacao_sistema')->nullable();

            $table->integer('prazo_atendimento')->nullable(); //em dias
            $table->integer('tempo_atividade')->nullable(); //em dias

            $table->timestamp('data_abertura')->nullable();
            $table->timestamp('data_programada')->nullable();
            $table->timestamp('data_iniciada')->nullable();
            $table->timestamp('data_prazo_total')->nullable();
            $table->timestamp('meta_etapa')->nullable();

            $table->timestamps();

            $table->foreign('id_obra')
                ->references('id')
                ->on('obras')
                ->onDelete('cascade');

            $table->foreign('tipo_id')
                ->references('id')
                ->on('tipos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obras_etapas');
    }
}
