<?php

use Illuminate\Database\Seeder;

class ProyekTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $proyeks=array(
         	['kodeProyek'=> '001', 'kodeCustomer'=>'001', 'uraian'=>'IGD', 'jenis'=>'', 'volume'=>100, 'waktu'=>30, 'tanggalMulai'=>'2017-07-31', 'id_manager'=> '1'],
         	['kodeProyek'=> '002', 'kodeCustomer'=>'001', 'uraian'=>'HDC', 'jenis'=>'', 'volume'=>100, 'waktu'=>30, 'tanggalMulai'=>'2017-08-07', 'id_manager'=> '1'],
         	['kodeProyek'=> '003', 'kodeCustomer'=>'005', 'uraian'=>'Container Yard Rail Semarang', 'jenis'=>'', 'volume'=>100, 'waktu'=>30, 'tanggalMulai'=>'2017-09-01', 'id_manager'=> '1'],
            ['kodeProyek'=> '004', 'kodeCustomer'=>'006', 'uraian'=>'SMK Telkom Sidoarjo', 'jenis'=>'', 'volume'=>100, 'waktu'=>30, 'tanggalMulai'=>'2017-09-01', 'id_manager'=> '1'],
            );

        DB::table('proyeks')->insert($proyeks);
    }
}
