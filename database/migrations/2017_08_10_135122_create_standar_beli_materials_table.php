<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStandarBeliMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standar_beli_materials', function(Blueprint $table) {
            $table->increments('id');
            $table->string('kode_material',10);
            $table->foreign('kode_material')->references('kodeMaterial')->on("materials")->onDelete('cascade');

            $table->string('kode_mitra',10);
            $table->foreign('kode_mitra')->references('kodeMitra')->on("mitra_kerjas")->onDelete('cascade');
            $table->double('harga_satuan');
            $table->integer('jangka_bayar');
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
        Schema::drop('standar_beli_materials');
    }
}
