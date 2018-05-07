<?php

use Illuminate\Database\Seeder;

class MaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materials=array(
         	['kodeMaterial'=> '111', 'nama'=>'Beton Ready Mix', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '112', 'nama'=>'Besi Polos', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '113', 'nama'=>'Besi Ulir', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '114', 'nama'=>'Kawat Beton', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '115', 'nama'=>'Semen', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '116', 'nama'=>'Pasir Beton', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '117', 'nama'=>'Kerikil / Batu Pecah', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '119', 'nama'=>'Piranti Pengecoran', 'satuan'=>'', 'keterangan'=>''],

         	['kodeMaterial'=> '121', 'nama'=>'Material Pasak Vertikal', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '122', 'nama'=>'Kelengkapan Pasak Vertikal', 'satuan'=>'', 'keterangan'=>''],

         	['kodeMaterial'=> '131', 'nama'=>'Sirtu', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '132', 'nama'=>'Pasir Urug', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '133', 'nama'=>'Tanah Urug', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '139', 'nama'=>'Piranti Pengurugan', 'satuan'=>'', 'keterangan'=>''],

         	['kodeMaterial'=> '141', 'nama'=>'Kayu perancah (Scafolding)', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '142', 'nama'=>'Kayu Bangunan', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '143', 'nama'=>'Triplek', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '144', 'nama'=>'Multiplek', 'satuan'=>'', 'keterangan'=>''],

         	['kodeMaterial'=> '151', 'nama'=>'Kabel', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '152', 'nama'=>'Lampu', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '153', 'nama'=>'Piranti Elektrikal', 'satuan'=>'', 'keterangan'=>''],

         	['kodeMaterial'=> '161', 'nama'=>'Oli dan Cat', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '162', 'nama'=>'Paku dan Mur/Baut', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '163', 'nama'=>'Piranti Penampung Air', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '169', 'nama'=>'Piranti Kecil Lain-lain', 'satuan'=>'', 'keterangan'=>''],

         	['kodeMaterial'=> '191', 'nama'=>'Ongkos Kirim Material', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '192', 'nama'=>'Ongkos Bongkar Muat Material', 'satuan'=>'', 'keterangan'=>''],
         	['kodeMaterial'=> '193', 'nama'=>'PPN Material', 'satuan'=>'', 'keterangan'=>''],
            );

        DB::table('materials')->insert($materials);
    }
}
