<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosPastasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_pastas', function (Blueprint $table) {
            $table->unsignedBigInteger('pasta_id');
            $table->unsignedBigInteger('documento_id');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('pasta_id')->references('id')->on('pastas')->onDelete('cascade');
            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
            $table->primary(['pasta_id', 'documento_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos_pastas');
    }
}
