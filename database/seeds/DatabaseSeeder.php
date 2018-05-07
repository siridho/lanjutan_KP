<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(MaterialTableSeeder::class);
        $this->call(AlatTableSeeder::class);
        $this->call(JenisBiayaProyekTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(BiayaKasTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(ManagerTableSeeder::class);
        $this->call(ProyekTableSeeder::class);
        $this->call(MitraTableSeeder::class);
        $this->call(GudangTableSeeder::class);

        // $this->call(NotaPengeluaranKasTableSeeder::class);
        // $this->call(DetailPengeluaranKasTableSeeder::class);
        // $this->call(NotaBeliMaterialTableSeeder::class);
        // $this->call(DetailBeliMaterialTableSeeder::class);
        // $this->call(NotaTerimaBarangTableSeeder::class);
        // $this->call(DetailTerimaBarangTableSeeder::class);
        // $this->call(NotaPenggunaanMaterialTableSeeder::class);
        // $this->call(DetailPenggunaanMaterialTableSeeder::class);
    }
}
