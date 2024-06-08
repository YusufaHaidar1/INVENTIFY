<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_user' => 1,
                'id_role' => 1,
                'nama' => 'Yusufa Haidar',
                'email' => 'haidardewa@gmail.com',
                'no_hp' => '081234567890',
                'username' => 'admin',
                'password' => Hash::make('123456')
            ],
            [
                'id_user' => 2,
                'id_role' => 2,
                'nama' => 'Richard Santana',
                'email' => 'RSSantana@yahoo.com',
                'no_hp' => '087569321458',
                'username' => 'verifikator',
                'password' => Hash::make('123456')
            ]
        ];
        DB::table('users')->insert($data);
    }
}
