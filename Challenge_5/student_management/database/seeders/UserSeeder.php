<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
            ->insert([
                'user_name'=> 'biennd',
                'name' => 'Nguyen Dinh Bien',
                'email' => 'bien.uet279@gmail.com',
                'password' => Hash::make('yeuthuong'),
                'phone' => '0344713854',
                'role_id' => DB::table('roles')->where('name', 'admin')->first()->id
            ]);
        DB::table('users')
            ->insert([
                'user_name'=> 'bien',
                'name' => 'Nguyen Dinh Bien',
                'email' => 'bien191020069@gmail.com',
                'password' => Hash::make('yeuthuong'),
                'phone' => '0344713854',
                'role_id' => DB::table('roles')->where('name', 'student')->first()->id
            ]);
    }
}
