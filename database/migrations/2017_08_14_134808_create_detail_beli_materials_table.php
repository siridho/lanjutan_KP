<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailBeliMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_beli_materials', function(Blueprint $table) {
            // $table->increments('id');
            $table->string('nonota',10);
            $table->foreign('nonota')->references('nonota')->on("nota_beli_materials")->onDelete('cascade');
            $table->string('kode_material',10);
            $table->foreign('kode_material')->references('kodeMaterial')->on("materials")->onDelete('cascade');
            $table->integer('noBaris');
            $table->double('qty');
            $table->text('keterangan')->nullable();
            $table->double('harga');
            $table->date('tglNota');
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
        Schema::drop('detail_beli_materials');
    }
}
