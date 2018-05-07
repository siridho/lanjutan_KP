<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRapBiayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rap_biayas', function (Blueprint $table) {
            $table->string('nonota', 10);
            $table->foreign('nonota')->references('nonota')->on("raps")->onDelete('cascade');
            $table->date('tglNota')->nullable();
            $table->string('kodeJenisBiaya');
            $table->foreign('kodeJenisBiaya')->references('kodeJenisBiaya')->on("jenis_biaya_proyeks")->onDelete('cascade');

            $table->string('kodeKegiatan');
            $table->foreign('kodeKegiatan')->references('kodeKelompokKegiatan')->on("kelompok_kegiatans")->onDelete('cascade');

            $table->string('kodePekerjaan');
            $table->foreign('kodePekerjaan')->references('kodeKelompokKegiatan')->on("kelompok_kegiatans")->onDelete('cascade');

            $table->double('qty');
            $table->double('harsat');
            $table->integer('noBaris');
            $table->integer('noBarisKegiatan');
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
        Schema::dropIfExists('rap_biayas');
    }
}
