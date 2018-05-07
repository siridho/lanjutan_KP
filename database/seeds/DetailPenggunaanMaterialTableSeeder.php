<?php

use Illuminate\Database\Seeder;

class DetailPenggunaanMaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $detail_penggunaan_materials=array(
         	['nonota'=>'P1041', 'kodeMaterial'=> '111', 'jumlah'=>4, 'keterangan'=>'untuk proyek']
            );

        DB::table('detail_penggunaan_materials')->insert($detail_penggunaan_materials);
    }
}
