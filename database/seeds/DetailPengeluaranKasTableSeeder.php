<?php

use Illuminate\Database\Seeder;

class DetailPengeluaranKasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $detail_pengeluaran_kasses=array(
         	['nonota'=>'P1001', 'uraian'=> 'Pengeluaran Kas', 'kodeBiayaKas'=>null, 'harga'=>4000, 'jumlah'=>5],
         	
            );

        DB::table('detail_pengeluaran_kasses')->insert($detail_pengeluaran_kasses);
    }
}
