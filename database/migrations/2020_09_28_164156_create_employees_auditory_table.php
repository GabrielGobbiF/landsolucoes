<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesAuditoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_auditory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', ['0', '1'])->default('0');
            $table->string('observacao')->nullable();
            $table->integer('applicable')->default('1')->nullable();
            $table->string('document_link')->nullable();
            $table->integer('along_month')->nullable();

            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('auditory_id');

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('auditory_id')->references('id')->on('auditory');
            $table->unsignedBigInteger('updated_by')->nullable();

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
        Schema::dropIfExists('employees_auditory');
    }
}
