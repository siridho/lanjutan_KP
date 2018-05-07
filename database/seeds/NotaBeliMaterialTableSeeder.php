<?php

use Illuminate\Database\Seeder;

class NotaBeliMaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nota_beli_materials=array(
         	['nonota'=>'P1010', 'id_karyawan'=> 1, 'kodeMitra'=>'001', 'tglNota'=>'2017-10-05', 'status'=>'lunas', 'status_barang'=>'lengkap', 'kodeProyek'=>'001', 'validator'=>1, 'referensi'=>'-'],
         	
            );

        DB::table('nota_beli_materials')->insert($nota_beli_materials);
    }
}
