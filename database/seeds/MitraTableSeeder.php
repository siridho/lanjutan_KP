<?php

use Illuminate\Database\Seeder;

class MitraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mitra_kerjas=array(
         	['kodeMitra'=> '001', 'nama'=>'UD Sumber Bahagia', 'alamat'=>'Tenggilis Mejoyo', 'telepon'=>'03186667878', 'email'=>'udsumberbahagia@gmail.com', 'npwp'=>'8827687788', 'kontakNama'=>'Pak Joko', 'kontakTelepon'=>'0888672767'],
            );

        DB::table('mitra_kerjas')->insert($mitra_kerjas);
    }
}
