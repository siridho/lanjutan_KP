<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateManagerProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager_proyeks', function(Blueprint $table) {
            $table->string('kodeManager',3)->primary();
            $table->string('nama',100);
            $table->text('alamat');
            $table->string('identitas',30);
            $table->date('tanggalMasuk');
            $table->string('email',100);
            $table->string('telepon',15);
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
        Schema::drop('manager_proyeks');
    }
}
