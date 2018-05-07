<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyeks', function(Blueprint $table) {
            $table->string('kodeProyek',4)->primary();

            $table->string('kodeCustomer',4);
            $table->foreign('kodeCustomer')->references('kodeCustomer')->on("customers")->onDelete('cascade');

            $table->integer('id_manager')->unsigned();
            $table->foreign('id_manager')->references('id')->on("users")->onDelete('cascade');

            $table->integer('id_kasir')->unsigned()->nullable();
            $table->foreign('id_kasir')->references('id')->on("users")->onDelete('cascade');

            $table->integer('id_sekretaris')->unsigned()->nullable();
            $table->foreign('id_sekretaris')->references('id')->on("users")->onDelete('cascade');            


            $table->text('uraian');
            $table->string('jenis')->nullable();
            $table->double('volume');
            $table->integer('waktu');
            $table->date('tanggalMulai');
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
        Schema::drop('proyeks');
    }
}
