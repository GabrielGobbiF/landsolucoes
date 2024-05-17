<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('tar_titulo');
            $table->text('tar_descricao')->nullable();
            $table->datetime('tar_prazo')->nullable();
            $table->enum('tar_status', ['concluido', 'em_andamento'])->default('em_andamento');
            $table->enum('prioridade', ['alta', 'media', 'baixa'])->default('baixa');
            $table->enum('alert', ['Y', 'N'])->default('N');
            $table->text('data')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('tasks');
    }
}
