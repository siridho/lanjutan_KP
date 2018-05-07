<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMaterialProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_proyeks', function(Blueprint $table) {
            $table->string('kodeProyek',3);
            $table->foreign('kodeProyek')->references('kodeProyek')->on("proyeks")->onDelete('cascade');

            $table->string('kodeMaterial',6);
            $table->foreign('kodeMaterial')->references('kodeMaterial')->on("materials")->onDelete('cascade');

            $table->double('stok');
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
        Schema::drop('material_proyeks');
    }
}
