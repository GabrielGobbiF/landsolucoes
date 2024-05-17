<?php

use App\Supports\Enums\Frota\VisitorsStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('user_id'); //id do usuário (porteiro)
            $table->string('name');
            $table->string('company_name');
            $table->string('finality');
            $table->string('document');
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_plate')->nullable();
            $table->string('vehicle_color')->nullable();
            $table->timestamp('visitor_at');

            $table->string('status')->default(VisitorsStatus::options()->where('value', 'created')->first()['value']);

            $table->timestamps();
        });

        Schema::table('portarias', function (Blueprint $table) {
            $table->string('finality')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitors');

        Schema::table('portarias', function (Blueprint $table) {
            $table->dropColumn('finality');
        });
    }
}
