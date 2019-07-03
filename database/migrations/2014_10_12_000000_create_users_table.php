<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role');
            $table->string('image');
            $table->string('ip');
            $table->rememberToken();
            $table->timestamps();
        });
        
        DB::table('users')->insert(
            array(
                'firstname'=>'admin',
                'lastname'=>'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'),
                'role'=>'admin',
                'image'=>'',
                'ip'=> Request::ip()
            )
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
