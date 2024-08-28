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
        Schema::table('rdses', function (Blueprint $table) {
            $table->timestamp('enviado_enel')->nullable();
            $table->timestamp('aprovado_enel')->nullable();
            $table->timestamp('fiscalizado_satel')->nullable();
            $table->timestamp('liberado_medicao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rdses', function (Blueprint $table) {
            $table->dropColumn('enviado_enel');
            $table->dropColumn('aprovado_enel');
            $table->dropColumn('fiscalizado_satel');
            $table->dropColumn('liberado_medicao');
        });
    }
};
