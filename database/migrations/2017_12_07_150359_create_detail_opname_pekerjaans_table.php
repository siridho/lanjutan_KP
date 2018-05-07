<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailOpnamePekerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_opname_pekerjaans', function (Blueprint $table) {
            $table->string('nonota', 10);
            $table->foreign('nonota')->references('nonota')->on("opname_volume_pekerjaans")->onDelete('cascade');
            $table->date('tglNota')->nullable();
            $table->integer('noBaris');
            $table->string('kodeKelompokKegiatan')->nullable();
            $table->double('volume')->nullable();
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
        Schema::drop('detail_opname_pekerjaans');
    }
}
