<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raps', function (Blueprint $table) {
            $table->string('nonota', 10)->primary();
            $table->date('tglNota')->nullable();
            $table->integer('id_karyawan')->unsigned();
            $table->foreign('id_karyawan')->references('id')->on("users")->onDelete('cascade');
            $table->string('kodeProyek',4);
            $table->foreign('kodeProyek')->references('kodeProyek')->on("proyeks")->onDelete('cascade');
            $table->string('status')->nullable();
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
        Schema::drop('raps');
    }
}
