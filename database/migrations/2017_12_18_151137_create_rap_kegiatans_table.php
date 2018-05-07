<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRapKegiatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rap_kegiatans', function (Blueprint $table) {
            $table->string('nonota', 10);
            $table->foreign('nonota')->references('nonota')->on("raps")->onDelete('cascade');
            $table->date('tglNota')->nullable();
            $table->string('kodeKelompokKegiatan');
            $table->foreign('kodeKelompokKegiatan')->references('kodeKelompokKegiatan')->on("kelompok_kegiatans")->onDelete('cascade');
            // $table->date('tgl_mulai');
            $table->string('kode_pekerjaan');
            $table->foreign('kode_pekerjaan')->references('kodeKelompokKegiatan')->on("rap_pekerjaans")->onDelete('cascade');
            $table->integer('minggu_mulai');
            $table->integer('lama');
            $table->double('volume');
            $table->double('hargaSat');
            $table->double('totalHarga');
            $table->integer('noBaris');

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
        Schema::dropIfExists('rap_kegiatans');
    }
}
