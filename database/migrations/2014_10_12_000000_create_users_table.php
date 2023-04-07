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
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique();
            $table->string('rg')->unique()->nullable();
            $table->enum('password_verified', ['N', 'Y'])->default('N');
            $table->string('telefone_celular')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            [
                'name' => 'Gabriel Gobbi',
                'password' => '$2y$10$hBIkxTJLzwCa81qGl0TtT.6s/xWXZd0wmtXosFdmHV38yDjSxQ31m', //superadmin,
                'email' => 'gabriel.gobbi15@gmail.com',
                'username' => 'gabriel.gobbi',
                'uuid' => '3edascdsa',
                'email_verified_at' => now(),
                'password_verified' => 'Y'
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
