<?php

use Illuminate\Database\Seeder;

class NotaPenggunaanMaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nota_penggunaan_materials=array(
         	['nonota'=>'P1041', 'id_karyawan'=> 1, 'kodeProyek'=>'001', 'tanggalNota'=>'2017-10-10', 'referensi'=>'-','status'=>'-', 'validator'=>'1'],
         	
            );

        DB::table('nota_penggunaan_materials')->insert($nota_penggunaan_materials);
    }
}
