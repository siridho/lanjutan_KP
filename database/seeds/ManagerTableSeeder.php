<?php

use Illuminate\Database\Seeder;

class ManagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $managers=array(
         	['kodeManager'=> '001', 'nama'=>'Pak Siddhi', 'alamat'=>'', 'identitas'=>'', 'tanggalMasuk'=>'2017-08-25', 'email'=>'', 'telepon'=>''],
         
            );

        DB::table('manager_proyeks')->insert($managers);
    }
}
