<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=array(
         	['username'=>'dyah','nama'=> 'Dyah Parama Iswari', 'email'=>'dyah@gmail.com', 'password'=>bcrypt('123456'), 'level'=>'admin'],
         	['username'=>'sintya','nama'=> 'Sintya Ridho Pamungkas', 'email'=>'sintya@gmail.com', 'password'=>bcrypt('123456'), 'level'=>'admin'],
         	['username'=>'rev','nama'=> 'Revaldy Aji Himawan', 'email'=>'revaldy@gmail.com', 'password'=>bcrypt('123456'), 'level'=>'admin'],
            );

        DB::table('users')->insert($users);
    }
}
