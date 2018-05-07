<?php

use Illuminate\Database\Seeder;

class NotaPengeluaranKasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nota_pengeluaran_kasses=array(
         	['no'=>'P1001', 'id_karyawan'=> 1, 'status'=>'kurang', 'tglNota'=>'2017-10-05', 'kodeProyek'=>'001', 'validator'=>1, 'referensi'=>'-'],
         	
            );

        DB::table('nota_pengeluaran_kasses')->insert($nota_pengeluaran_kasses);
    }
}