<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCompanyAuditoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_auditory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('type')->nullable();
            $table->string('document_link')->nullable();
            $table->enum('status', ['0', '1'])->default('0');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });

        DB::table('company_auditory')->insert(
            [
                'name' => 'ppra',
                'description' => 'PPRA',
                'type' => 'documentos',
            ]
        );

        DB::table('company_auditory')->insert(
            [
                'name' => 'pcmso',
                'description' => 'PCMSO',
                'type' => 'documentos',
            ]
        );

        DB::table('company_auditory')->insert(
            [
                'name' => 'ltcat',
                'description' => 'LTCAT',
                'type' => 'documentos',
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_auditory');
    }
}
