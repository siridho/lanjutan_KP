<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotaKasMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_kas_masuks', function(Blueprint $table) {
            $table->string('nonota',10)->primary();
            $table->integer('id_karyawan')->unsigned();
            $table->foreign('id_karyawan')->references('id')->on("users")->onDelete('cascade');
            $table->date('tglNota');
            $table->string('kodeProyek',4);
            $table->foreign('kodeProyek')->references('kodeProyek')->on('proyeks')->onDelete('cascade');
            $table->string('status_nota',10)->nullable();
            $table->integer('validator')->unsigned()->nullable();
            $table->foreign('validator')->references('id')->on("users")->onDelete('cascade');
            $table->date('waktu_valid')->nullable();
            $table->string('referensi')->nullable();
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
        Schema::drop('nota_kas_masuks');
    }
}
