<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollunsToPortariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('portarias', function (Blueprint $table) {
            $table->string('controlador');
            $table->string('km');
            $table->string('departamento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('portarias', function (Blueprint $table) {
            $table->dropColumn('imei');
            $table->dropColumn('km');
            $table->dropColumn('departamento');
        });
    }
}
