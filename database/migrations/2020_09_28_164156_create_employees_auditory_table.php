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

            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('type')->nullable();
            $table->string('document_link')->nullable();
            $table->integer('order')->nullable();
            $table->string('option_name')->nullable();
            $table->integer('doc_applicable')->default('1')->nullable();
            $table->integer('doc_along_month')->nullable();
            $table->integer('doc_along_year')->default('0')->nullable();


            $table->enum('status', ['0', '1'])->default('0');

            $table->unsignedBigInteger('employee_id')->nullable();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
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
