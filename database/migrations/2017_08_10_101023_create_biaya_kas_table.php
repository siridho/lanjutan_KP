<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBiayaKasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biaya_kas', function(Blueprint $table) {
            $table->string('kodeBiayaKas', 6)->primary();
            $table->string('nama', 100);
            $table->string('satuan', 5)->nullable();
            $table->string('keterangan', 20)->nullable();
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
        Schema::drop('biaya_kas');
    }
}
