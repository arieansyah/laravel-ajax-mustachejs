<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert(array(
       [
        'name' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('admin123'),
        'level' => 1
       ],
       [
        'name' => 'dokter',
        'email' => 'dokter@gmail.com',
        'password' => bcrypt('dokter123'),
        'level' => 2
       ]
     ));
    }
}
