<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers=array(
         	['kodeCustomer'=> '001', 'nama'=>'RSUD Sidoarjo', 'alamat'=>'Jl. Mojopahit No.667, Celep, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur', 'area'=>'Sidoarjo',  'telepon'=>'(031)8961649', 'email'=>'rsudsda@mail.com', 'npwp'=>'', 'kontakNama'=>'RSUD Sidoarjo', 'kontakTelepon'=>''],
         	['kodeCustomer'=> '002', 'nama'=>'RSUD Sumenep', 'alamat'=>'Jl. DR. Cipto No.35, Kolor, Kotasumenep, Kabupaten Sumenep, Jawa Timur', 'area'=>'Sumenep',  'telepon'=>'(0328)666788', 'email'=>'rsudsmp', 'npwp'=>'', 'kontakNama'=>'RSUD Sumenep', 'kontakTelepon'=>'(0328)666788'],
         	['kodeCustomer'=> '003', 'nama'=>'UIN Pekanbaru', 'alamat'=>'Jl. Subrantas KM. 15, Rimba Panjang, Tambang, Rimba Panjang, Tambang, Kota Pekanbaru, Riau', 'area'=>'Pekanbaru',  'telepon'=>'', 'email'=>'uinpbr@mail.com', 'npwp'=>'', 'kontakNama'=>'UIN Pekanbaru', 'kontakTelepon'=>''],
         	['kodeCustomer'=> '004', 'nama'=>'Dinas Pendidikan Jakarta', 'alamat'=>'Jl. Jenderal Gatot Subroto Kav. 40-41, Kuningan Timur, Setiabudi', 'area'=>'Jakarta',  'telepon'=>'', 'email'=>'', 'npwp'=>'', 'kontakNama'=>'', 'kontakTelepon'=>''],
         	['kodeCustomer'=> '005', 'nama'=>'Pelindo III', 'alamat'=>'Jalan Coaster No.10, Semarang Utara, Tanjung Mas, Semarang, Kota Semarang, Jawa Tengah', 'area'=>'Semarang',  'telepon'=>'(024)3545721', 'email'=>'pelindoIII@mail.com', 'npwp'=>'23121321', 'kontakNama'=>'Pelindo III', 'kontakTelepon'=>'(024)3545721'],
            ['kodeCustomer'=> '006', 'nama'=>'Telkom', 'alamat'=>'', 'area'=>'Sidoarjo',  'telepon'=>'', 'email'=>'', 'npwp'=>'', 'kontakNama'=>'Telkom', 'kontakTelepon'=>''],
            );

        DB::table('customers')->insert($customers);
    }
}
