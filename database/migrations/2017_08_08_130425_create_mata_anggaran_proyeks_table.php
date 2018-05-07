<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMataAnggaranProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_anggaran_proyeks', function(Blueprint $table) {
            $table->string('kodeKelompokAnggaran',1)->primary();
            $table->string('nama',30);
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
        Schema::drop('mata_anggaran_proyeks');
    }
}
