<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJenisBiayaProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_biaya_proyeks', function(Blueprint $table) {
            $table->string('kodeJenisBiaya', 3)->primary();
            $table->string('nama', 100);
            $table->string('satuan', 5)->nullable();
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
        Schema::drop('jenis_biaya_proyeks');
    }
}
