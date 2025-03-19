<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'role_id' => 1,
                'username' => 'user123',
                'name' => 'User',
                'email' => 'user@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'bio' => 'I am user.',
                'is_verified' => true,
                'credits' => 1000.00,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 2,
                'username' => 'admin123',
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'bio' => 'I am admin.',
                'is_verified' => true,
                'credits' => 1000.00,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 2,
                'username' => 'Dylano12345',
                'name' => 'Dylano',
                'email' => 'dqdebie@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('test12345'),
                'bio' => 'Ik ben een sigma.',
                'is_verified' => true,
                'credits' => 1000.00,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 2,
                'username' => 'Mnighter',
                'name' => 'Malik',
                'email' => 'test@test.nl',
                'email_verified_at' => now(),
                'password' => Hash::make('testtest'),
                'bio' => 'Ik ben een sigma.',
                'is_verified' => true,
                'credits' => 1000.00,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
