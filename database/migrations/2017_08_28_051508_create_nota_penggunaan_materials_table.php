<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotaPenggunaanMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_penggunaan_materials', function(Blueprint $table) {
            //$table->increments('id');
            $table->string('nonota',10)->primary();
            $table->integer('id_karyawan')->unsigned();
            $table->foreign('id_karyawan')->references('id')->on("users")->onDelete('cascade');
            // $table->string('kodeGudang');
            // $table->foreign('kodeGudang')->references('kodeGudang')->on("gudangs")->onDelete('cascade');;
            $table->string('kodeProyek');
            $table->foreign('kodeProyek')->references('kodeProyek')->on("proyeks")->onDelete('cascade');
            $table->date('tanggalNota');
            $table->string('referensi',10)->nullable();
            $table->string('status_nota',10)->nullable();
            $table->integer('validator')->unsigned()->nullable();
            $table->foreign('validator')->references('id')->on("users")->onDelete('cascade');
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
        Schema::drop('nota_penggunaan_materials');
    }
}
