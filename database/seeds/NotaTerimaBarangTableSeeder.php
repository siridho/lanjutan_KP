<?php

use Illuminate\Database\Seeder;

class NotaTerimaBarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nota_terima_barangs=array(
         	['nonota'=>'P1012', 'id_karyawan'=> 1, 'nonota_beli'=>'P1010', 'kodeMitra'=>'001', 'status'=>'lunas', 'tglNota'=>'2017-12-12', 'kodeProyek'=>'001', 'validator'=>'1', 'referensi'=>'-'],
         	
            );

        DB::table('nota_terima_barangs')->insert($nota_terima_barangs);
    }
}
