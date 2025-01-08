<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uploadeds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();

            $table->nullableMorphs('parentable');
            $table->string('name'); // Nome
            $table->string('file_name'); // Nome do Arquivo (que vem salvo)
            $table->string('mime_type'); // Tipo (PDF, Word...)
            $table->string('path'); // N do documento
            $table->string('extension')->nullable(); //
            $table->string('disk')->default('local');
            $table->string('file_hash', 64)->nullable();
            $table->string('collection')->nullable();
            $table->integer('is_cover')->default(0);
            $table->string("source")->default("unknown");
            $table->text("uploaded_images")->nullable();

            $table->unsignedInteger("uploader_id")->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploadeds');
    }
};
