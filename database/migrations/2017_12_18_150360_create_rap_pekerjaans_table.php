<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRapPekerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rap_pekerjaans', function (Blueprint $table) {
            $table->string('kodeKelompokKegiatan');
            $table->foreign('kodeKelompokKegiatan')->references('kodeKelompokKegiatan')->on("kelompok_kegiatans")->onDelete('cascade');
            $table->string('nonota', 10);
            $table->foreign('nonota')->references('nonota')->on("raps")->onDelete('cascade');
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('rap_pekerjaans');
    }
}
