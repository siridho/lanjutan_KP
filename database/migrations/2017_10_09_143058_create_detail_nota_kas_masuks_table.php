<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailNotaKasMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_nota_kas_masuks', function(Blueprint $table) {
            $table->string('nonota',10);
            $table->foreign('nonota')->references('nonota')->on("nota_kas_masuks")->onDelete('cascade');
            $table->date('tglNota')->nullable();
            $table->text('uraian')->nullable();
            $table->integer('noBaris');
            $table->double('saldo');
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
        Schema::drop('detail_nota_kas_masuks');
    }
}
