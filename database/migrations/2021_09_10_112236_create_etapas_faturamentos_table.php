<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtapasFaturamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapas_faturamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('obr_etp_financerio_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('coluna_faturamento');
            $table->string('nf_n');
            $table->timestamp('data_emissao');
            $table->timestamp('data_vencimento');
            $table->double('valor', 10, 2);
            $table->double('valor_receber', 10, 2);
            $table->enum('recebido_status', ['N', 'Y'])->default('N');
            $table->string('status')->default('0');

            $table->timestamps();

            $table->foreign('obr_etp_financerio_id')
                ->references('id')
                ->on('obras_etapas_financeiro')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etapas_faturamentos');
    }
}
