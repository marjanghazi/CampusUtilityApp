<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@campus.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Teacher',
            'email' => 'teacher@campus.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Student',
            'email' => 'student@campus.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);
    }
}
