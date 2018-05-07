<?php

use Illuminate\Database\Seeder;

class JenisBiayaProyekTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenisbiayaproyek=array(
        	['kodeJenisBiaya'=> '1', 'nama'=>'MATERIAL', 'satuan'=>''],
        	['kodeJenisBiaya'=> '11', 'nama'=>'Beton', 'satuan'=>''],
         	['kodeJenisBiaya'=> '111', 'nama'=>'Beton Ready Mix', 'satuan'=>''],
         	['kodeJenisBiaya'=> '112', 'nama'=>'Besi Polos', 'satuan'=>''],
         	['kodeJenisBiaya'=> '113', 'nama'=>'Besi Ulir', 'satuan'=>''],
         	['kodeJenisBiaya'=> '114', 'nama'=>'Kawat Beton', 'satuan'=>''],
         	['kodeJenisBiaya'=> '115', 'nama'=>'Semen', 'satuan'=>''],
         	['kodeJenisBiaya'=> '116', 'nama'=>'Pasir Beton', 'satuan'=>''],
         	['kodeJenisBiaya'=> '117', 'nama'=>'Kerikil / Batu Pecah', 'satuan'=>''],
         	['kodeJenisBiaya'=> '119', 'nama'=>'Piranti Pengecoran', 'satuan'=>''],

         	['kodeJenisBiaya'=> '12', 'nama'=>'Pasak Vertikal', 'satuan'=>''],
         	['kodeJenisBiaya'=> '121', 'nama'=>'Material Pasak Vertikal', 'satuan'=>''],
         	['kodeJenisBiaya'=> '122', 'nama'=>'Kelengkapan Pasak Vertikal', 'satuan'=>''],

         	['kodeJenisBiaya'=> '13', 'nama'=>'Urugan', 'satuan'=>''],
         	['kodeJenisBiaya'=> '131', 'nama'=>'Sirtu', 'satuan'=>''],
         	['kodeJenisBiaya'=> '132', 'nama'=>'Pasir Urug', 'satuan'=>''],
         	['kodeJenisBiaya'=> '133', 'nama'=>'Tanah Urug', 'satuan'=>''],
         	['kodeJenisBiaya'=> '139', 'nama'=>'Piranti Pengurugan', 'satuan'=>''],

         	['kodeJenisBiaya'=> '14', 'nama'=>'Kayu', 'satuan'=>''],
         	['kodeJenisBiaya'=> '141', 'nama'=>'Kayu perancah (Scafolding)', 'satuan'=>''],
         	['kodeJenisBiaya'=> '142', 'nama'=>'Kayu Bangunan', 'satuan'=>''],
         	['kodeJenisBiaya'=> '143', 'nama'=>'Triplek', 'satuan'=>''],
         	['kodeJenisBiaya'=> '144', 'nama'=>'Multiplek', 'satuan'=>''],

         	['kodeJenisBiaya'=> '15', 'nama'=>'Elektrikal', 'satuan'=>''],
         	['kodeJenisBiaya'=> '151', 'nama'=>'Kabel', 'satuan'=>''],
         	['kodeJenisBiaya'=> '152', 'nama'=>'Lampu', 'satuan'=>''],
         	['kodeJenisBiaya'=> '153', 'nama'=>'Piranti Elektrikal', 'satuan'=>''],

         	['kodeJenisBiaya'=> '16', 'nama'=>'Aneka Material dan Piranti Kecil', 'satuan'=>''],
         	['kodeJenisBiaya'=> '161', 'nama'=>'Oli dan Cat', 'satuan'=>''],
         	['kodeJenisBiaya'=> '162', 'nama'=>'Paku dan Mur/Baut', 'satuan'=>''],
         	['kodeJenisBiaya'=> '163', 'nama'=>'Piranti Penampung Air', 'satuan'=>''],
         	['kodeJenisBiaya'=> '169', 'nama'=>'Piranti Kecil Lain-lain', 'satuan'=>''],

         	['kodeJenisBiaya'=> '19', 'nama'=>'Ongkos Lain Material', 'satuan'=>''],
         	['kodeJenisBiaya'=> '191', 'nama'=>'Ongkos Kirim Material', 'satuan'=>''],
         	['kodeJenisBiaya'=> '192', 'nama'=>'Ongkos Bongkar Muat Material', 'satuan'=>''],
         	['kodeJenisBiaya'=> '193', 'nama'=>'PPN Material', 'satuan'=>''],



         	['kodeJenisBiaya'=> '2', 'nama'=>'ALAT', 'satuan'=>''],
         	['kodeJenisBiaya'=> '21', 'nama'=>'Alat Pekerjaan Tanah', 'satuan'=>''],
            ['kodeJenisBiaya'=> '211', 'nama'=>'Truk Dumper (Dump Truck)', 'satuan'=>''],
            ['kodeJenisBiaya'=> '212', 'nama'=>'Mesin Singkup-keruk (Backhoe)', 'satuan'=>''],
            ['kodeJenisBiaya'=> '213', 'nama'=>'Derek (Crane)', 'satuan'=>''],
            ['kodeJenisBiaya'=> '214', 'nama'=>'Ekskavator', 'satuan'=>''],
         	['kodeJenisBiaya'=> '219', 'nama'=>'Pemeliharaan dan Suku Cadang Alat Tanah', 'satuan'=>''],

         	['kodeJenisBiaya'=> '22', 'nama'=>'Bekisting', 'satuan'=>''],
         	['kodeJenisBiaya'=> '221', 'nama'=>'Sewa Bekisting', 'satuan'=>''],
         	['kodeJenisBiaya'=> '222', 'nama'=>'Pasang-bongkar Bekisting', 'satuan'=>''],
         	['kodeJenisBiaya'=> '229', 'nama'=>'Pemeliharaan dan Suku Cadang Bekisting', 'satuan'=>''],

         	['kodeJenisBiaya'=> '23', 'nama'=>'Alat Pekerjaan Beton', 'satuan'=>''],
         	['kodeJenisBiaya'=> '231', 'nama'=>'Alat Potong Besi', 'satuan'=>''],
         	['kodeJenisBiaya'=> '232', 'nama'=>'Alat Pembengkok Tulangan', 'satuan'=>''],
         	['kodeJenisBiaya'=> '233', 'nama'=>'Catut', 'satuan'=>''],
         	['kodeJenisBiaya'=> '234', 'nama'=>'Pencampur Beton', 'satuan'=>''],
         	['kodeJenisBiaya'=> '235', 'nama'=>'Penggetar Beton', 'satuan'=>''],
         	['kodeJenisBiaya'=> '239', 'nama'=>'Pemeliharaan dan Suku Cadang Alat Beton', 'satuan'=>''],

         	['kodeJenisBiaya'=> '24', 'nama'=>'Alat Pekerjaan Pemadatan Urugan', 'satuan'=>''],
         	['kodeJenisBiaya'=> '241', 'nama'=>'Mesin Vibrator', 'satuan'=>''],
         	['kodeJenisBiaya'=> '249', 'nama'=>'Pemeliharaan dan Suku Cadang Alat Pemadatan', 'satuan'=>''],

         	['kodeJenisBiaya'=> '25', 'nama'=>'Alat Pekerjaan Umum', 'satuan'=>''],
         	['kodeJenisBiaya'=> '251', 'nama'=>'Alat Pemetaan', 'satuan'=>''],
         	['kodeJenisBiaya'=> '252', 'nama'=>'Gerobak Sorong', 'satuan'=>''],
         	['kodeJenisBiaya'=> '253', 'nama'=>'Mesin Las', 'satuan'=>''],
         	['kodeJenisBiaya'=> '254', 'nama'=>'Mesin Serut Kayu', 'satuan'=>''],
         	['kodeJenisBiaya'=> '255', 'nama'=>'Pompa Air', 'satuan'=>''],
         	['kodeJenisBiaya'=> '256', 'nama'=>'Kompresor', 'satuan'=>''],
         	['kodeJenisBiaya'=> '257', 'nama'=>'Genset', 'satuan'=>''],
         	['kodeJenisBiaya'=> '259', 'nama'=>'Pemeliharaan dan Suku Cadang Alat PU', 'satuan'=>''],

         	['kodeJenisBiaya'=> '26', 'nama'=>'Alat Kelengkapan Kerja', 'satuan'=>''],
         	['kodeJenisBiaya'=> '261', 'nama'=>'Rompi Kerja', 'satuan'=>''],
         	['kodeJenisBiaya'=> '262', 'nama'=>'Sepatu Pengaman', 'satuan'=>''],
         	['kodeJenisBiaya'=> '263', 'nama'=>'Helm Pengaman', 'satuan'=>''],
         	['kodeJenisBiaya'=> '264', 'nama'=>'Sarung Tangan', 'satuan'=>''],
         	['kodeJenisBiaya'=> '265', 'nama'=>'Sepatu Karet', 'satuan'=>''],



         	['kodeJenisBiaya'=> '3', 'nama'=>'UPAH KERJA', 'satuan'=>''],
         	['kodeJenisBiaya'=> '31', 'nama'=>'Upah Borong', 'satuan'=>''],
         	['kodeJenisBiaya'=> '311', 'nama'=>'Upah Pekerjaan Tanah', 'satuan'=>''],
         	['kodeJenisBiaya'=> '312', 'nama'=>'Upah Bekisting', 'satuan'=>''],
         	['kodeJenisBiaya'=> '313', 'nama'=>'Upah Beton', 'satuan'=>''],
         	['kodeJenisBiaya'=> '314', 'nama'=>'Upah Pemadatan', 'satuan'=>''],
         	['kodeJenisBiaya'=> '315', 'nama'=>'Upah Pekerjaan Umum', 'satuan'=>''],

         	['kodeJenisBiaya'=> '32', 'nama'=>'Upah Harian', 'satuan'=>''],
         	['kodeJenisBiaya'=> '321', 'nama'=>'Upah Tukang Harian', 'satuan'=>''],
         	['kodeJenisBiaya'=> '322', 'nama'=>'Upah Kuli Harian', 'satuan'=>''],
         	['kodeJenisBiaya'=> '323', 'nama'=>'Upah Pekerja Logistik', 'satuan'=>''],
         	['kodeJenisBiaya'=> '324', 'nama'=>'Upah Keamanan', 'satuan'=>''],
         	['kodeJenisBiaya'=> '325', 'nama'=>'Upah Pekerja Umum', 'satuan'=>''],




         	['kodeJenisBiaya'=> '4', 'nama'=>'BIAYA OPERASI LAPANGAN', 'satuan'=>''],
            ['kodeJenisBiaya'=> '41', 'nama'=>'Biaya Kegiatan Langsung Lapangan', 'satuan'=>''],
            ['kodeJenisBiaya'=> '411', 'nama'=>'Biaya Personal Lapangan', 'satuan'=>''],
            ['kodeJenisBiaya'=> '412', 'nama'=>'Konsumsi/Akomodasi Lapangan', 'satuan'=>''],
            ['kodeJenisBiaya'=> '413', 'nama'=>'Pulsa/Komunikasi Lapangan', 'satuan'=>''],
            ['kodeJenisBiaya'=> '414', 'nama'=>'BBM/Transport Lapangan', 'satuan'=>''],
            ['kodeJenisBiaya'=> '415', 'nama'=>'Sewa Kendaraan Lapangan', 'satuan'=>''],

            ['kodeJenisBiaya'=> '42', 'nama'=>'Biaya Lab dan Keahlian', 'satuan'=>''],
            ['kodeJenisBiaya'=> '421', 'nama'=>'Uji Laborat', 'satuan'=>''],
            ['kodeJenisBiaya'=> '422', 'nama'=>'Biaya Jasa Lab', 'satuan'=>''],
            ['kodeJenisBiaya'=> '423', 'nama'=>'Biaya Jasa Tenaga Ahli', 'satuan'=>''],



            ['kodeJenisBiaya'=> '5', 'nama'=>'BIAYA UMUM PROYEK', 'satuan'=>''],
            ['kodeJenisBiaya'=> '51', 'nama'=>'Biaya Kantor Proyek', 'satuan'=>''],
            ['kodeJenisBiaya'=> '511', 'nama'=>'Biaya Perlengkapan Kantor', 'satuan'=>''],
            ['kodeJenisBiaya'=> '512', 'nama'=>'Biaya Administrasi Kantor', 'satuan'=>''],
            ['kodeJenisBiaya'=> '513', 'nama'=>'Biaya ATK, Kertas, Tinta', 'satuan'=>''],
            ['kodeJenisBiaya'=> '519', 'nama'=>'Biaya Umum Kantor', 'satuan'=>''],

            ['kodeJenisBiaya'=> '52', 'nama'=>'Biaya Mess', 'satuan'=>''],
            ['kodeJenisBiaya'=> '521', 'nama'=>'Biaya Perlengkapan Mess', 'satuan'=>''],
            ['kodeJenisBiaya'=> '522', 'nama'=>'Biaya Sewa Mess', 'satuan'=>''],
            ['kodeJenisBiaya'=> '529', 'nama'=>'Biaya Umum Mess', 'satuan'=>''],

            ['kodeJenisBiaya'=> '53', 'nama'=>'Biaya Pertemuan dan Jamuan', 'satuan'=>''],
            ['kodeJenisBiaya'=> '531', 'nama'=>'Biaya Rapat Internal', 'satuan'=>''],
            ['kodeJenisBiaya'=> '532', 'nama'=>'Biaya Jamuan Mitra Proyek', 'satuan'=>''],
            ['kodeJenisBiaya'=> '533', 'nama'=>'Biaya Jamuan Tamu', 'satuan'=>''],

            ['kodeJenisBiaya'=> '54', 'nama'=>'Biaya Kantor Direksi', 'satuan'=>''],
            ['kodeJenisBiaya'=> '541', 'nama'=>'Biaya Direksi di Proyek', 'satuan'=>''],
            ['kodeJenisBiaya'=> '542', 'nama'=>'Biaya Tak Langsung Direksi', 'satuan'=>''],
            ['kodeJenisBiaya'=> '549', 'nama'=>'Biaya Umum Lain-lain', 'satuan'=>''],
            );

        DB::table('jenis_biaya_proyeks')->insert($jenisbiayaproyek);
    }
}
