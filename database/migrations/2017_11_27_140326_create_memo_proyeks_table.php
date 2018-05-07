<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMemoProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memo_proyeks', function (Blueprint $table) {
            $table->string('nonota', 10)->primary();
            $table->integer('id_karyawan')->nullable();
            $table->date('tgl')->nullable();
            $table->string('kodeProyek')->nullable();
            $table->string('status_nota')->nullable();
            $table->integer('validator')->nullable();
            $table->date('waktu_valid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('memo_proyeks');
    }
}
