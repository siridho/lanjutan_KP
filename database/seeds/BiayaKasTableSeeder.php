<?php

use Illuminate\Database\Seeder;

class BiayaKasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $biayakas=array(
            ['kodeBiayaKas'=> '311', 'nama'=>'Upah Pekerjaan Tanah', 'satuan'=>'', 'keterangan'=>0],
         	['kodeBiayaKas'=> '312', 'nama'=>'Upah Bekisting', 'satuan'=>'', 'keterangan'=>0],
         	['kodeBiayaKas'=> '313', 'nama'=>'Upah Beton', 'satuan'=>'', 'keterangan'=>0],
         	['kodeBiayaKas'=> '314', 'nama'=>'Upah Pemadatan', 'satuan'=>'', 'keterangan'=>0],
         	['kodeBiayaKas'=> '315', 'nama'=>'Upah Pekerjaan Umum', 'satuan'=>'', 'keterangan'=>0],

         	['kodeBiayaKas'=> '32', 'nama'=>'Upah Harian', 'satuan'=>'', 'keterangan'=>0],
         	['kodeBiayaKas'=> '321', 'nama'=>'Upah Tukang Harian', 'satuan'=>'', 'keterangan'=>0],
         	['kodeBiayaKas'=> '322', 'nama'=>'Upah Kuli Harian', 'satuan'=>'', 'keterangan'=>0],
         	['kodeBiayaKas'=> '323', 'nama'=>'Upah Pekerja Logistik', 'satuan'=>'', 'keterangan'=>0],
         	['kodeBiayaKas'=> '324', 'nama'=>'Upah Keamanan', 'satuan'=>'', 'keterangan'=>0],
         	['kodeBiayaKas'=> '325', 'nama'=>'Upah Pekerja Umum', 'satuan'=>'', 'keterangan'=>0],

         	['kodeBiayaKas'=> '411', 'nama'=>'Biaya Personal Lapangan', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '412', 'nama'=>'Konsumsi/Akomodasi Lapangan', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '413', 'nama'=>'Pulsa/Komunikasi Lapangan', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '414', 'nama'=>'BBM/Transport Lapangan', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '415', 'nama'=>'Sewa Kendaraan Lapangan', 'satuan'=>'', 'keterangan'=>0],

            ['kodeBiayaKas'=> '42', 'nama'=>'Biaya Lab dan Keahlian', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '421', 'nama'=>'Uji Laborat', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '422', 'nama'=>'Biaya Jasa Lab', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '423', 'nama'=>'Biaya Jasa Tenaga Ahli', 'satuan'=>'', 'keterangan'=>0],

            ['kodeBiayaKas'=> '511', 'nama'=>'Biaya Perlengkapan Kantor', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '512', 'nama'=>'Biaya Administrasi Kantor', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '513', 'nama'=>'Biaya ATK, Kertas, Tinta', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '519', 'nama'=>'Biaya Umum Kantor', 'satuan'=>'', 'keterangan'=>0],

            ['kodeBiayaKas'=> '52', 'nama'=>'Biaya Mess', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '521', 'nama'=>'Biaya Perlengkapan Mess', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '522', 'nama'=>'Biaya Sewa Mess', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '529', 'nama'=>'Biaya Umum Mess', 'satuan'=>'', 'keterangan'=>0],

            ['kodeBiayaKas'=> '53', 'nama'=>'Biaya Pertemuan dan Jamuan', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '531', 'nama'=>'Biaya Rapat Internal', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '532', 'nama'=>'Biaya Jamuan Mitra Proyek', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '533', 'nama'=>'Biaya Jamuan Tamu', 'satuan'=>'', 'keterangan'=>0],

            ['kodeBiayaKas'=> '54', 'nama'=>'Biaya Kantor Direksi', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '541', 'nama'=>'Biaya Direksi di Proyek', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '542', 'nama'=>'Biaya Tak Langsung Direksi', 'satuan'=>'', 'keterangan'=>0],
            ['kodeBiayaKas'=> '549', 'nama'=>'Biaya Umum Lain-lain', 'satuan'=>'', 'keterangan'=>0],
            );

        DB::table('biaya_kas')->insert($biayakas);
    }
}
