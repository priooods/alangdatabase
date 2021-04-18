<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prokers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('tgl_mulai');
            $table->string('tgl_selesai');
            $table->string('ketua');
            $table->string('judul');
            $table->string('lokasi');
            $table->text('gol_point');
            $table->string('desc');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
        
        Schema::table('prokers', function (Blueprint $table) {
            $table->foreign('department_id')
                ->references('id')
                ->on('usersdepartemens')
                ->onUpdate('cascade')
                ->onDelete('SET NULL');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prokers');
    }
}
