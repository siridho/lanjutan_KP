<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOpnameVolumePekerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opname_volume_pekerjaans', function (Blueprint $table) {
            $table->string('nonota', 10)->primary();
            $table->date('tglNota')->nullable();
            $table->string('kodeProyek')->nullable();
            $table->integer('idKaryawan')->nullable();
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
        Schema::drop('opname_volume_pekerjaans');
    }
}
