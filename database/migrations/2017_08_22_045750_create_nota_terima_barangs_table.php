<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotaTerimaBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_terima_barangs', function(Blueprint $table) {
            
            $table->string('nonota',10)->primary();
            $table->integer('id_karyawan')->unsigned();
            $table->foreign('id_karyawan')->references('id')->on("users")->onDelete('cascade');
            $table->string('nonota_beli',10);
            $table->foreign('nonota_beli')->references('nonota')->on('nota_beli_materials')->onDelete('cascade');
            $table->string('kodeMitra',10);
            $table->foreign('kodeMitra')->references('kodeMitra')->on("mitra_kerjas")->onDelete('cascade');
            $table->date('tglNota');
            $table->string('kodeProyek',4);
            $table->foreign('kodeProyek')->references('kodeProyek')->on("proyeks")->onDelete('cascade');
            $table->string('status',10);
            $table->string('status_nota',10)->nullable();
            $table->integer('validator')->unsigned()->nullable();
            $table->foreign('validator')->references('id')->on("users")->onDelete('cascade');
            $table->date('waktu_valid')->nullable();
            $table->string('referensi',10)->nullable();
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
        Schema::drop('nota_terima_barangs');
    }
}
