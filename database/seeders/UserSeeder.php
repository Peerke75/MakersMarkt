<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'role_id' => 1, // user
                'name' => 'user',
                'password' => Hash::make('password'),
                'email' => 'user@example.com',
                'bio' => 'I am user.',
                'is_verified' => true,
            ],
            [
                'role_id' => 2, // admin
                'name' => 'admin',
                'password' => Hash::make('password'),
                'email' => 'admin@example.com',
                'bio' => 'I am admin.',
                'is_verified' => true,
            ],
            [
                'role_id' => 1, // User
                'name' => 'Mees',
                'password' => Hash::make('123456789'),
                'email' => 'meesvopstal06@hotmail.com',
                'bio' => 'ik ben een sigma.',
                'is_verified' => true,
            ]
        ]);
    }
}
