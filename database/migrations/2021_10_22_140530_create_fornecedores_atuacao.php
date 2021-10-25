<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedoresAtuacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores_atuacao', function (Blueprint $table) {
            $table->unsignedBigInteger('fornecedor_id');
            $table->unsignedBigInteger('atuacao_id');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('cascade');
            $table->foreign('atuacao_id')->references('id')->on('atuacao')->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
            $table->primary(['fornecedor_id', 'atuacao_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedores_atuacao');
    }
}
