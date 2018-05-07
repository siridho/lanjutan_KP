<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailPenggunaanMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penggunaan_materials', function(Blueprint $table) {
            //$table->increments('id');
            $table->string('nonota',10);
            $table->foreign('nonota')->references('nonota')->on("nota_penggunaan_materials")->onDelete('cascade');
            $table->string('kodeMaterial',6);
            $table->foreign('kodeMaterial')->references('kodeMaterial')->on("materials")->onDelete('cascade');
            $table->double('jumlah');
            $table->integer('noBaris');
            $table->date('tglNota');
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
        Schema::drop('detail_penggunaan_materials');
    }
}
