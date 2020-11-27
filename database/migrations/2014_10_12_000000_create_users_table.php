<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('telefone_celular')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            [
                'name' => 'Gabriel Gobbi',
                'password' => '$2y$10$QygCRy.mrYzVL6vkvatzEepNMFud3bKvvLBAwz/Jbvrms9qFB9p2e',
                'email' => 'gabriel.gobbi15@gmail.com',
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'Bruno Costa',
                'password' => '$2y$10$QygCRy.mrYzVL6vkvatzEepNMFud3bKvvLBAwz/Jbvrms9qFB9p2e',
                'email' => 'bruno@bruno',
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'Livia',
                'password' => '$2y$10$Z2LncyeGcNVwIOCDKMG5b.sLcFgtGaKSRtHUS3hU60XY3KstrJR4i',
                'email' => 'livia@livia',
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
        Schema::dropIfExists('users');
    }
}
