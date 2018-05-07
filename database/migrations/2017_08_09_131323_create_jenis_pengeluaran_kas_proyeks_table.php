<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJenisPengeluaranKasProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_pengeluaran_kas_proyeks', function(Blueprint $table) {
            $table->string('kodePengeluaran',10)->primary();
            $table->string('nama',100);
            $table->string('satuan',10);
            $table->text('keterangan');
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
        Schema::drop('jenis_pengeluaran_kas_proyeks');
    }
}
