<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('user')->insert([
            [
                'role_id' => 1, // user
                'username' => 'user',
                'password' => Hash::make('password'),
                'email' => 'user@example.com',
                'bio' => 'I am user.',
                'is_verified' => true,
            ],
            [
                'role_id' => 2, // admin
                'username' => 'admin',
                'password' => Hash::make('password'),
                'email' => 'admin@example.com',
                'bio' => 'I am admin.',
                'is_verified' => true,
            ],
            [
                'role_id' => 1, // User
                'username' => 'Mees',
                'password' => Hash::make('123456789'),
                'email' => 'meesvopstal06@hotmail.com',
                'bio' => 'ik ben een sigma.',
                'is_verified' => true,
            ]
        ]);
    }
}
