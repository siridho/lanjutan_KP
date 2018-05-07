<?php

use Illuminate\Database\Seeder;

class DetailTerimaBarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $detail_terima_barangs=array(
         	['nonota'=>'P1012', 'kodeProyek'=> '001', 'kode_material'=>'113', 'jumlah'=>4000, 'keterangan'=>'Detail Terima Barang'],
         	
            );

        DB::table('detail_terima_barangs')->insert($detail_terima_barangs);
    }
}
