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
            $table->timestamp('enel_deadline')->nullable();
            $table->timestamp('viability_execution_date')->nullable();
            $table->timestamp('work_start_date')->nullable();
            $table->timestamp('work_end_date')->nullable();

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
            $table->dropColumn('enel_deadline');
            $table->dropColumn('viability_execution_date');
            $table->dropColumn('work_start_date');
            $table->dropColumn('work_end_date');
        });
    }
};
