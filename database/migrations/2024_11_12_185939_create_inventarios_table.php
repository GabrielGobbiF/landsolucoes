<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            $table->string('name')->nullable();
            $table->string('sku')->nullable();
            $table->string('code_omie')->nullable();
            $table->string('code_ncm')->nullable();
            $table->string('unit')->nullable();

            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();

            $table->string('weight')->nullable();
            $table->string('image')->nullable();

            $table->decimal('stock', 10,2)->default('0');
            $table->decimal('opening_stock', 10,2)->default('0');
            $table->decimal('refueling_point', 10,2)->default('0');

            $table->bigInteger('market_price')->default('0');
            $table->bigInteger('sale_price')->default('0');

            $table->timestamps();
            $table->softDeletes();
        });

        #DB::unprepared(file_get_contents(database_path('seeders/jsons/inventories.sql')));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
