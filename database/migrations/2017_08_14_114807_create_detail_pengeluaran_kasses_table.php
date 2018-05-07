<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailPengeluaranKassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pengeluaran_kasses', function(Blueprint $table) {
            // $table->increments('id');
            $table->string('nonota',10);
            $table->foreign('nonota')->references('nonota')->on("nota_pengeluaran_kasses")->onDelete('cascade');
            $table->date('tglNota')->nullable();
            $table->text('uraian')->nullable();
            $table->integer('noBaris');

            $table->string('kodeBiayaKas',6)->nullable();
            $table->foreign('kodeBiayaKas')->references('kodeBiayaKas')->on("biaya_kas")->onDelete('cascade');

            $table->string('kodeAlat',6)->nullable();
            $table->foreign('kodeAlat')->references('kodeAlat')->on("alats")->onDelete('cascade');
            
            $table->double('harga');
            $table->double('jumlah');
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
        Schema::drop('detail_pengeluaran_kasses');
    }
}
