<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alats', function(Blueprint $table) {
            $table->string('kodeAlat',6)->primary();
            $table->string('nama',100);
            $table->string('Satuan',5)->nullable();
            $table->string('kelompokUtilitas',20)->nullable();
            $table->string('keterangan',20)->nullable();
            $table->integer('masapakai')->nullable();
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
        Schema::drop('alats');
    }
}
