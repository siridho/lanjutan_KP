<?php

use Illuminate\Database\Seeder;

class DetailBeliMaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $detail_beli_materials=array(
         	['nonota'=>'P1010', 'kode_material'=> '143', 'qty'=>2, 'keterangan'=>'pembelian material', 'harga'=>25000]
         	
            );

        DB::table('detail_beli_materials')->insert($detail_beli_materials);
    }
}
