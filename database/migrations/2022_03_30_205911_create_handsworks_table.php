<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHandsworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handsworks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('code');                             // Código
            $table->longtext('description');                    // Descrição
            $table->double('price_ups', 10, 2)->default(0.00);  // Preço UPS
            $table->double('price', 10, 2)->default(0.00);      // Preço

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
        Schema::dropIfExists('handsworks');
    }
}
