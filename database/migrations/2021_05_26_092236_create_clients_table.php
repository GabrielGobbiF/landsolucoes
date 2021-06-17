<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('company_name');                      //Razão Social
            $table->string('username');                          //Nome fantasia
            $table->string('cnpj')->unique()->nullable();
            $table->string('password')->default('$2y$10$GVCJeuiKt8jQrND/r5cGy.N5mgZzclLgsFsU6dJ2X4INQ5UYZQhYW');
            $table->rememberToken();
            $table->timestamps();
        });

        //DB::table('clients')->insert(
        //    [
        //        'company_name' => 'SANCA ENGENHARIA LTDA',
        //        'password' => '$2y$10$QygCRy.mrYzVL6vkvatzEepNMFud3bKvvLBAwz/Jbvrms9qFB9p2e',
        //        'username' => 'SANCA',
        //        'uuid' => '321312312312',
        //        'cnpj' => '50614163000132',
        //    ]
        //);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
