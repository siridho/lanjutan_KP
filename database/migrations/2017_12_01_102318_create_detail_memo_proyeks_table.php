<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetailMemoProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_memo_proyeks', function (Blueprint $table) {
            $table->string('nonota', 10);
            $table->foreign('nonota')->references('nonota')->on("memo_proyeks")->onDelete('cascade');
            $table->text('uraian')->nullable();
            $table->double('nilai')->nullable();
            $table->integer('noBaris');
            $table->date('tglNota')->nullable();
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
        Schema::drop('detail_memo_proyeks');
    }
}
