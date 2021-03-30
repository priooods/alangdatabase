<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('fullname');
            $table->string('alamat');
            $table->integer('status');
            $table->enum('access',['SuperUser','Admin','Sekertaris','Bendahara','Ketua','Design','Kurikulum','Hrd','Anggota']);
            $table->enum('gender',['Pria','Wanita']);
            $table->string('pekerjaan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('email')->unique();
            $table->text('avatar')->nullable();
            $table->string('password');
            $table->string('password_verif');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
