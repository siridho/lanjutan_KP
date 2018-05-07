<?php

use Illuminate\Database\Seeder;

class GudangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gudangs=array(
         	['kodeGudang'=> '001', 'nama'=>'Gudang Surabaya', 'keterangan'=>'Gudang penyimpanan material di Surabaya'],
            );
        DB::table('gudangs')->insert($gudangs);
    }
}
