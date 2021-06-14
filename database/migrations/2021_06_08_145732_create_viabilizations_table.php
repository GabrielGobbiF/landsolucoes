<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViabilizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obras_viabilizations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->longText('observacoes')->nullable();
            $table->string('responsavel')->nullable();
            $table->string('participantes')->nullable();
            $table->string('escopo_servico')->nullable();

            $table->enum('ambiental', ['sim', 'não'])->default('não');
            $table->string('ambiental_comentario')->nullable();

            $table->enum('seguranca_via', ['sim', 'não'])->default('não');
            $table->string('seguranca_comentario')->nullable();

            $table->enum('qualidade', ['sim', 'não'])->default('não');
            $table->string('qualidade_comentario')->nullable();

            $table->enum('elaboracao', ['sim', 'não'])->default('não');
            $table->string('elaboracao_comentario')->nullable();

            $table->enum('viavel', ['viavel', 'restricao', 'nao_viavel'])->default('viavel');

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
        Schema::dropIfExists('obras_viabilizations');
    }
}
