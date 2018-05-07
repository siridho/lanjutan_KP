<?php

use Illuminate\Database\Seeder;

class AlatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alats=array(
            ['kodeAlat'=> '211', 'nama'=>'Truk Dumper (Dump Truck)', 'keterangan'=>'', 'masapakai'=>0],
            ['kodeAlat'=> '212', 'nama'=>'Mesin Singkup-keruk (Backhoe)', 'keterangan'=>'', 'masapakai'=>0],
            ['kodeAlat'=> '213', 'nama'=>'Derek (Crane)', 'keterangan'=>'', 'masapakai'=>0],
            ['kodeAlat'=> '214', 'nama'=>'Ekskavator', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '219', 'nama'=>'Pemeliharaan dan Suku Cadang Alat Tanah', 'keterangan'=>'', 'masapakai'=>0],

         	['kodeAlat'=> '221', 'nama'=>'Sewa Bekisting', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '222', 'nama'=>'Pasang-bongkar Bekisting', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '229', 'nama'=>'Pemeliharaan dan Suku Cadang Bekisting', 'keterangan'=>'', 'masapakai'=>0],

         	['kodeAlat'=> '231', 'nama'=>'Alat Potong Besi', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '232', 'nama'=>'Alat Pembengkok Tulangan', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '233', 'nama'=>'Catut', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '234', 'nama'=>'Pencampur Beton', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '235', 'nama'=>'Penggetar Beton', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '239', 'nama'=>'Pemeliharaan dan Suku Cadang Alat Beton', 'keterangan'=>'', 'masapakai'=>0],

         	['kodeAlat'=> '241', 'nama'=>'Mesin Vibrator', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '249', 'nama'=>'Pemeliharaan dan Suku Cadang Alat Pemadatan', 'keterangan'=>'', 'masapakai'=>0],

         	['kodeAlat'=> '251', 'nama'=>'Alat Pemetaan', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '252', 'nama'=>'Gerobak Sorong', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '253', 'nama'=>'Mesin Las', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '254', 'nama'=>'Mesin Serut Kayu', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '255', 'nama'=>'Pompa Air', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '256', 'nama'=>'Kompresor', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '257', 'nama'=>'Genset', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '259', 'nama'=>'Pemeliharaan dan Suku Cadang Alat PU', 'keterangan'=>'', 'masapakai'=>0],

         	['kodeAlat'=> '261', 'nama'=>'Rompi Kerja', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '262', 'nama'=>'Sepatu Pengaman', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '263', 'nama'=>'Helm Pengaman', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '264', 'nama'=>'Sarung Tangan', 'keterangan'=>'', 'masapakai'=>0],
         	['kodeAlat'=> '265', 'nama'=>'Sepatu Karet', 'keterangan'=>'', 'masapakai'=>0],
            );

        DB::table('alats')->insert($alats);
    }
}
