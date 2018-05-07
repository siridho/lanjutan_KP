<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMitraKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitra_kerjas', function(Blueprint $table) {
            $table->string('kodeMitra',10)->primary();
            $table->string('nama',100);
            $table->text('alamat')->nullable();
            $table->string('telepon',15)->nullable();
            $table->string('email',100)->nullable();
            $table->string('npwp',50)->nullable();
            $table->string('kontakNama',100)->nullable();
            $table->string('kontakTelepon',15)->nullable();
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
        Schema::drop('mitra_kerjas');
    }
}
