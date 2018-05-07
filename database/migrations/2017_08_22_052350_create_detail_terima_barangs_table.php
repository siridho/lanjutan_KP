<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailTerimaBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_terima_barangs', function(Blueprint $table) {
            
            $table->string('nonota',10);
            $table->foreign('nonota')->references('nonota')->on("nota_terima_barangs")->onDelete('cascade');
            $table->string('kodeProyek',4);
            $table->foreign('kodeProyek')->references('kodeProyek')->on("proyeks")->onDelete('cascade');
            $table->string('kode_material',10);
            $table->foreign('kode_material')->references('kodeMaterial')->on("materials")->onDelete('cascade');
            $table->integer('noBaris');
            $table->integer('baris_detail_beli');
            $table->date('tglNota');
            $table->double('jumlah');
            $table->double('harga');
            $table->text('keterangan')->nullable();
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
        Schema::drop('detail_terima_barangs');
    }
}
