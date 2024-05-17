<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObrasTable extends Migration
{
    /**

     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obras', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('concessionaria_id');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('viabilization_id')->nullable();

            $table->string('razao_social');
            $table->longText('description')->nullable();
            $table->string('last_note')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('razao_social_obra_cliente')->nullable();
            $table->longText('obr_informacoes')->nullable();
            $table->enum('status', ['elaboração', 'enviada', 'aprovada', 'recusada', 'concluida'])->default('elaboração');
            $table->enum('obr_urgence', ['Y', 'N'])->default('N');

            $table->timestamp('build_at')->nullable();  //usado como data de criação
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_id')
                ->references('id')
                ->on('departments');

            $table->foreign('address_id')
                ->references('id')
                ->on('address');

            $table->foreign('concessionaria_id')
                ->references('id')
                ->on('concessionarias')
                ->onDelete('cascade');

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade');

            $table->foreign('viabilization_id')
                ->references('id')
                ->on('obras_viabilizations')
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
        Schema::dropIfExists('obras');
    }
}
