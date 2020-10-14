<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesAuditoryMonthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_auditory_month', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', ['0', '1'])->default('0');
            $table->string('month')->nullable();
            $table->string('docs_link')->nullable();
            $table->date('date_accomplished')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('validity')->nullable();

            $table->unsignedBigInteger('employees_auditory_id');

            $table->foreign('employees_auditory_id')->references('id')->on('employees_auditory')->onDelete('cascade');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('employees_auditory_month');
    }
}
