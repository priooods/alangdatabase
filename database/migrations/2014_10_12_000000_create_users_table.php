<?php

use App\Models\usersacces;
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
            $table->string('name')->unique();
            $table->unsignedBigInteger('access_id')->nullable();
            $table->string('password');
            $table->string('password_verif');
            $table->string('fullname');
            $table->enum('type',['Tamu','Pengguna'])->nullable();
            $table->enum('gender',['Pria','Wanita']);
            $table->text('avatar')->nullable();
            $table->integer('log');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('access_id')
                ->references('id')
                ->on('usersacces')
                ->onUpdate('cascade')
                ->onDelete('SET NULL');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
