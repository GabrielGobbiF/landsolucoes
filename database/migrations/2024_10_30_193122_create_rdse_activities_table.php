<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdse_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rdse_id');
            $table->unsignedBigInteger('equipe_id');
            $table->unsignedBigInteger('user_created');
            $table->unsignedBigInteger('veiculo_id');
            $table->unsignedBigInteger('supervisor_id');
            $table->unsignedBigInteger('encarregado_id');

            $table->string('atividade_descricao');
            $table->string('diretoria');
            $table->longText('atividades');
            $table->timestamp('data');
            $table->string('data_inicio');
            $table->string('data_fim');
            $table->timestamp('execucao')->nullable();
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
        Schema::dropIfExists('rdse_activities');
    }
};
