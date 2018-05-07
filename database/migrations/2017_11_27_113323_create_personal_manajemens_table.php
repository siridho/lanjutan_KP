<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePersonalManajemensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_manajemens', function (Blueprint $table) {
            $table->string('kodePersonalManajemen')->primary();
            $table->string('nama')->nullable();
            $table->string('alamat')->nullable();
            $table->string('nomoridentitas')->nullable();
            $table->string('bagian')->nullable();
            $table->string('jabatan')->nullable();
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
        Schema::drop('personal_manajemens');
    }
}
